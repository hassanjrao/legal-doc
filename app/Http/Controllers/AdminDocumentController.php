<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentMultiChoice;
use App\Models\DocumentMultiChoiceOption;
use App\Models\DocumentPlaceHolder;
use App\Models\LawArea;
use App\Models\UserDocumentResponse;
use App\Models\UserMultiChoiceOption;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;
use PhpOffice\PhpWord\Element\TextRun;
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


        $processedContent = $this->replacePlaceholdersWithEditableSpans($htmlContent, [], []);


        // total multi choice questions
        $totalMcqs = $processedContent['totalOptions'];

        foreach ($totalMcqs as $index => $mcq) {
            $documentMultiChoice = DocumentMultiChoice::create([
                'document_id' => $doc->id,
            ]);

            foreach ($mcq as $option) {
                DocumentMultiChoiceOption::create([
                    'document_multi_choice_id' => $documentMultiChoice->id,
                ]);
            }
        }


        $htmlContent = $processedContent['htmlContent'];

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



        $documentPlaceholders = DocumentPlaceHolder::where('document_id', $document->id)->get();


        $documentPlaceholdersIds = $documentPlaceholders->pluck('id')->toArray();


        $userDocumentResponses = UserDocumentResponse::where('document_id', $document->id)
            ->where('user_id', auth()->user()->id)
            ->get();

        $userDocumentResponses = $userDocumentResponses->pluck('response')->toArray();



        $userMultiChoiceOptions = UserMultiChoiceOption::where('document_id', $document->id)
            ->where('user_id', auth()->user()->id)
            ->get();

        $documentMultiChoices = DocumentMultiChoice::where('document_id', $document->id)->get();

        $documentMultiChoices = $documentMultiChoices->map(function ($multiChoice) {

            return [
                'document_multi_choice_id' => $multiChoice->id,
                'options' => $multiChoice->options->pluck('id')->toArray(),
            ];
        });


        $processedContent = $this->replacePlaceholdersWithEditableSpans($htmlContent, $documentMultiChoices, $userMultiChoiceOptions);


        $htmlContent = $processedContent['htmlContent'];

        // remove {D_ST} AND {D_EN} signs
        $htmlContent = $this->deleteSigns($htmlContent);




        return view('admin.documents.fill', compact('document', 'htmlContent', 'documentPlaceholdersIds', 'userDocumentResponses'));
    }

    // Fill placeholders in the document and save the filled document
    public function fill(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:documents,id',
            'placeholders' => 'nullable|array',
            'mcqs' => 'nullable|array',
        ]);

        $placeholders = $request->placeholders;

        $mcqs = $request->mcqs ?? [];

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

        foreach ($mcqs as $mcq) {

            $mcqId = explode('-', $mcq['name'])[1];

            UserMultiChoiceOption::updateOrCreate([
                'user_id' => auth()->user()->id,
                'document_id' => $document->id,
                'document_multi_choice_id' => $mcqId,
            ], [
                'user_id' => auth()->user()->id,
                'document_id' => $document->id,
                'document_multi_choice_id' => $mcqId,
                'document_multi_choice_option_id' => $mcq['value'],
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

        // Ensure list elements are preserved
        // $htmlWriter->getWriterPart('Document')->setUseXHTML(true);

        // Ensure list elements are preserved
        //  $htmlWriter->getWriterPart('Document')->setUseLists(true);


        $htmlFilePath = storage_path('app/public/' . basename($filePath, '.docx') . '.html');
        $htmlWriter->save($htmlFilePath);


        $htmlContent = file_get_contents($htmlFilePath);

        return $htmlContent;
    }


    public function replacePlaceholdersWithEditableSpans($htmlContent, $documentMultiChoices = [], $userMultiChoiceOptions, $isDownloading = false)
    {




        $multiChoice = $this->processMcqs($htmlContent, $documentMultiChoices, $userMultiChoiceOptions, $isDownloading);

        dd($multiChoice);

        // Replace placeholders with editable spans
        $htmlContent = preg_replace('/__+/', '<span class="editable" contenteditable="true">$0</span>', $multiChoice['htmlContent']);





        return [
            'htmlContent' => $htmlContent,
            'totalMcqs' => $multiChoice['totalMcqs'],
            'totalOptions' => $multiChoice['totalOptions']
        ];
    }

    public function deleteSigns($htmlContent)
    {
        $htmlContent = preg_replace('/{D_ST}/', '', $htmlContent);
        $htmlContent = preg_replace('/{D_EN}/', '', $htmlContent);

        return $htmlContent;
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

    public function removeLinesFromWordFile($filePath)
    {
        // Load the Word file
        $phpWord = IOFactory::load($filePath);

        // Iterate through all sections and remove text between {D_ST} and {D_EN}
        foreach ($phpWord->getSections() as $section) {
            $elements = $section->getElements();


            $insideDeleteBlock = false;
            foreach ($elements as $key => $element) {
                if ($element instanceof TextRun) {
                    foreach ($element->getElements() as $textElement) {
                        $text = $textElement->getText();
                        if (strpos($text, '{D_ST}') !== false) {
                            $insideDeleteBlock = true;
                        }

                        if ($insideDeleteBlock) {
                            unset($elements[$key]);
                        }

                        if (strpos($text, '{D_EN}') !== false) {
                            $insideDeleteBlock = false;
                        }

                        dump('TEXXXXTT', $text, strpos($text, '{D_ST}'), $insideDeleteBlock);
                    }
                }
            }
            $section->setElements(array_values($elements));
        }

        // Save the modified document
        $modifiedFilePath = storage_path('app/public/modified_document.docx');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($modifiedFilePath);

        return $modifiedFilePath;
    }



    public function processMcqs($htmlContent, $documentMultiChoices = [], $userMultiChoiceOptions = [], $isDownloading = false)
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


        // Process each content block to extract headings and options
        $htmlOutput = '';
        $totalOptions = [];
        foreach ($mcqs as $index =>  $content) {


            $multiChoiceId = $index;
            $userMultiChoice = null;
            // get the multi choice id according to the index
            if (count($documentMultiChoices) > 0) {

                $multiChoice = $documentMultiChoices[$index];
                $multiChoiceId = $multiChoice['document_multi_choice_id'];

                $userMultiChoice = $userMultiChoiceOptions->where('document_multi_choice_id', $multiChoiceId)->first();
            }




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

                $multiChoiceOptionId = $optionIndex;

                if (count($documentMultiChoices) > 0) {
                    $multiChoiceOptionId = $multiChoice['options'][$optionIndex];
                }

                $isChecked = false;

                if ($userMultiChoice) {
                    $isChecked = $userMultiChoice->document_multi_choice_option_id == $multiChoiceOptionId;
                }



                if ($isDownloading) {
                // if not isChecked, then add between {D_ST} and {D_EN} tags
                    if ($isChecked) {
                        $htmlOutput .= '<span class="editable" style="display:inline" contenteditable="true">' . htmlspecialchars($option) . '</span>';

                    } else {
                        $htmlOutput .= '{D_ST}' . htmlspecialchars($option) . '{D_EN}';
                    }


                } else {

                    $htmlOutput .= '<div class="form-check">';
                    $htmlOutput .= '<input class="form-check-input" type="radio" name="option-' . $multiChoiceId . '" id="option-' . $multiChoiceId . '-' . $multiChoiceOptionId . '" value="' . $multiChoiceOptionId . '" ' . ($isChecked ? 'checked' : '') . '>';
                    $htmlOutput .= '<label class="form-check-label" for="option-' . $multiChoiceId . '-' . $multiChoiceOptionId . '">' . ($option) . '</label>';
                    $htmlOutput .= '</div>';
                }
            }
            $htmlOutput .= '</div><br>';




            $totalOptions[$index] = $options;
        }




        // Replace MCQ content with generated HTML
        $htmlContent = preg_replace('/{MC_ST}.*{MC_EN}/s', $htmlOutput, $htmlContent);


        // remove MC_ST and MC_EN tags and their content
        $htmlContent = preg_replace('/{MC_ST}.*{MC_EN}/s', '', $htmlContent);


        return [
            'htmlContent' => $htmlContent,
            'totalMcqs' => count($mcqs),
            'totalOptions' => $totalOptions
        ];
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

        $userMultiChoiceOptions = UserMultiChoiceOption::where('document_id', $document->id)
            ->where('user_id', auth()->user()->id)
            ->get();


        $documentMultiChoices = DocumentMultiChoice::where('document_id', $document->id)->get();

        $documentMultiChoices = $documentMultiChoices->map(function ($multiChoice) {

            return [
                'document_multi_choice_id' => $multiChoice->id,
                'options' => $multiChoice->options->pluck('id')->toArray(),
            ];
        });



        $processedContent = $this->replacePlaceholdersWithEditableSpans($htmlContent, $documentMultiChoices, $userMultiChoiceOptions, true);

        $htmlContent = $processedContent['htmlContent'];

        $userDocumentResponses = UserDocumentResponse::where('document_id', $document->id)
            ->where('user_id', auth()->user()->id)
            ->get();

        // $userDocumentResponses = $userDocumentResponses->pluck('response')->toArray();

        foreach ($userDocumentResponses as $response) {
            // MAKE response bold
            $resp = '<b>' . $response->response . '</b>';

            // $resp=$response->response;

            // // remove new line characters from response
            // $resp= preg_replace('/\s+/', ' ', $resp);
            $htmlContent = preg_replace('/<span class="editable" contenteditable="true">__+<\/span>/', $resp, $htmlContent, 1);
            // dd($htmlContent,$response);

            // if($response->id==660){
            //     dd($resp,$htmlContent);
            // }
        }


        $htmlContent = $this->sanitizeHtml($htmlContent);


        $htmlContent = $this->removeContentBetweenTags($htmlContent, '{D_ST}', '{D_EN}');

        // dd($htmlContent);

        // dd($htmlContent);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Add HTML content to the section
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $htmlContent);


        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/' . basename($document->file_path, '.docx') . '_filled.docx'));

        $user = auth()->user();
        $user->downloadedDocuments()->attach($document->id);

        return response()->download(storage_path('app/public/' . basename($document->file_path, '.docx') . '_filled.docx'), $document->title . '_filled.docx')->deleteFileAfterSend(true);
    }

    public function sanitizeHtml($html)
    {
        $config = HTMLPurifier_Config::createDefault();

        // Keep styles and other elements
        $config->set('HTML.Allowed', 'div,span,b,strong,i,em,u,ul,ol,li,p,br,table,thead,tbody,tr,td,th,h1,h2,h3,h4,h5,h6,img,a[style|href|title|alt|src|width|height],span[style],custom,custom[style]');
        $config->set('CSS.AllowedProperties', 'color, font-size, font-family, background-color, text-align, text-decoration, font-weight, font-style, border,  padding, margin, width, height');

        $config->set('HTML.AllowedAttributes', 'style,href,src,width,height,alt');


        // Create a new HTMLPurifier object
        $purifier = new HTMLPurifier($config);

        // Purify the HTML
        $cleanHtml = $purifier->purify($html);

        return $cleanHtml;
    }
}
