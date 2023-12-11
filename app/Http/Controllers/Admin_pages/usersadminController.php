<?php

namespace App\Http\Controllers\Admin_pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class usersadminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $users = User::where('admin', false)->get();

        return Inertia::render('admin_pages/users/index',[
            'users' => $users,
        ]);
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
    public function chaneg_state_users(Request $request, string $id)
    { 
        $dashboard_control = $request->get('dashboard_control');
        $chanels_control = $request->get('chanels_control');
        $support_control = $request->get('support_control');
        $comments_control = $request->get('comments_control');
        $videos_control = $request->get('videos_control');

        $users = User::find($id);

        if ($users) {
            if($dashboard_control || $chanels_control || $support_control || $comments_control || $videos_control){
                $users->super_user = true;
                $users->dashboard_control = $dashboard_control;
                $users->chanels_control = $chanels_control;
                $users->support_control = $support_control;
                $users->comments_control = $comments_control;
                $users->videos_control = $videos_control;
            }
            else{
                $users->super_user = false;
                $users->dashboard_control = $dashboard_control;
                $users->chanels_control = $chanels_control;
                $users->support_control = $support_control;
                $users->comments_control = $comments_control;
                $users->videos_control = $videos_control;
            }
            $users->save();
        }
        return Redirect::back()
        ->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id', $id)
        ->delete();

        return Redirect::back()
        ->with('success', 'تم الحذف بنجاح');
    }
}
