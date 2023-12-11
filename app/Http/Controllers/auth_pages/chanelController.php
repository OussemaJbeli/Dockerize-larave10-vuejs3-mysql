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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class chanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id_chanel_var)
    {   

        $videos = Videos::where('id_chanel', $id_chanel_var)
            ->where('public','عامة')
            ->select('videos.*',DB::raw('COALESCE(count(views.id), 0) as vuews_video'))
            ->leftJoin('views', 'views.id_video', '=', 'videos.id') 
            ->groupBy('videos.id') 
            ->take(10)
            ->get();
            
        foreach ($videos as $video) {
            $minutesDifference = $video->created_at->diffInMinutes(now()); 
            $video->date_count = $this->date_count_function($minutesDifference);
            $video_duration = $video->duration; 
            $video->video_duration = $this->convertDuration($video_duration);
        }

        $Links = Links::where('chanels.id', $id_chanel_var)
            ->leftJoin('users as user_likns', 'user_likns.id', '=', 'links.id_user')
            ->leftJoin('chanels', 'chanels.id_user', '=', 'user_likns.id')
            ->select('links.*') 
            ->get();

        $main_video = Videos::where('id_chanel', $id_chanel_var)
            ->where('public','عامة')
            ->select('videos.*',DB::raw('COALESCE(count(views.id), 0) as vuews_video'))
            ->leftJoin('views', 'views.id_video', '=', 'videos.id')  
            ->where('main_video', true)
            ->groupBy('videos.id')
            ->first();
        //
        $date_count_target_video='';
        if($main_video){
            $record = Videos::find($main_video['id']); // Replace $id with the actual ID of your record
            $currentTime = Carbon::now();
            $minutesDifference = $record->created_at->diffInMinutes($currentTime);
            $date_count_target_video = $this->date_count_function($minutesDifference);
        }
        //

        $chanel = chanels::where('chanels.id', $id_chanel_var)
                ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'chanels.id') 
                ->select(
                    'chanels.*', 
                    DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
                ) 
                ->groupBy('chanels.id')
                ->first();

                setcookie('my_chanel', $chanel, time() + 3600, '/');
                setcookie('my_links', $Links, time() + 3600, '/');

        return Inertia::render('auth_pages/my_chanel_gest/main',[
            'videos' => $videos,
            'main_video' => $main_video,
            'time_test'=> $date_count_target_video,
        ]);

    }
    
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
    public function other_videos_AUTH($id_chanel_var)
    {
        $chanel = chanels::where('chanels.id', $id_chanel_var)
        ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'chanels.id') 
        ->select(
            'chanels.*', 
            DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
        ) 
        ->groupBy('chanels.id')
        ->first();

        setcookie('my_chanel', $chanel, time() + 3600, '/');

        $Links = Links::where('chanels.id', $id_chanel_var)
        ->leftJoin('users as user_likns', 'user_likns.id', '=', 'links.id_user')
        ->leftJoin('chanels', 'chanels.id_user', '=', 'user_likns.id') 
        ->select('links.*') 
        ->get();

        setcookie('my_links', $Links, time() + 3600, '/');

        $videos = Videos::where('id_chanel', $id_chanel_var)
        ->where('public','عامة')
        ->select('videos.*',DB::raw('COALESCE(count(views.id), 0) as vuews_video'))
        ->leftJoin('views', 'views.id_video', '=', 'videos.id') 
        ->groupBy('videos.id') 
        ->get();

        foreach ($videos as $video) {
            $minutesDifference = $video->created_at->diffInMinutes(now()); 
            $video->date_count = $this->date_count_function($minutesDifference);
            $video_duration = $video->duration; 
            $video->video_duration = $this->convertDuration($video_duration);
        }

        return Inertia::render('auth_pages/my_chanel_gest/my_videos',[
            'videos' => $videos,
            'chanel' => chanels::where('chanels.id', $id_chanel_var)
                ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'chanels.id') 
                ->select(
                    'chanels.*', 
                    DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
                ) 
                ->groupBy('chanels.id')
                ->first(),
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
    //play_list
    public function other_playlist_AUTH($id_chanel_var)
    {
        $chanel = chanels::where('chanels.id', $id_chanel_var)
        ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'chanels.id') 
        ->select(
            'chanels.*', 
            DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
        ) 
        ->groupBy('chanels.id')
        ->first();

        setcookie('my_chanel', $chanel, time() + 3600, '/');

        $Links = Links::where('chanels.id', $id_chanel_var)
        ->leftJoin('users as user_likns', 'user_likns.id', '=', 'links.id_user')
        ->leftJoin('chanels', 'chanels.id_user', '=', 'user_likns.id') 
        ->select('links.*') 
        ->get();

        setcookie('my_links', $Links, time() + 3600, '/');

        $play_list = Play_list::where('id_chanel',$id_chanel_var)
        ->get();

        $videos_with_playlist = Videos::where('id_chanel',$id_chanel_var)
        ->where('public','عامة')
        ->join('play_list_transactions', 'play_list_transactions.id_video', '=', 'Videos.id')
        ->select('videos.*','play_list_transactions.*','videos.id as video_id_playlist')
        ->get();

        foreach ($videos_with_playlist as $video) {
            $video_duration = $video->duration; 
            $video->video_duration = $this->convertDuration($video_duration);
        }

        $playlist_counts = Play_list_transactions::select('id_playlist', DB::raw('count(*) as count'))
        ->join('videos', 'videos.id', '=', 'play_list_transactions.id_video') 
        ->where('videos.public','عامة')
        ->groupBy('id_playlist')
        ->get();


        return Inertia::render('auth_pages/my_chanel_gest/play_list',[
            'number_playlist' => $playlist_counts,
            'play_list' => $play_list,
            'videos_with_playlist' => $videos_with_playlist,
            'chanel' => chanels::where('chanels.id', $id_chanel_var)
            ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'chanels.id') 
            ->select(
                'chanels.*', 
                DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
            ) 
            ->groupBy('chanels.id')
            ->first(),
        ]);
    }

    public function other_about_AUTH($id_chanel)
    {
        $chanel = chanels::where('chanels.id', $id_chanel)
        ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'chanels.id') 
        ->select(
            'chanels.*', 
            DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
        ) 
        ->groupBy('chanels.id')
        ->first();

        setcookie('my_chanel', $chanel, time() + 3600, '/');

        $Links = Links::where('chanels.id', $id_chanel)
        ->leftJoin('users as user_likns', 'user_likns.id', '=', 'links.id_user')
        ->leftJoin('chanels', 'chanels.id_user', '=', 'user_likns.id') 
        ->select('links.*') 
        ->get();

        setcookie('my_links', $Links, time() + 3600, '/');

            $chanel = chanels::find($id_chanel);
            $videosNum = Videos::where('id_chanel', $id_chanel)
            ->count();

            $subscribesNum = Subscribe::where('id_chanel', $id_chanel)
            ->count();

            $vuewsNum = Videos::where('id_chanel', $id_chanel)
            ->join('views', 'views.id_video', '=', 'videos.id')
            ->join('chanels', 'chanels.id', '=', 'videos.id_chanel')
            ->count();

            //date   
            $month_name='';
            $dateString = $chanel['created_at'];
            $date = Carbon::parse($dateString);
            switch ($date->translatedFormat('M')) {
                case 'Jan':
                    $month_name = 'يناير';
                break;
                case 'Feb':
                    $month_name = 'فبراير';
                break;
                case 'Mar':
                    $month_name = 'مارس';
                break;
                case 'Apr':
                    $month_name = 'أبريل';
                break;
                case 'May':
                    $month_name = 'مايو';
                break;
                case 'Jun':
                    $month_name = 'يونيو';
                break;
                case 'Jul':
                    $month_name = 'يوليو';
                break;
                case 'Aug':
                    $month_name = 'أغسطس';
                break;
                case 'Sep':
                    $month_name = 'سبتمبر';
                break;
                case 'Oct':
                    $month_name = 'أكتوبر';
                break;
                case 'Nov':
                    $month_name = 'نوفمبر';
                break;
                case 'Dec':
                    $month_name = 'ديسمبر';
                break;
            }
            $date_created = $date->day . ' ' . $month_name . ' ' .$date->translatedFormat('Y') ;

        return Inertia::render('auth_pages/my_chanel_gest/about',[
            'date_created' => $date_created,
            'videosNum' => $videosNum,
            'subscribesNum' => $subscribesNum,
            'vuewsNum' => $vuewsNum,
            'chanel' => chanels::where('chanels.id', $id_chanel)
                ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'chanels.id') 
                ->join('users', 'users.id', '=', 'chanels.id_user') 
                ->select(
                    'chanels.*', 
                    'users.name as user_name',
                    DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
                ) 
                ->groupBy('chanels.id')
                ->first(),
        ]);
    }
    public function other_subscribs_AUTH($id_chanel,$id_user)
    {
        $chanel = chanels::where('chanels.id', $id_chanel)
        ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'chanels.id') 
        ->select(
            'chanels.*', 
            DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
        ) 
        ->groupBy('chanels.id')
        ->first();

        setcookie('my_chanel', $chanel, time() + 3600, '/');

        $Links = Links::where('chanels.id', $id_chanel)
        ->leftJoin('users as user_likns', 'user_likns.id', '=', 'links.id_user')
        ->leftJoin('chanels', 'chanels.id_user', '=', 'user_likns.id') 
        ->select('links.*') 
        ->get();

        setcookie('my_links', $Links, time() + 3600, '/');

        $subscrib_chanel = Subscribe::where('id_subscriber', $id_user)
        ->join('chanels', 'chanels.id', '=', 'subscribes.id_chanel')
        ->get();

        return Inertia::render('auth_pages/my_chanel_gest/sub_chanels',[
            'subscrib_chanel' => $subscrib_chanel,
            'chanel' => chanels::where('chanels.id', $id_chanel)
            ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'chanels.id') 
            ->select(
                'chanels.*', 
                DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
            ) 
            ->groupBy('chanels.id')
            ->first(),
        ]);
    }
}
