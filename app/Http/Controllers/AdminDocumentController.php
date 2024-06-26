<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
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
            ->with(['documentCategory', 'createdBy'])
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
        $document = null;

        $categories = DocumentCategory::all();

        return view('admin.documents.add_edit', compact('document', 'categories'));
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
            'category' => 'required|exists:document_categories,id',
            'file' => 'required|mimes:doc,docx|max:2048',
        ]);

        $document = $request->file('file');
        $path = $document->store('documents');

        $doc = Document::create([
            'title' => $request->title,
            'document_category_id' => $request->category,
            'file_path' => $path,
            'created_by_user_id' => 1,
        ]);

        return redirect()->route('admin.documents.index')->withToastSuccess('Document uploaded successfully');
    }


    // Convert the document to HTML and display the form to fill in placeholders
    public function showFillForm($id)
    {
        $document = Document::findOrFail($id);
        $htmlContent = $this->convertDocToHtml(storage_path('app/public/' . $document->file_path));


        return view('admin.documents.fill', compact('document', 'htmlContent'));
    }

    // Fill placeholders in the document and save the filled document
    public function fill(Request $request)
    {
        $data = $request->input('document_content', '');

        dd($data);

        $editedHtml = $data;

        // Initialize PHPWord
        $phpWord = new PhpWord();

        // Load HTML reader plugin
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');

        // Write edited HTML content to PHPWord
        // $section = $phpWord->addSection();


        // Save PHPWord object as .docx file
        $docxFilePath = storage_path('app/public/edited_document.docx');
        $htmlWriter->save($docxFilePath, 'Word2007');


        return redirect()->route('admin.documents.complete');
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

        // Replace placeholders with editable spans
        // Replace placeholders with editable spans
        $htmlContent = preg_replace('/__+/', '<span class="editable" contenteditable="true">$0</span>', $htmlContent);

        return $htmlContent;
    }


    // Fill placeholders in the HTML content
    private function fillPlaceholdersInHtml(String $htmlContent)
    {
        $index = 0; // To track the current input to replace
        return preg_replace_callback('/_{2,}/', function ($matches) use (&$index, $htmlContent) {
            $index++;
            return $htmlContent;
        }, $htmlContent);
    }


    // Save the filled HTML content back to a Word document
    private function saveHtmlToWord($htmlContent)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $htmlContent, false, false);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/filled_document.docx'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
