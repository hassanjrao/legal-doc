<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentPlaceHolder;
use App\Models\LawArea;
use App\Models\UserDocumentResponse;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class AdminDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $documents = Document::latest()
            ->with(['documentCategory', 'lawArea'])
            ->get();
        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action');
        }

        $document = null;

        $categories = DocumentCategory::all();

        $lawAreas = LawArea::all();

        return view('admin.documents.add_edit', compact('document', 'categories', 'lawAreas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required|exists:document_categories,id',
            'law_area' => 'required|exists:law_areas,id',
            'file' => 'required|mimes:doc,docx',
        ]);

        $document = $request->file('file');
        $path = $document->store('documents');

        $doc = Document::create([
            'title' => $request->title,
            'document_category_id' => $request->type,
            'law_area_id' => $request->law_area,
            'file_path' => $path,
            'created_by_user_id' => auth()->user()->id,
        ]);

        $htmlContent = $this->convertDocToHtml(storage_path('app/public/' . $doc->file_path));

        $htmlContent = $this->replacePlaceholdersWithEditableSpans($htmlContent);

        // count tags which have contenteditable="true"

        $count = preg_match_all('/contenteditable="true"/', $htmlContent);


        // add the entries to DocumentPlaceholder table
        for ($i = 0; $i < $count; $i++) {
            DocumentPlaceHolder::create([
                'document_id' => $doc->id,
            ]);
        }



        return redirect()->route('admin.documents.index')->withToastSuccess('Document uploaded successfully');
    }


    // Convert the document to HTML and display the form to fill in placeholders
    public function showFillForm($id)
    {
        $document = Document::findOrFail($id);
        $htmlContent = $this->convertDocToHtml(storage_path('app/public/' . $document->file_path));

        $htmlContent = $this->replacePlaceholdersWithEditableSpans($htmlContent);

        $documentPlaceholders = DocumentPlaceHolder::where('document_id', $document->id)->get();


        $documentPlaceholdersIds = $documentPlaceholders->pluck('id')->toArray();


        $userDocumentResponses = UserDocumentResponse::where('document_id', $document->id)
            ->where('user_id', auth()->user()->id)
            ->get();

        $userDocumentResponses = $userDocumentResponses->pluck('response')->toArray();


        // remove {D_ST} AND {D_EN} signs
        $htmlContent = $this->deleteSigns($htmlContent);



        return view('admin.documents.fill', compact('document', 'htmlContent', 'documentPlaceholdersIds', 'userDocumentResponses'));
    }

    public function removeCustomTags($html) {
        // This regex pattern will match everything between {D_ST} and {D_EN}, including the tags
        $pattern = '/\{D_ST\}.*?\{D_EN\}/s';
        $cleanHtml = preg_replace($pattern, '', $html);

        return $cleanHtml;
    }


    public function deleteSigns($htmlContent)
    {
        $htmlContent = preg_replace('/{D_ST}/', '', $htmlContent);
        $htmlContent = preg_replace('/{D_EN}/', '', $htmlContent);

        return $htmlContent;
    }

    // Fill placeholders in the document and save the filled document
    public function fill(Request $request)
    {

        $placeholders = $request->placeholders;

        $document = Document::findOrFail($request->id);


        foreach ($placeholders as $placeholder) {

            UserDocumentResponse::updateOrCreate([
                'user_id' => auth()->user()->id,
                'document_id' => $document->id,
                'document_place_holder_id' => $placeholder['id'],
            ], [
                'user_id' => auth()->user()->id,
                'document_id' => $document->id,
                'document_place_holder_id' => $placeholder['id'],
                'response' => $placeholder['value'],
            ]);
        }


        return response()->json(['message' => 'Document filled successfully!'], 200);
    }

    // Convert the document to HTML
    public function convertDocToHtml($filePath)
    {
        Log::info('Converting document to HTML: ' . $filePath);

        if (!file_exists($filePath)) {
            Log::error('File does not exist: ' . $filePath);
            throw new \Exception('File does not exist: ' . $filePath);
        }

        $phpWord = IOFactory::load($filePath);
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');



        $htmlFilePath = storage_path('app/public/' . basename($filePath, '.docx') . '.html');
        $htmlWriter->save($htmlFilePath);


        $htmlContent = file_get_contents($htmlFilePath);

        // Load the HTML content
        $htmlContent = file_get_contents($htmlFilePath);

        // Clean up HTML to remove unnecessary <p> tags
        $htmlContent = $this->cleanUpHtml($htmlContent);

        return $htmlContent;
    }

    public function cleanUpHtml($html) {
        // Remove empty <p> tags or those with just whitespace
        $html = preg_replace('/<p>\s*<\/p>/', '', $html);

        // Merge consecutive <p> tags
        $html = preg_replace('/<\/p>\s*<p>/', ' ', $html);

        // Further processing to merge paragraphs that may have been split incorrectly
        $doc = new \DOMDocument();
        @$doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($doc);

        // find the lines which are inside {D_ST} AND {D_EN} signs

        $lines = $xpath->query('//p[contains(text(), "{D_ST}")]/following-sibling::p[not(contains(text(), "{D_EN}"))]');

        // add all the lines into a p tag

        foreach ($lines as $line) {
            $nextSibling = $line->nextSibling;
            if ($nextSibling && $nextSibling->nodeName === 'p') {
                $line->nodeValue .= ' ' . $nextSibling->nodeValue;
                $line->parentNode->removeChild($nextSibling);
            }
        }

        // Find single-word <p> tags and merge them
        $singleWordParas = $xpath->query('//p[string-length(normalize-space(text())) < 30]');

        foreach ($singleWordParas as $para) {
            $nextSibling = $para->nextSibling;
            if ($nextSibling && $nextSibling->nodeName === 'p') {
                $para->nodeValue .= ' ' . $nextSibling->nodeValue;
                $para->parentNode->removeChild($nextSibling);
            }
        }

        // Save the modified HTML back to a string
        $cleanedHtml = $doc->saveHTML();

        return $cleanedHtml;
    }


    public function replacePlaceholdersWithEditableSpans($htmlContent)
    {

        // Replace placeholders with editable spans
        // Replace placeholders with editable spans
        $htmlContent = preg_replace('/__+/', '<span class="editable" contenteditable="true">$0</span>', $htmlContent);



        return $htmlContent;
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $document = Document::findOrFail($id);
        $htmlContent = $this->convertDocToHtml(storage_path('app/public/' . $document->file_path));

        return view('admin.documents.show', compact('document', 'htmlContent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = Document::findOrFail($id);

        $categories = DocumentCategory::all();

        $lawAreas = LawArea::all();

        return view('admin.documents.add_edit', compact('document', 'categories', 'lawAreas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'type' => 'required|exists:document_categories,id',
            'law_area' => 'required|exists:law_areas,id',
            // 'file' => 'nullable|mimes:doc,docx|max:2048',
        ]);

        $document->update([
            'title' => $request->title,
            'document_category_id' => $request->type,
            'law_area_id' => $request->law_area,
        ]);


        return redirect()->route('admin.documents.index')->withToastSuccess('Document updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        $document->delete();

        return redirect()->route('admin.documents.index')->withToastSuccess('Document deleted successfully');
    }


    public function download($id)
    {
        $document = Document::findOrFail($id);
        // download the document with the file name= document title


        return response()->download(storage_path('app/public/' . $document->file_path), $document->title . '.docx');
    }


    public function removeContentBetweenTags($html, $startTag, $endTag)
    {
        while (strpos($html, $startTag) !== false && strpos($html, $endTag) !== false) {
            $startPos = strpos($html, $startTag);
            $endPos = strpos($html, $endTag) + strlen($endTag);
            $html = substr_replace($html, '', $startPos, $endPos - $startPos);
        }
        return $html;
    }

    public function downloadUserDocument($id)
    {
        $document = Document::findOrFail($id);

        $htmlContent = $this->convertDocToHtml(storage_path('app/public/' . $document->file_path));

        // Sanitize the HTML content

        $htmlContent = $this->replacePlaceholdersWithEditableSpans($htmlContent);


        $userDocumentResponses = UserDocumentResponse::where('document_id', $document->id)
            ->where('user_id', auth()->user()->id)
            ->get();

        $userDocumentResponses = $userDocumentResponses->pluck('response')->toArray();

        foreach ($userDocumentResponses as $response) {
            // MAKE response bold
            $response = '<b>' . ' ' . $response . ' ' . '</b>';
            $htmlContent = preg_replace('/<span class="editable" contenteditable="true">__+<\/span>/', $response, $htmlContent, 1);
        }


        $htmlContent = $this->sanitizeHtml($htmlContent);

                // remove {D_ST} AND {D_EN} signs
                $htmlContent = $this->removeCustomTags($htmlContent);


        // $htmlContent = $this->removeContentBetweenTags($htmlContent, '{D_ST}', '{D_EN}');


        // dd($htmlContent);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Add HTML content to the section
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $htmlContent, false, false);


        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/' . basename($document->file_path, '.docx') . '_filled.docx'));

        $user = auth()->user();
        $user->downloadedDocuments()->attach($document->id);

        return response()->download(storage_path('app/public/' . basename($document->file_path, '.docx') . '_filled.docx'), $document->title . '.docx');
    }

    public function sanitizeHtml($html)
    {
        $config = HTMLPurifier_Config::createDefault();

        // Keep styles and other elements
        $config->set('HTML.Allowed', 'div,span,b,strong,i,em,u,ul,ol,li,p,br,table,thead,tbody,tr,td,th,h1,h2,h3,h4,h5,h6,img,a[style|href|title|alt|src|width|height],span[style]');
        $config->set('CSS.AllowedProperties', 'color, font-size, font-family, background-color, text-align, text-decoration, font-weight, font-style, border, width, height');

        $config->set('HTML.AllowedAttributes', 'style,href,src,width,height,alt');


        // Create a new HTMLPurifier object
        $purifier = new HTMLPurifier($config);

        // Purify the HTML
        $cleanHtml = $purifier->purify($html);

        return $cleanHtml;
    }
}
