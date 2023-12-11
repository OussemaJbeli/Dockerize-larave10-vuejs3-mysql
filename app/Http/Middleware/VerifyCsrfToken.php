<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'show_video/*',
        'my_chanel_AUTH/*',
        'login',
        'register',
        'logout',
        'playlist_AUTH/*',
        'my_videos_AUTH/*',
        'profile',
        'admin_taleb/*'
    ];
}
