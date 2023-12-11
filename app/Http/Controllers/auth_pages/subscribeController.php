<?php

namespace App\Http\Controllers\auth_pages;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class subscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscrib_chanel = Subscribe::where('id_subscriber', Auth::user()->id)
        ->join('chanels', 'chanels.id', '=', 'subscribes.id_chanel')
        ->get();

        return Inertia::render('auth_pages/subscriptions/index',[
            'subscrib_chanel' => $subscrib_chanel,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add_subscribe(string $id_chanel)
    {
        $Subscribe_number = Subscribe::where('id_chanel', $id_chanel)
        ->where('id_subscriber', Auth::user()->id)
        ->first();

        if($Subscribe_number){
            $Subscribe_number->delete();
            $likesCount = Subscribe::where('id_chanel', $id_chanel)->count();
            return response()->json(['success' => true, 'likesCount' => $likesCount]);
        }
        
        $Subscribe_number = new Subscribe();
        $Subscribe_number->id_subscriber = Auth::user()->id;
        $Subscribe_number->id_chanel = $id_chanel;
        $Subscribe_number->save();

        $likesCount = Subscribe::where('id_chanel', $id_chanel)->count();
        return response()->json(['success' => true, 'likesCount' => $likesCount]);
        
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
