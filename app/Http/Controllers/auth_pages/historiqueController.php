<?php

namespace App\Http\Controllers\auth_pages;

use App\Http\Controllers\Controller;
use App\Models\Historiques;
use App\Models\User;
use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class historiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = Carbon::now();
        $day = Carbon::now()->subDays(1);
        $threeday = Carbon::now()->subDays(3);
        $week = Carbon::now()->subWeek();
        $month = Carbon::now()->subMonths();

        //all
        $historique = Historiques::where('historiques.id_user',Auth::user()->id)
        ->join('videos','videos.id','=','historiques.id_video')
        ->leftJoin('views', 'views.id_video', '=', 'videos.id')  
        ->join('chanels as video_chanels','video_chanels.id','=','videos.id_chanel')
        ->select(
            'videos.*',
            'video_chanels.id as video_chanels_id', 
            'video_chanels.name_chanel as video_chanels_name', 
            'video_chanels.logo_path_chanel as video_chanels_logo_path',
            DB::raw('COALESCE(count(views.id), 0) as vuews_video'),
            'historiques.created_at',
        )
        ->groupBy('videos.id', 'video_chanels_id','video_chanels_name' , 'video_chanels_logo_path', 'historiques.created_at')
        ->orderBy('historiques.created_at', 'desc') 
        ->get();

        
        foreach ($historique as $video) {
            $minutesDifference = $video->created_at->diffInMinutes(now()); 
            $video->date_count = $this->date_count_function($minutesDifference);
            $video_duration = $video->duration; 
            $video->video_duration = $this->convertDuration($video_duration);
        }

        //last day
        $last_day = Historiques::where('historiques.id_user',Auth::user()->id)
            ->whereBetween('historiques.created_at', [$day,$now])
            ->join('videos','videos.id','=','historiques.id_video')
            ->leftJoin('views', 'views.id_video', '=', 'videos.id')  
            ->join('chanels as video_chanels','video_chanels.id','=','videos.id_chanel')
            ->select(
                'videos.*',
                'video_chanels.id as video_chanels_id', 
                'video_chanels.name_chanel as video_chanels_name', 
                'video_chanels.logo_path_chanel as video_chanels_logo_path',
                DB::raw('COALESCE(count(views.id), 0) as vuews_video'),
                'historiques.created_at',
            )
            ->groupBy('videos.id', 'video_chanels_id','video_chanels_name' , 'video_chanels_logo_path', 'historiques.created_at')
            ->orderBy('historiques.created_at', 'desc') 
            ->get();

            foreach ($last_day as $video) {
                $minutesDifference = $video->created_at->diffInMinutes(now()); 
                $video->date_count = $this->date_count_function($minutesDifference);
                $video_duration = $video->duration; 
                $video->video_duration = $this->convertDuration($video_duration);
            }
        //last threeday
        $last_three_day = Historiques::where('historiques.id_user',Auth::user()->id)
            ->whereBetween('historiques.created_at', [$threeday,$now])
            ->join('videos','videos.id','=','historiques.id_video')
            ->leftJoin('views', 'views.id_video', '=', 'videos.id')  
            ->join('chanels as video_chanels','video_chanels.id','=','videos.id_chanel')
            ->select(
                'videos.*',
                'video_chanels.id as video_chanels_id', 
                'video_chanels.name_chanel as video_chanels_name', 
                'video_chanels.logo_path_chanel as video_chanels_logo_path',
                DB::raw('COALESCE(count(views.id), 0) as vuews_video'),
                'historiques.created_at',
            )
            ->groupBy('videos.id', 'video_chanels_id','video_chanels_name' , 'video_chanels_logo_path', 'historiques.created_at')
            ->orderBy('historiques.created_at', 'desc') 
            ->get();

            foreach ($last_three_day as $video) {
                $minutesDifference = $video->created_at->diffInMinutes(now()); 
                $video->date_count = $this->date_count_function($minutesDifference);
                $video_duration = $video->duration; 
                $video->video_duration = $this->convertDuration($video_duration);
            }
        //last week
        $last_week = Historiques::where('historiques.id_user',Auth::user()->id)
            ->whereBetween('historiques.created_at', [$week,$now])
            ->join('videos','videos.id','=','historiques.id_video')
            ->leftJoin('views', 'views.id_video', '=', 'videos.id')  
            ->join('chanels as video_chanels','video_chanels.id','=','videos.id_chanel')
            ->select(
                'videos.*',
                'video_chanels.id as video_chanels_id', 
                'video_chanels.name_chanel as video_chanels_name', 
                'video_chanels.logo_path_chanel as video_chanels_logo_path',
                DB::raw('COALESCE(count(views.id), 0) as vuews_video'),
                'historiques.created_at',
            )
            ->groupBy('videos.id', 'video_chanels_id','video_chanels_name' , 'video_chanels_logo_path', 'historiques.created_at')
            ->orderBy('historiques.created_at', 'desc') 
            ->get();

            foreach ($last_week as $video) {
                $minutesDifference = $video->created_at->diffInMinutes(now()); 
                $video->date_count = $this->date_count_function($minutesDifference);
                $video_duration = $video->duration; 
                $video->video_duration = $this->convertDuration($video_duration);
            }
        //last month
        $last_month = Historiques::where('historiques.id_user',Auth::user()->id)
            ->whereBetween('historiques.created_at', [$month,$now])
            ->join('videos','videos.id','=','historiques.id_video')
            ->leftJoin('views', 'views.id_video', '=', 'videos.id')  
            ->join('chanels as video_chanels','video_chanels.id','=','videos.id_chanel')
            ->select(
                'videos.*',
                'video_chanels.id as video_chanels_id', 
                'video_chanels.name_chanel as video_chanels_name', 
                'video_chanels.logo_path_chanel as video_chanels_logo_path',
                DB::raw('COALESCE(count(views.id), 0) as vuews_video'),
                'historiques.created_at',
            )
            ->groupBy('videos.id', 'video_chanels_id','video_chanels_name' , 'video_chanels_logo_path', 'historiques.created_at')
            ->orderBy('historiques.created_at', 'desc') 
            ->get();

            foreach ($last_month as $video) {
                $minutesDifference = $video->created_at->diffInMinutes(now()); 
                $video->date_count = $this->date_count_function($minutesDifference);
                $video_duration = $video->duration; 
                $video->video_duration = $this->convertDuration($video_duration);
            }

        
        return Inertia::render('auth_pages/historique/index',[
            'historique' => $historique,
            'last_day' => $last_day,
            'last_three_day' => $last_three_day,
            'last_week' => $last_week,
            'last_month' => $last_month,
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
    public function destroyOne(string $id)
    {
        Historiques::where('id_user', Auth::user()->id)
        ->where('id_video', $id)
        ->delete();

        return Redirect::back();
    }
    public function destroy()
    {
        Historiques::where('id_user', Auth::user()->id)
        ->delete();

        return Redirect::back();
    }
}
