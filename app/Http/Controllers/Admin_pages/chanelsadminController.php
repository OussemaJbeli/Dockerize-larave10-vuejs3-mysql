<?php

namespace App\Http\Controllers\Admin_pages;

use App\Http\Controllers\Controller;
use App\Models\Chanels;
use App\Models\Subscribe;
use App\Models\User;
use App\Models\Videos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class chanelsadminController extends Controller
{

    public function chanels()
    {
        $chanel = chanels::all();
    
                // views            
                $viewsNums = Videos::groupBy('videos.id_chanel')
                ->join('views', 'views.id_video', '=', 'videos.id')
                ->select(
                    'videos.id_chanel',
                    DB::raw('COALESCE(count(views.id), 0) as count_views'))
                ->get();

                // subscribes
                $subscribesNums = Subscribe::groupBy('subscribes.id_chanel')
                ->select(
                    'subscribes.id_chanel',
                    DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe'))
                ->get();

                // videos
                $videosNums = Videos::select(
                    'videos.id_chanel',
                    DB::raw('COALESCE(count(videos.id), 0) as count_videos'))
                ->groupBy('videos.id_chanel')
                ->get();
        // date 
        $month_name = '';  
        foreach ($chanel as $chanels) {
            $chanels->count_subscribe = 0;
            $chanels->count_videos = 0;
            $chanels->count_views = 0;

            foreach ($subscribesNums as $subscribesNum) {
                if($chanels->id === $subscribesNum->id_chanel)
                    $chanels->count_subscribe = $subscribesNum->count_subscribe;
            }

            foreach ($videosNums as $videosNum) {
                if($chanels->id == $videosNum->id_chanel)
                    $chanels->count_videos = $videosNum->count_videos;
            }

            foreach ($viewsNums as $viewsNum) {
                if($chanels->id == $viewsNum->id_chanel)
                    $chanels->count_views = $viewsNum->count_views;
            }

            $dateString = $chanels->created_at;
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
            $chanels->date_create = $date_created;
        }
    
        return Inertia::render('admin_pages/chanels/index', [
            'channels' => $chanel,
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function chanels_delete(string $id)
    {
        $videos = Videos::where('id_chanel', $id)
        ->get();

        foreach ($videos as $video) {
            File::delete($video->video_path);
            File::delete($video->img_path);
        }

        Chanels::where('id', $id)
        ->delete();

        return Redirect::back()
        ->with('success', 'تم الحذف بنجاح');
    }

    /**
     * Store a newly created resource in storage.
     */
}
