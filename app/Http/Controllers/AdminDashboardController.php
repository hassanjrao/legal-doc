<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(){

        $totalDocuments=Document::count();

        $downloadedDocuments=Document::whereHas('downloadedBy')
        ->with('downloadedBy')
        ->get();

        $totalDownloads=DB::table('document_user')->count();


        $downloadedDocuments=$downloadedDocuments->map(function($document) use ($totalDownloads){
            $document->downloaded_by_count=$document->downloadedBy->count();
            // download percentage among all downloaded documents
            $percentage = $totalDownloads > 0 ? ($document->downloaded_by_count / $totalDownloads) * 100 : 0;

            // round to 2 decimal places
            $document->downloaded_by_percentage=round($percentage, 2);

            return $document;
        });



        // order by downloaded_by_count
        $downloadedDocuments=$downloadedDocuments->sortByDesc('downloaded_by_count');



        return view('admin.dashboard.index',compact('totalDocuments','downloadedDocuments'));
    }
}
