<?php

namespace App\Http\Controllers\auth_pages;

use App\Http\Controllers\Controller;
use App\Models\Chanels;
use App\Models\Coments;
use App\Models\Historiques;
use App\Models\Like_comment;
use App\Models\Like_comment_Sub;
use App\Models\Like_video;
use App\Models\Sub_coments;
use App\Models\User;
use App\Models\Videos;
use App\Models\Views;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class showVidoeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $vue_video = new Views();
        $vue_video->id_video = $id;
        $vue_video->save();

        $historiques = Historiques::where('id_video', $id)->first();

        if ($historiques) {

        $historiques->updated_at = now();

        $historiques->created_at = now();

        $historiques->save();

        } else {

        $historiques = new Historiques();

        $historiques->id_user = Auth::user()->id;

        $historiques->id_video = $id;

        $historiques->save();

        }

        $chanel_subscribe = Videos::where('videos.id', $id)
        ->join('chanels as video_chanels','video_chanels.id','=','videos.id_chanel')
        ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'video_chanels.id') 
        ->select(
            DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
        ) 
        ->first();

        $target_video = Videos::where('videos.id', $id)
            ->join('chanels as video_chanels','video_chanels.id','=','videos.id_chanel')
            ->leftJoin('like_videos', 'like_videos.id_video', '=', 'videos.id')  
            ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'video_chanels.id')  
            ->select(
                'videos.*', 
                'video_chanels.id as video_chanels_id', 
                'video_chanels.name_chanel as video_chanels_name', 
                'video_chanels.logo_path_chanel as video_chanels_logo_path',
                DB::raw('COALESCE(count(like_videos.id), 0) as count'),
                DB::raw('COALESCE(count(subscribes.id_chanel), 0) as count_subscribe')
            )
            ->groupBy('videos.id', 'video_chanels_id','video_chanels_name' , 'video_chanels_logo_path')
            ->first();

        $target_video_vues = Videos::where('videos.id', $id)  
            ->leftJoin('views', 'views.id_video', '=', 'videos.id') 
            ->select(
                DB::raw('COALESCE(count(views.id), 0) as vuews_video'),
            )
            ->first();

        //
        $record = Videos::find($id); // Replace $id with the actual ID of your record
        $currentTime = Carbon::now();
        $minutesDifference = $record->created_at->diffInMinutes($currentTime);
        $date_count_target_video = $this->date_count_function($minutesDifference);

        //
        $videos = Videos::select(
                'videos.*',
                'video_chanels.id as video_chanels_id',
                'video_chanels.name_chanel as video_chanels_name', 
                'video_chanels.logo_path_chanel as video_chanels_logo_path',
                DB::raw('COALESCE(count(views.id), 0) as vuews_video')
            )
            ->where('public','عامة')
            ->where('videos.id','!=',$id)
            ->join('chanels as video_chanels','video_chanels.id','=','videos.id_chanel')
            ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'video_chanels.id') 
            ->leftJoin('views', 'views.id_video', '=', 'videos.id')  
            ->groupBy('videos.id','video_chanels.id', 'video_chanels.name_chanel' , 'video_chanels.logo_path_chanel')
            ->orderByRaw('RAND()')
            ->get();  
        
            foreach ($videos as $video) {
                $video_duration = $video->duration; 
                $video->video_duration = $this->convertDuration($video_duration);
            }

            $comentsNewst = Coments::where('coments.id_video', $id)
            ->join('users as coments_user', 'coments_user.id', '=', 'coments.id_user')
            ->leftJoin('chanels', 'chanels.id_user', '=', 'coments.id_user')
            ->leftJoin('like_comments', 'like_comments.id_coment', '=', 'coments.id')    
            ->select(
                'coments.*', 
                'chanels.name_chanel as coments_chanels_name', 
                'chanels.logo_path_chanel as coments_chanels_logo_path',
                'chanels.id as coments_chanels_id',
                'coments_user.name as coments_user_name',
                DB::raw('COALESCE(count(like_comments.id), 0) as count')
            )
            ->groupBy('coments.id','coments_chanels_id','coments_user.name', 'chanels.name_chanel', 'chanels.logo_path_chanel')
            ->orderBy('coments.created_at', 'desc')
            ->get();
    
            foreach ($comentsNewst as $video) {
                $minutesDifference = $video->created_at->diffInMinutes(now()); 
                $video->date_count = $this->date_count_function($minutesDifference);
                $video_duration = $video->duration; 
                $video->video_duration = $this->convertDuration($video_duration);
            }

            $comentsLikes = Coments::where('coments.id_video', $id)
            ->join('users as coments_user', 'coments_user.id', '=', 'coments.id_user')
            ->leftJoin('chanels', 'chanels.id_user', '=', 'coments.id_user')
            ->leftJoin('like_comments', 'like_comments.id_coment', '=', 'coments.id')    
            ->select(
                'coments.*', 
                'chanels.name_chanel as coments_chanels_name', 
                'chanels.logo_path_chanel as coments_chanels_logo_path',
                'chanels.id as coments_chanels_id',
                'coments_user.name as coments_user_name',
                DB::raw('COALESCE(count(like_comments.id), 0) as count')
            )
            ->groupBy('coments.id','coments_chanels_id','coments_user.name', 'chanels.name_chanel', 'chanels.logo_path_chanel')
            ->orderBy('count', 'desc')
            ->get();
    
            foreach ($comentsLikes as $video) {
                $minutesDifference = $video->created_at->diffInMinutes(now()); 
                $video->date_count = $this->date_count_function($minutesDifference);
                $video_duration = $video->duration; 
                $video->video_duration = $this->convertDuration($video_duration);
            }

        $Subcoments = Sub_coments::where('coments.id_video', $id)
            ->select(
            'sub_coments.*', 
            'chanels.name_chanel as coments_chanels_name', 
            'chanels.id as coments_chanels_id', 
            'chanels.logo_path_chanel as coments_chanels_logo_path',
            'coments_user.name as coments_user_name',
            DB::raw('COALESCE(count(Like_comment_subs.id), 0) as count')
            )
            ->join('users as coments_user', 'coments_user.id', '=', 'sub_coments.id_user_sub_coment')
            ->join('coments', 'coments.id', '=', 'sub_coments.id_coment')
            ->leftJoin('chanels', 'chanels.id_user', '=', 'sub_coments.id_user_sub_coment')
            ->leftJoin('Like_comment_subs', 'Like_comment_subs.id_Subcoment', '=', 'Sub_coments.id')    
            ->groupBy('sub_coments.id','coments_chanels_id', 'coments_user.name', 'chanels.name_chanel', 'chanels.logo_path_chanel')
            ->orderBy('created_at', 'desc')
            ->get();

            foreach ($Subcoments as $video) {
                $minutesDifference = $video->created_at->diffInMinutes(now()); 
                $video->date_count = $this->date_count_function($minutesDifference);
                $video_duration = $video->duration; 
                $video->video_duration = $this->convertDuration($video_duration);
            }

            $coments_count = Coments::where('id_video',$id)
            ->select(DB::raw('count(*) as count'))
            ->first();

            $Subcoments_count = Sub_coments::select('id_coment', DB::raw('count(*) as count'))
            ->groupBy('id_coment')
            ->get();

        $like_video_count = Like_video::where('id_video', $id)
            ->count();

        return Inertia::render('auth_pages/watch',[
            'target_video_vues' => $target_video_vues,
            'target_video' => $target_video,
            'videos' => $videos,
            'comentsNewst' => $comentsNewst,
            'comentsLikes' => $comentsLikes,
            'coments_count' => $coments_count,
            'Subcoments' => $Subcoments,
            'Subcoments_count' => $Subcoments_count,
            'like_video_count' => $like_video_count,
            'time_test'=> $date_count_target_video,
            'chanel_subscribe' => $chanel_subscribe,
        ]);
    }
    public function indexGest(string $id)//
    {
        $vue_video = new Views();
        $vue_video->id_video = $id;
        $vue_video->save();

        $chanel_subscribe = Videos::where('videos.id', $id)
        ->join('chanels as video_chanels','video_chanels.id','=','videos.id_chanel')
        ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'video_chanels.id') 
        ->select(
            DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
        ) 
        ->first();

        $target_video = Videos::where('videos.id', $id)
            ->join('chanels as video_chanels','video_chanels.id','=','videos.id_chanel')
            ->leftJoin('like_videos', 'like_videos.id_video', '=', 'videos.id')  
            ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'video_chanels.id')  
            ->select(
                'videos.*', 
                'video_chanels.id as video_chanels_id', 
                'video_chanels.name_chanel as video_chanels_name', 
                'video_chanels.logo_path_chanel as video_chanels_logo_path',
                DB::raw('COALESCE(count(like_videos.id), 0) as count'),
                DB::raw('COALESCE(count(subscribes.id_chanel), 0) as count_subscribe')
            )
            ->groupBy('videos.id','video_chanels.id', 'video_chanels.name_chanel' , 'video_chanels.logo_path_chanel')
            ->first();

        $target_video_vues = Videos::where('videos.id', $id)  
            ->leftJoin('views', 'views.id_video', '=', 'videos.id') 
            ->select(
                DB::raw('COALESCE(count(views.id), 0) as vuews_video'),
            )
            ->first();
        //
        $record = Videos::find($id); // Replace $id with the actual ID of your record
        $currentTime = Carbon::now();
        $minutesDifference = $record->created_at->diffInMinutes($currentTime);
        $date_count_target_video = $this->date_count_function($minutesDifference);
        //

        $videos = Videos::select(
                'videos.*',
                'video_chanels.name_chanel as video_chanels_name', 
                'video_chanels.logo_path_chanel as video_chanels_logo_path',
                DB::raw('COALESCE(count(views.id), 0) as vuews_video')
            )
            ->where('public','عامة')
            ->where('videos.id','!=',$id)
            ->join('chanels as video_chanels','video_chanels.id','=','videos.id_chanel')
            ->leftJoin('views', 'views.id_video', '=', 'videos.id')  
            ->orderByRaw('RAND()')
            ->groupBy('videos.id', 'video_chanels.name_chanel' , 'video_chanels.logo_path_chanel')
            ->get();  
        foreach ($videos as $video) {
                $video_duration = $video->duration; 
                $video->video_duration = $this->convertDuration($video_duration);
            }

            $comentsNewst = Coments::where('coments.id_video', $id)
            ->join('users as coments_user', 'coments_user.id', '=', 'coments.id_user')
            ->leftJoin('chanels', 'chanels.id_user', '=', 'coments.id_user')
            ->leftJoin('like_comments', 'like_comments.id_coment', '=', 'coments.id')    
            ->select(
                'coments.*', 
                'chanels.name_chanel as coments_chanels_name', 
                'chanels.logo_path_chanel as coments_chanels_logo_path',
                'chanels.id as coments_chanels_id',
                'coments_user.name',
                DB::raw('COALESCE(count(like_comments.id), 0) as count')
            )
            ->groupBy('coments.id','coments_chanels_id','coments_user.name', 'chanels.name_chanel', 'chanels.logo_path_chanel')
            ->orderBy('coments.created_at', 'desc')
            ->get();
    
            foreach ($comentsNewst as $video) {
                $minutesDifference = $video->created_at->diffInMinutes(now()); 
                $video->date_count = $this->date_count_function($minutesDifference);
            }

            $comentsLikes = Coments::where('coments.id_video', $id)
            ->join('users as coments_user', 'coments_user.id', '=', 'coments.id_user')
            ->leftJoin('chanels', 'chanels.id_user', '=', 'coments.id_user')
            ->leftJoin('like_comments', 'like_comments.id_coment', '=', 'coments.id')    
            ->select(
                'coments.*', 
                'chanels.name_chanel as coments_chanels_name', 
                'chanels.logo_path_chanel as coments_chanels_logo_path',
                'chanels.id as coments_chanels_id',
                'coments_user.name',
                DB::raw('COALESCE(count(like_comments.id), 0) as count')
            )
            ->groupBy('coments.id','coments_chanels_id','coments_user.name', 'chanels.name_chanel', 'chanels.logo_path_chanel')
            ->orderBy('count', 'desc')
            ->get();
    
            foreach ($comentsLikes as $video) {
                $minutesDifference = $video->created_at->diffInMinutes(now()); 
                $video->date_count = $this->date_count_function($minutesDifference);
            }
    

        $Subcoments = Sub_coments::where('coments.id_video', $id)
            ->select(
            'sub_coments.*', 
            'chanels.name_chanel as coments_chanels_name', 
            'chanels.id as coments_chanels_id', 
            'chanels.logo_path_chanel as coments_chanels_logo_path',
            'coments_user.name as coments_user_name',
            DB::raw('COALESCE(count(Like_comment_subs.id), 0) as count')
            )
            ->join('users as coments_user', 'coments_user.id', '=', 'sub_coments.id_user_sub_coment')
            ->join('coments', 'coments.id', '=', 'sub_coments.id_coment')
            ->leftJoin('chanels', 'chanels.id_user', '=', 'sub_coments.id_user_sub_coment')
            ->leftJoin('Like_comment_subs', 'Like_comment_subs.id_Subcoment', '=', 'Sub_coments.id')    
            ->groupBy('sub_coments.id','coments_chanels_id', 'coments_user.name', 'chanels.name_chanel', 'chanels.logo_path_chanel')
            ->orderBy('created_at', 'desc')
            ->get();

            foreach ($Subcoments as $video) {
                $minutesDifference = $video->created_at->diffInMinutes(now()); 
                $video->date_count = $this->date_count_function($minutesDifference);
            }

            $coments_count = Coments::where('id_video',$id)
            ->select(DB::raw('count(*) as count'))
            ->first();
            
            $Subcoments_count = Sub_coments::select('id_coment', DB::raw('count(*) as count'))
            ->groupBy('id_coment')
            ->get();

        $like_video_count = Like_video::where('id_video', $id)
            ->count();

        return Inertia::render('gest_pages/watch',[
            'target_video_vues' => $target_video_vues,
            'target_video' => $target_video,
            'videos' => $videos,
            'comentsNewst' => $comentsNewst,
            'comentsLikes' => $comentsLikes,
            'coments_count' => $coments_count,
            'Subcoments' => $Subcoments,
            'Subcoments_count' => $Subcoments_count,
            'like_video_count' => $like_video_count,
            'time_test'=> $date_count_target_video,
            'chanel_subscribe' => $chanel_subscribe,
        ]);
    }
    function convertDuration($duration) {
        // Parse the duration into hours, minutes, and seconds
        sscanf($duration, "%d:%d:%f", $hours, $minutes, $seconds);
    
        // Convert to total seconds
        $totalSeconds = $hours * 3600 + $minutes * 60 + $seconds;
    
        // Format as hh:mm:ss or mm:ss
        if ($hours > 0) {
            $formattedDuration = sprintf("%02d:%02d:%02d", $hours, floor($totalSeconds / 60), $totalSeconds % 60);
        } else {
            $formattedDuration = sprintf("%02d:%02d", floor($totalSeconds / 60), $totalSeconds % 60);
        }
    
        return $formattedDuration;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function date_count_function($date_minut)
    {
        if($date_minut < 1){
            return 'الآن';
        }
        elseif($date_minut == 1){
            return 'دقيقة';
        }
        elseif($date_minut <= 10){
            return $date_minut.' دقائق';
        }
        elseif($date_minut <= 60 ){
            return $date_minut.' دقيقة';
        }
        elseif($date_minut == 61){
            return 'ساعة';
        }
        elseif($date_minut <= 600){
            return intdiv($date_minut,60).' ساعات';
        }
        elseif($date_minut <= 1440){
            return intdiv($date_minut,60).' ساعة';
        }
        elseif($date_minut == 1441){
            return 'يوم';
        }
        elseif($date_minut <= 14400){
            return intdiv($date_minut,1440).' ايام';
        }
        elseif($date_minut <= 43200){
            return intdiv($date_minut,1440).' يوم';
        }
        elseif($date_minut == 43201){
            return 'شهر';
        }
        elseif($date_minut <= 432000){
            return intdiv($date_minut,43200).' اشهر';
        }
        elseif($date_minut <= 518400){
            return intdiv($date_minut,43200).' شهر';
        }
        elseif($date_minut == 518401){
            return 'سنة';
        }
        elseif($date_minut <= 5184000){
            return intdiv($date_minut,518400).' سنوات';
        }
        else{
            return intdiv($date_minut,518400).' سنة';
        }
    }

    public function create(Request $request,string $id)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,User $user)
    {
        
    }

    private function storeTicket(User $user)
    {

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
