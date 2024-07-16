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
            'file' => 'required|mimes:doc,docx|max:2048',
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




        return view('admin.documents.fill', compact('document', 'htmlContent', 'documentPlaceholdersIds', 'userDocumentResponses'));
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
    private function convertDocToHtml($filePath)
    {
        Log::info('Converting document to HTML: ' . $filePath);

        if (!file_exists($filePath)) {
            Log::error('File does not exist: ' . $filePath);
            throw new \Exception('File does not exist: ' . $filePath);
        }

        $phpWord = IOFactory::load($filePath);
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');

        // Ensure list elements are preserved
        // $htmlWriter->getWriterPart('Document')->setUseXHTML(true);

        // Ensure list elements are preserved
        //  $htmlWriter->getWriterPart('Document')->setUseLists(true);


        $htmlFilePath = storage_path('app/public/' . basename($filePath, '.docx') . '.html');
        $htmlWriter->save($htmlFilePath);


        $htmlContent = file_get_contents($htmlFilePath);

        return $htmlContent;
    }


    public function replacePlaceholdersWithEditableSpans($htmlContent)
    {

        $text = preg_replace('/<[^>]*>/', '', $htmlContent);


        // romove tags

        // Find all content between {MC_ST} and {MC_EN}
        $mcqs = [];
        $startTag = '{MC_ST}';
        $endTag = '{MC_EN}';
        $start = 0;

        $index = 0;

        while (($start = strpos($text, $startTag, $start)) !== false) {
            $start += strlen($startTag);
            $end = strpos($text, $endTag, $start);
            if ($end !== false) {
                $content = substr($text, $start, $end - $start);

                $mcqs[] = trim($content);
                $start = $end + strlen($endTag);
            } else {
                break;
            }
        }

        // dd($mcqs);

        // Process each content block to extract headings and options
        $htmlOutput = '';
        foreach ($mcqs as $index =>  $content) {
            $headingStartTag = '{MCH_ST}';
            $headingEndTag = '{MCH_EN}';
            $optionStartTag = '{MCO_ST}';
            $optionEndTag = '{MCO_EN}';

            // Extract heading
            $headingStart = strpos($content, $headingStartTag) + strlen($headingStartTag);
            $headingEnd = strpos($content, $headingEndTag);
            $heading = substr($content, $headingStart, $headingEnd - $headingStart);

            // Extract options
            $options = [];
            $optionStart = 0;
            while (($optionStart = strpos($content, $optionStartTag, $optionStart)) !== false) {
                $optionStart += strlen($optionStartTag);
                $optionEnd = strpos($content, $optionEndTag, $optionStart);
                if ($optionEnd !== false) {
                    $option = substr($content, $optionStart, $optionEnd - $optionStart);
                    $options[] = trim($option);
                    $optionStart = $optionEnd + strlen($optionEndTag);
                } else {
                    break;
                }
            }


            // Generate HTML
            $htmlOutput .= '<div class="content-block">';
            $htmlOutput .= '<p>' . htmlspecialchars($heading) . '</p>';
            foreach ($options as $optionIndex => $option) {
                $htmlOutput .= '<div class="form-check">';
                $htmlOutput .= '<input class="form-check-input" type="radio" name="option' . $index . '" id="option' . $index . '-' . $optionIndex . '">';
                $htmlOutput .= '<label class="form-check-label" for="option' . $index . '-' . $optionIndex . '">' . htmlspecialchars($option) . '</label>';
                $htmlOutput .= '</div>';
            }
            $htmlOutput .= '</div>';


            // find the first occurence of the {MC_ST} in the htmlContent
            // $start = strpos($htmlContent, '{MC_ST}');
            // $end = strpos($htmlContent, '{MC_EN}') + strlen('{MC_EN}');

            // remove the content between {MC_ST} and {MC_EN}
            // $htmlContent = substr_replace($htmlContent, '', $start, $end - $start);

            // insert the generated HTML in the place of the removed content
            // $htmlContent = substr_replace($htmlContent, $htmlOutput, $start, 0);

        }

        // dd($htmlOutput, $htmlContent);


        // dd($htmlOutput, $htmlContent);

        $htmlContent = preg_replace('/{MC_ST}.*{MC_EN}/s', $htmlOutput, $htmlContent);

        // dd($htmlContent);

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

    private function sanitizeHtml($html)
    {
        // Create a new configuration object
        $config = HTMLPurifier_Config::createDefault();

        // Configure HTMLPurifier
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        $config->set('HTML.Allowed', 'p,b,a[href],i,em,strong,ul,ol,li,br,span');
        $config->set('CSS.AllowedProperties', []);
        $config->set('AutoFormat.RemoveEmpty', true);

        // Create a new HTMLPurifier object
        $purifier = new HTMLPurifier($config);

        // Purify the HTML
        $cleanHtml = $purifier->purify($html);

        return $cleanHtml;
    }
}
