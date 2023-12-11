<?php

namespace App\Http\Controllers\auth_pages;

use App\Http\Controllers\Controller;
use App\Models\Like_video;
use App\Models\User;
use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class videosController extends Controller
{

    public function upload_main_video(Request $request,string $id)
    {
        $request->validate([
            'video_path' => 'required|max:100000',
            'img_path' => 'required',
        ]);
        $name = $request->get('name');
        $public = $request->get('public_states');
        $discription = $request->get('discription');

        //upload img
        //new path
        $newPath = public_path('img/chanels/videos/');
        //get values
        $video_path = $request->file('video_path');
        $img_path = $request->file('img_path');
        $duration='';
        //create name img
        if($video_path){
            $filename_logo = uniqid() . '_' . time() . '.' . $video_path->getClientOriginalExtension();
                    //save uploade
            $video_path->move($newPath, $filename_logo);
            $fullVideoPath = $newPath . $filename_logo;
            $duration = $this->getVideoDuration($fullVideoPath);
        }
        if($img_path){
            $filename_bg = uniqid() . '_' . time() . '.' . $img_path->getClientOriginalExtension();
                    //save uploade
            $img_path->move($newPath, $filename_bg);
        }

        $video = new Videos();

        $video->id_user = Auth::user()->id;
        $video->id_chanel = $id;
        $video->name = $name;
        $video->discription = $discription;
        $video->main_video = true;

        $filePath = 'img/chanels/videos/' . $filename_logo;
        $video->video_path = $filePath;


        $filePath = 'img/chanels/videos/' . $filename_bg;
        $video->img_path = $filePath;

        $video->duration = $duration;
        $video->public = $public;
        $video->save();
        
        return Redirect::back();
    }
    public function upload_video(Request $request,string $id)
    {
        $request->validate([
            'video_path' => 'required|max:100000',
            'img_path' => 'required',
        ]);
        $name = $request->get('name');
        $public = $request->get('public_states');
        $discription = $request->get('discription');

        //upload img
        //new path
        $newPath = public_path('img/chanels/videos/');
        //get values
        $video_path = $request->file('video_path');
        $img_path = $request->file('img_path');
        $duration= '';
        //create name img
        if($video_path){
            $filename_logo = uniqid() . '_' . time() . '.' . $video_path->getClientOriginalExtension();
                    //save uploade
            $video_path->move($newPath, $filename_logo);
            $fullVideoPath = $newPath . $filename_logo;
            $duration = $this->getVideoDuration($fullVideoPath);
        }
        if($img_path){
            $filename_bg = uniqid() . '_' . time() . '.' . $img_path->getClientOriginalExtension();
                    //save uploade
            $img_path->move($newPath, $filename_bg);
        }

        $video = new Videos();

        $video->id_user = Auth::user()->id;
        $video->id_chanel = $id;
        $video->name = $name;
        $video->discription = $discription;
        $video->main_video = false;

        $filePath = 'img/chanels/videos/' . $filename_logo;
        $video->video_path = $filePath;


        $filePath = 'img/chanels/videos/' . $filename_bg;
        $video->img_path = $filePath;

        $video->duration = $duration;
        $video->public = $public;
        $video->save();
        
        return Redirect::back();
    }

    private function getVideoDuration($videoPath)
    {
        try {

            $ffmpegOutput = shell_exec("C:\\ffmpeg\\BtbN\\ffmpeg.exe -i $videoPath 2>&1");
            if ($ffmpegOutput === null) {
                throw new \Exception('shell_exec failed.');
            }

            $durationMatches = [];
            preg_match('/Duration: (.*?),/', $ffmpegOutput, $durationMatches);
            
            return isset($durationMatches[1]) ? $durationMatches[1] : null;
        
        } catch (\Exception $e) {
            return null;
        }

    }
    /**
     * Store a newly created resource in storage.
     */
    public function Like_video(string $id_video)
    {
        $like_coments = Like_video::where('id_video', $id_video)
        ->where('id_user', Auth::user()->id)
        ->first();

        if($like_coments){
            $like_coments->delete();
            $likesCount = Like_video::where('id_video', $id_video)->count();
            return response()->json(['success' => true, 'likesCount' => $likesCount]);
        }
        
        $like_coments = new Like_video();
        $like_coments->id_user = Auth::user()->id;
        $like_coments->id_video = $id_video;
        $like_coments->save();

        $likesCount = Like_video::where('id_video', $id_video)->count();
        return response()->json(['success' => true, 'likesCount' => $likesCount]);
        
    }
    /**
     * Display the specified resource.
     */
    public function striks_main_video(string $id_video)
    {
        $videos = Videos::find($id_video);

        if($videos){
            $videos->strik = true;
        }
        $videos->save();
        
        return Redirect::back()
        ->with('success', 'تم ارسال البلاغ بنجاح  ');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $request->validate([
            'video_path' => 'max:100000',
        ]);
        $name = $request->get('name');
        $public = $request->get('public_states');
        $discription = $request->get('discription');

        //upload img
        //new path
        $newPath = public_path('img/chanels/videos/');
        //get values
        $video_path = $request->file('video_path');
        $img_path = $request->file('img_path');

        //create name img
        $duration= '';
        if($video_path){
            $filename_logo = uniqid() . '_' . time() . '.' . $video_path->getClientOriginalExtension();
                    //save uploade
            $video_path->move($newPath, $filename_logo);
            $fullVideoPath = $newPath . $filename_logo;
            $duration = $this->getVideoDuration($fullVideoPath);
        }
        if($img_path){
            $filename_bg = uniqid() . '_' . time() . '.' . $img_path->getClientOriginalExtension();
                    //save uploade
            $img_path->move($newPath, $filename_bg);
        }



        $videos = Videos::find($id);

        if ($videos) {
            $videos->name = $name;
            $videos->discription = $discription;
            if($video_path != null){
                File::delete($videos['video_path']);
                $filePath = 'img/chanels/videos/' . $filename_logo;
                $videos->video_path = $filePath;
                $videos->duration = $duration;
            }

            if($img_path != null){
                File::delete($videos['img_path']);
                $filePath = 'img/chanels/videos/' . $filename_bg;
                $videos->img_path = $filePath;
            }

            $videos->public = $public;
            $videos->save();
        }
        return Redirect::back();
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
    public function destroy(string $id)
    {


        $videos = Videos::where('id', $id)
        ->first();

        File::delete($videos['video_path']);
        File::delete($videos['img_path']);

        Videos::where('id', $id)
        ->delete();

        return Redirect::back()
        ->with('success', 'تم الحذف بنجاح');
    }
}
