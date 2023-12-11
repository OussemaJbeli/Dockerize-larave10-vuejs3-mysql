<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Items;
use App\Models\Ticket;
use App\Models\Target_limit;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{

    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::back()
        ->with('success', 'user update successfuly');  
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')
        ->with('success', 'user destroy successfuly');
    }


    //theme
    public function updateTheme(User $user , $theme_id)
    {
        $user->filter = "#".$theme_id;
        $user->save();
        return Redirect::back()
        ->with('success', 'filter update successfuly');  

    }

    //sid_img
    public function updateSideImg(User $user , $sid_img_id): RedirectResponse
    {
        $user->sid_img = 'icon/sid_bar/wallpapers/'.$sid_img_id;
        $user->save();
        return Redirect::back()
        ->with('success', 'side image update successfuly');  
    }

    //avatar
    public function updateAvatar(User $user , $avatar): RedirectResponse
    {
        $user->avatar = 'icon/sid_bar/avatar/'.$avatar;
        $user->save();
        return Redirect::back()
        ->with('success', 'avatar update successfuly');  
    }
}
