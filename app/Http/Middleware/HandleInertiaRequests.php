<?php

namespace App\Http\Middleware;

use App\Models\chanels;
use App\Models\Links;
use App\Models\Subscribe;
use App\Models\Video;
use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Support\Facades\DB;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $videos_chanel_target = Videos::join('chanels','chanels.id','=','videos.id_chanel')
        ->select(
            'videos.*',
            'chanels.name_chanel as video_chanel_name',
            'chanels.id as chanel_id',
            'chanels.logo_path_chanel as video_chanel_logo_path',
            DB::raw('COALESCE(count(views.id), 0) as vuews_video')
        )
        ->where('public','عامة')
        ->leftJoin('views', 'views.id_video', '=', 'videos.id')  
        ->orderByRaw('RAND()')
        ->groupBy('chanel_id','videos.id', 'video_chanel_name' , 'video_chanel_logo_path')
        ->get();
        
        foreach ($videos_chanel_target as $video) {
            $minutesDifference = $video->created_at->diffInMinutes(now()); // Replace with your actual date field
            $video->date_count = $this->date_count_function($minutesDifference);
        }

        return array_merge(parent::share($request), [
            'auth' => function () use ($request) {
                return [
                    'user' => $request->user() ? [
                        'id' => $request->user()->id,
                        'name' => $request->user()->name,
                        'email' => $request->user()->email,
                        'avatar' => $request->user()->avatar,
                        'admin' => $request->user()->admin,
                        'super_user' => $request->user()->super_user,
                        'dashboard_control' => $request->user()->dashboard_control,
                        'chanels_control' => $request->user()->chanels_control,
                        'support_control' => $request->user()->support_control,
                        'comments_control' => $request->user()->comments_control,
                        'videos_control' => $request->user()->videos_control,
                    ] : null,
                    'chanel' => $request->user() ? [
                        chanels::where('id_user', Auth::user()->id)
                        ->leftJoin('subscribes', 'subscribes.id_chanel', '=', 'chanels.id') 
                        ->select(
                            'chanels.*', 
                            DB::raw('COALESCE(count(subscribes.id), 0) as count_subscribe')
                        ) 
                        ->groupBy('chanels.id')
                        ->first(),
                    ] : null,
                    'Subscribe' => $request->user() ? [
                        Subscribe::where('id_subscriber', Auth::user()->id)
                        ->count(),
                    ] : null,
                    'links' => $request->user() ? [
                        Links::where('id_user', Auth::user()->id)
                        ->get(),
                    ] : null,
                ];
            },
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
            'videos_chanel_target' => $videos_chanel_target,
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
}
