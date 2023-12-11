<?php

namespace App\Http\Controllers\Admin_pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Videos;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class videosadminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function videos()
    {
        $videos = Videos::select(
            'videos.*',
            'chanels.logo_path_chanel as chanel_logo_path',
            'chanels.id as video_chanel_id',
            'chanels.name_chanel as videos_name_chanel')
        ->join('chanels','chanels.id','=','videos.id_chanel')
        ->get();

        $videosData = [];

        foreach ($videos as $video) {
            $minutesDifference = $video->created_at->diffInMinutes(now()); 
            $video->date_count = $this->date_count_function($minutesDifference);

            $videosData[$video->id]['vew_video'] = 0;
            $videosData[$video->id]['like_video'] = 0;
            $videosData[$video->id]['count_comments_video'] = 0;
        }

        // Fetch and update vues
        $videos_vues = Videos::leftJoin('views', 'views.id_video', '=', 'videos.id') 
            ->select(
                'videos.id',
                DB::raw('COALESCE(count(views.id), 0) as vuews_video'),
            )
            ->groupBy('videos.id')
            ->get();

        foreach ($videos_vues as $videos_vue) {
            $videosData[$videos_vue->id]['vew_video'] = $videos_vue->vuews_video;
        }

        // Fetch and update likes
        $videos_likes = Videos::leftJoin('like_videos', 'like_videos.id_video', '=', 'videos.id') 
            ->select(
                'videos.id',
                DB::raw('COALESCE(count(like_videos.id), 0) as likes_video'),
            )
            ->groupBy('videos.id')
            ->get();

        foreach ($videos_likes as $videos_like) {
            $videosData[$videos_like->id]['like_video'] = $videos_like->likes_video;
        }

        // Fetch and update comments
        $videos_coments = Videos::leftJoin('coments', 'coments.id_video', '=', 'videos.id')  
            ->select(
                'videos.id',
                DB::raw('COALESCE(count(coments.id), 0) as coments_video'),
            )
            ->groupBy('videos.id')
            ->get();

        foreach ($videos_coments as $videos_coment) {
            $videosData[$videos_coment->id]['count_comments_video'] = $videos_coment->coments_video;
        }

        // Now, $videosData contains the aggregated data for each video
        foreach ($videos as $video) {
            $video->vew_video = $videosData[$video->id]['vew_video'];
            $video->like_video = $videosData[$video->id]['like_video'];
            $video->count_comments_video = $videosData[$video->id]['count_comments_video'];
        }


        return Inertia::render('admin_pages/videos/index',[
            'videos' => $videos,
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
