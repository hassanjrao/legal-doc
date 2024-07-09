<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {

        $totalDocuments = Document::count();

        if (auth()->user()->hasRole('admin')) {


            $downloadedDocuments = Document::whereHas('downloadedBy')
                ->with('downloadedBy')
                ->get();

            $totalDownloads = DB::table('document_user')->count();


            $downloadedDocuments = $downloadedDocuments->map(function ($document) use ($totalDownloads) {
                $document->downloaded_by_count = $document->downloadedBy->count();
                // download percentage among all downloaded documents
                $percentage = $totalDownloads > 0 ? ($document->downloaded_by_count / $totalDownloads) * 100 : 0;

                // round to 2 decimal places
                $document->downloaded_by_percentage = round($percentage, 2);

                return $document;
            });
        } else {
            $downloadedDocuments = Document::whereHas('downloadedBy', function ($query) {
                $query->where('user_id', auth()->id());
            })->with(['downloadedBy' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
                ->get();



            $totalDownloads = DB::table('document_user')
                ->where('user_id', auth()->id())
            ->count();

            $downloadedDocuments = $downloadedDocuments->map(function ($document) use ($totalDownloads) {
                $document->downloaded_by_count = $document->downloadedBy->count();
                // dd($document->downloaded_by_count, $document->id);
                // download percentage among all downloaded documents
                $percentage = $totalDownloads > 0 ? ($document->downloaded_by_count / $totalDownloads) * 100 : 0;

                // round to 2 decimal places
                $document->downloaded_by_percentage = round($percentage, 2);

                return $document;
            });
        }



        // order by downloaded_by_count
        $downloadedDocuments = $downloadedDocuments->sortByDesc('downloaded_by_count');



        return view('admin.dashboard.index', compact('totalDocuments', 'downloadedDocuments'));
    }
}
