<?php

namespace App\Http\Controllers\auth_pages;

use App\Http\Controllers\Controller;
use App\Models\Coments;
use App\Models\Like_comment;
use App\Models\Like_comment_Sub;
use App\Models\Sub_coments;
use App\Models\User;
use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function Like_coment(string $id_coment)
    {
        $like_coments = Like_comment::where('id_coment', $id_coment)
        ->where('id_user', Auth::user()->id)
        ->first();

        if($like_coments){
            $like_coments->delete();
            $likesCount = Like_comment::where('id_coment', $id_coment)->count();
            return response()->json(['success' => true, 'likesCount' => $likesCount]);
        }
        
        $like_coments = new Like_comment();
        $like_coments->id_user = Auth::user()->id;
        $like_coments->id_coment = $id_coment;
        $like_coments->save();

        $likesCount = Like_comment::where('id_coment', $id_coment)->count();
        return response()->json(['success' => true, 'likesCount' => $likesCount]);
        
    }
    public function SUBLike_coment(string $id_SUBcoment)
    {
        $like_coments = Like_comment_sub::where('id_Subcoment', $id_SUBcoment)
        ->where('id_user', Auth::user()->id)
        ->first();

        if($like_coments){
            $like_coments->delete();
            $likesCount = Like_comment_sub::where('id_Subcoment', $id_SUBcoment)->count();
            return response()->json(['success' => true, 'likesCount1' => $likesCount]);
        }
        
        $like_coments = new Like_comment_sub();
        $like_coments->id_user = Auth::user()->id;
        $like_coments->id_Subcoment = $id_SUBcoment;
        $like_coments->save();

        $likesCount = Like_comment_sub::where('id_Subcoment', $id_SUBcoment)->count();
        return response()->json(['success' => true, 'likesCount1' => $likesCount]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,string $id_videos)
    {

        $the_coment = $request->get('the_coment');
        $coments = new Coments();

        $coments->id_user = Auth::user()->id;
        $coments->id_video = $id_videos;
        $coments->the_coment = $the_coment;

        $coments->save();

        return Redirect::back();
        
    }

    public function storeSub(Request $request,string $id_coment)
    {
        $the_coment = $request->get('the_coment');
        $coments = new Sub_coments();

        $coments->id_user_sub_coment = Auth::user()->id;
        $coments->id_coment = $id_coment;
        $coments->the_sub_coment = $the_coment;

        $coments->save();

        return Redirect::back();
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $tickets)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

    }
}
