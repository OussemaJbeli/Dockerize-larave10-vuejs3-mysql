<?php

namespace App\Http\Controllers\auth_pages;

use App\Http\Controllers\Controller;
use App\Models\Links;
use App\Models\Play_list;
use App\Models\Play_list_transactions;
use App\Models\Videos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\chanels;
use App\Models\Subscribe;
use App\Models\User;
use App\Models\Views;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;



class Play_listController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //play_list
    public function playlist_AUTH()
    {
        $play_list = Play_list::where('id_user', Auth::user()->id)
        ->get();

        $videos_with_playlist = Videos::where('id_user', Auth::user()->id)
        ->join('play_list_transactions', 'play_list_transactions.id_video', '=', 'Videos.id')
        ->select('videos.*','play_list_transactions.*')
        ->get();

        $playlist_counts = Play_list_transactions::select('id_playlist', DB::raw('count(*) as count'))
        ->groupBy('id_playlist')
        ->get();

        $videos_without_playlist = Videos::where('id_user', Auth::user()->id)
        ->leftJoin('play_list_transactions', 'play_list_transactions.id_video', '=', 'videos.id')
        ->whereNull('play_list_transactions.id_video')
        ->select('videos.*')
        ->get();

        return Inertia::render('auth_pages/my_chanel/play_list',[
            'number_playlist' => $playlist_counts,
            'play_list' => $play_list,
            'videos_with_playlist' => $videos_with_playlist,
            'videos_without_playlist' => $videos_without_playlist,
        ]);
    }

    public function playlist_AUTH_create(string $id_chanel, Request $request)
    {
        $request->validate([
            'img_path' => 'required',
        ]);

        $name = $request->get('name');

        $newPath = public_path('img/chanels/play_list/');
        $img_path = $request->file('img_path');

        $filename_bg = uniqid() . '_' . time() . '.' . $img_path->getClientOriginalExtension();
        $img_path->move($newPath, $filename_bg);
        
        
        $playlist = new Play_list();

        $playlist->id_user = Auth::user()->id;
        $playlist->id_chanel = $id_chanel;
        $playlist->name = $name;
        $filePath = 'img/chanels/play_list/' . $filename_bg;
        $playlist->img_path = $filePath;

        $playlist->save();
        
        return Redirect::back();
    }

    public function playlist_AUTH_edite(string $id, Request $request)
    {
        $name = $request->get('name');

        $newPath = public_path('img/chanels/play_list/');
        $img_path = $request->file('img_path');
        
        if($img_path){
            $filename_bg = uniqid() . '_' . time() . '.' . $img_path->getClientOriginalExtension();
            $img_path->move($newPath, $filename_bg);
        }
        
        $playlist = Play_list::find($id);

        $playlist->name = $name;

        if($img_path != null){
            File::delete($playlist['img_path']);
            $filePath = 'img/chanels/play_list/' . $filename_bg;
            $playlist->img_path = $filePath;
        }

        $playlist->save();
        
        return Redirect::back();
    }

    public function playlist_AUTH_delete(string $id)
    {

        $playlist = Play_list::where('id', $id)
        ->first();

        File::delete($playlist['img_path']);

        Play_list::where('id', $id)
        ->delete();

        return Redirect::back();
    }

    public function playlist_AUTH_add_videos(string $id, Request $request)
    {
        $id_videos = $request->get('id_videos');

        // creat transaction
        $playlist_transaction = new Play_list_transactions();

        $playlist_transaction->id_video = $id_videos;
        $playlist_transaction->id_playlist = $id;

        $playlist_transaction->save();

        return Redirect::back();
    }

    public function playlist_AUTH_delete_videos(string $id)
    {
        // creat transaction
        Play_list_transactions::where('id_video', $id)
        ->delete();
        
        return Redirect::back();
    }
}