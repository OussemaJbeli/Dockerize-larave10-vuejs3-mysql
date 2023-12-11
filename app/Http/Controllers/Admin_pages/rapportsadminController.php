<?php

namespace App\Http\Controllers\Admin_pages;

use App\Http\Controllers\Controller;
use App\Models\Support;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class rapportsadminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $latestMessages = Support::select(
            'supports.*', 
            'users.name as username',
            'chanels.name_chanel as coments_chanels_name', 
            'chanels.logo_path_chanel as coments_chanels_logo_path',
            'chanels.id as coments_chanels_id',)
        ->leftJoin('chanels', 'chanels.id_user', '=', 'supports.id_user')
        ->join('users', 'users.id', '=', 'supports.id_user')
        ->whereIn('supports.id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('supports')
                ->groupBy('id_user');
        })
        ->get();

        foreach ($latestMessages as $video) {
            $minutesDifference = $video->created_at->diffInMinutes(now()); 
            $video->date_count = $this->date_count_function($minutesDifference);
        }

        return Inertia::render('admin_pages/rapports/index',[
            'rapport' => $latestMessages,
        ]);
    }
    public function rapports(string $id_user)
    {
        $supports = Support::where('supports.id_user',$id_user)
        ->join('users','users.id','=','supports.id_user')
        ->select(
            'supports.*',
            'users.name',
        )
        ->get();

        $userMessage = User::where('users.id',$id_user)
        ->select(
            'users.*', 
            'chanels.name_chanel as coments_chanels_name', 
            'chanels.logo_path_chanel as coments_chanels_logo_path',
            'chanels.id as coments_chanels_id',)
        ->leftJoin('chanels', 'chanels.id_user', '=', 'users.id')
        ->first();

        foreach ($supports as $support) {
            $minutesDifference = $support->created_at->diffInMinutes(now()); 
            $support->date_count = $this->date_count_function($minutesDifference);
        }

        return Inertia::render('admin_pages/rapports/messagering',
            [
                'supports' => $supports,
                'userMessage' => $userMessage,
            ]
        );
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

    /**
     * Store a newly created resource in storage.
     */

    public function create(Request $request,string $id_user)
    {
            $the_message = $request->get('the_message');
            $the_side = $request->get('the_side');
    
            $support = new Support();
    
            $support->id_user = $id_user;
            $support->the_message = $the_message;
            $support->the_side = $the_side;
    
            $support->save();
    
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
    public function destroy(string $id_user)
    {
        Support::where('id_user', $id_user)
        ->delete();

        return Redirect::back()
        ->with('success', 'تم الحذف بنجاح');
    }
}
