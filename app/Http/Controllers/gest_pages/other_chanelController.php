<?php

namespace App\Http\Controllers\gest_pages;

use App\Http\Controllers\Controller;
use App\Models\Links;
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



class other_chanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id_chanel)
    {   
        $videos = Videos::where('id_user', Auth::user()->id)
            ->select('videos.*')
            ->take(10)
            ->get();

        $main_video = Videos::where('id_user', Auth::user()->id)
            ->where('main_video', true)
            ->first();

        return Inertia::render('auth_pages/other_chanels/main',[
            'videos' => $videos,
            'main_video' => $main_video
        ]);

    }
    public function other_videos_AUTH(string $id_chanel)
    {
        $videos = Videos::where('id_user', Auth::user()->id)
        ->select('videos.*')
        ->get();

        return Inertia::render('auth_pages/other_chanels/my_videos',[
            'videos' => $videos,
        ]);
    }
    public function other_playlist_AUTH(string $id_chanel)
    {
        return Inertia::render('auth_pages/other_chanels/play_list');
    }
    public function other_about_AUTH(string $id_chanel)
    {
            $chanel = chanels::find($id_chanel);
            $videosNum = Videos::where('id_user', Auth::user()->id)
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

        return Inertia::render('auth_pages/my_chanel/about',[
            'date_created' => $date_created,
            'videosNum' => $videosNum,
            'subscribesNum' => $subscribesNum,
            'vuewsNum' => $vuewsNum,
        ]);
    }
    public function other_subscribs_AUTH(string $id_chanel)
    {
        return Inertia::render('auth_pages/other_chanels/sub_chanels');
    }

}
