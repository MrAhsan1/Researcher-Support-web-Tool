<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use View;
use DB;
use App\ResearchPapers;
use App\FavoriteModel;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
	public function my_favorites()
	{
		$favorite = FavoriteModel::where('user_id',auth()->user()->id)->get();
		$latestpaper = ResearchPapers::limit(5)->orderby('created_at','asc')->get();
		$researchpapers = DB::table('favorite_models')
		->join('research_papers','favorite_models.researchpaper_id','=','research_papers.id')
		->join('authors','authors.researchpaper_id','=','research_papers.id')
		->join('keywords','keywords.researchpaper_id','=','research_papers.id')
		->where('favorite_models.user_id','=',auth()->user()->id)
		->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
		->paginate(10);
		if(count($researchpapers)==0)
		{
			return View::make('ResearchPapers.papersmessage')->with('message','No Favorite Papers Found !')->with('latestpaper',$latestpaper);
		}
		else
		{
			return View::make('ResearchPapers.showfavorite')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper)->with('favorite',$favorite);
		}
	}
	public function favoritePaper(Request $request)
	{
		$paper_id = $request['paperId'];
		$is_Favorite = $request['isFavorite'] === 'true';
		$update = false;
		$paper = ResearchPapers::find($paper_id);

		if(!$paper)
		{
			return "No Paper";
		}
		
		$user = Auth::user();
		$favorite = DB::table('favorite_models')->where('researchpaper_id', $paper_id)
						->where('user_id', $user->id)->first();

		if($favorite != null)
		{
			$already_favorite = $favorite->like;
			$update = true;
			if($already_favorite == $is_Favorite)
			{
				$favorite = DB::table('favorite_models')->where('like', $favorite->like)->where('researchpaper_id', $paper_id)
						->where('user_id', $user->id)->delete();

				return "delete";
			}
		}
		else
		{
			$favorite = new FavoriteModel();
			$favorite->like = $is_Favorite;
			$favorite->user_id = $user->id;
			$favorite->researchpaper_id = $paper->id;
			if($update)
			{
				$favorite->update();
			}
			else
			{
				$favorite->save();
			}
			return "Save";
		}
	}


}