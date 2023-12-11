<?php

namespace App\Http\Controllers\auth_pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Videos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class newsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Videos::join('chanels','chanels.id','=','videos.id_chanel')
        ->select(
            'videos.*',
            'chanels.name_chanel as chanel_name',
            'chanels.logo_path_chanel as chanel_logo_path',
            'chanels.id as chanel_id',
            DB::raw('COALESCE(count(views.id), 0) as vuews_video')
        )
        ->where('public','عامة')
        ->leftJoin('views', 'views.id_video', '=', 'videos.id')  
        ->orderBy('videos.created_at', 'desc') 
        ->groupBy('chanels.id','videos.id', 'chanels.name_chanel' , 'chanels.logo_path_chanel')
        ->get();

        foreach ($videos as $video) {
            $minutesDifference = $video->created_at->diffInMinutes(now()); 
            $video->date_count = $this->date_count_function($minutesDifference);
            $video_duration = $video->duration; 
            $video->video_duration = $this->convertDuration($video_duration);
        }

        return Inertia::render('auth_pages/news/index',[
            'videos' => $videos,
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
    public function destroy()
    {

    }
}
