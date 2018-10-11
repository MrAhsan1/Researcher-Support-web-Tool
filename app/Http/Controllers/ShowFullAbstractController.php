<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResearchPapers;
use DB;
use View;

class ShowFullAbstractController extends Controller
{
    public function showpapers($id)
    {

        $latestpaper = ResearchPapers::limit(5)->orderby('created_at','asc')->get();
        $researchpapers = DB::table('keywords')
                          ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
                          ->join('authors','authors.researchpaper_id','=','research_papers.id')
                          ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
                          ->where(strtolower('keywords.researchpaper_id'),'=',$id)
                          ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
                          ->get();
        return View::make('ResearchPapers.fullabstract')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
                          
       
    }
}
 