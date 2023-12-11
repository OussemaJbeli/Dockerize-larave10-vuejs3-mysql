<?php
//admin

use App\Http\Controllers\Admin_pages\chanelsadminController;
use App\Http\Controllers\Admin_pages\commentsadminController;
use App\Http\Controllers\Admin_pages\homeadminController;
use App\Http\Controllers\Admin_pages\rapportsadminController;
use App\Http\Controllers\Admin_pages\usersadminController;
use App\Http\Controllers\Admin_pages\videosadminController;
//auth
use App\Http\Controllers\auth_pages\chanel_gest_Controller;
use App\Http\Controllers\auth_pages\CommentsController;
use App\Http\Controllers\auth_pages\homeController;
use App\Http\Controllers\auth_pages\historiqueController;
use App\Http\Controllers\auth_pages\hotController;
use App\Http\Controllers\auth_pages\my_chanelController;
use App\Http\Controllers\auth_pages\chanelController;
use App\Http\Controllers\auth_pages\newsController;
use App\Http\Controllers\auth_pages\Play_listController;
use App\Http\Controllers\auth_pages\showVidoeController;
use App\Http\Controllers\auth_pages\subscribeController;
use App\Http\Controllers\auth_pages\supportController;
use App\Http\Controllers\auth_pages\videosController;

//gest
use App\Http\Controllers\gest_pages\welcameController;
use App\Http\Controllers\gest_pages\hotGESTController;
use App\Http\Controllers\gest_pages\newsGESTController;


use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
//likes
///////////like coment
Route::get('/show_video/Coments_AUTH/{id_videos}/add_like', [CommentsController::class, 'Like_coment']);
Route::get('/show_video/Coments_AUTH/{id_videos}/add_Sublike', [CommentsController::class, 'SUBLike_coment']);
///////////like video
Route::get('/show_video/my_videos_AUTH/{id_videos}/add_like', [videosController::class, 'Like_video']);
///////////subscribe
Route::get('/show_video/my_videos_AUTH/{id_chanel}/add_subscribe', [subscribeController::class, 'add_subscribe']);
Route::get('/chanel_AUTH/my_videos_AUTH/{id_chanel}/add_subscribe', [subscribeController::class, 'add_subscribe']);
Route::get('/other_videos_AUTH/my_videos_AUTH/{id_chanel}/add_subscribe', [subscribeController::class, 'add_subscribe']);
Route::get('/other_playlist_AUTH/my_videos_AUTH/{id_chanel}/add_subscribe', [subscribeController::class, 'add_subscribe']);
Route::get('/other_subscribs_AUTH/{id_user}/my_videos_AUTH/{id_chanel}/add_subscribe', [subscribeController::class, 'add_subscribe']);
Route::get('/other_about_AUTH/my_videos_AUTH/{id_chanel}/add_subscribe', [subscribeController::class, 'add_subscribe']);
////////////////gest pages
Route::get('/', [welcameController::class, 'index'])
    ->name('home.gest');

Route::get('/hot_GEST', [hotGESTController::class, 'index'])
    ->name('hot.gest');

Route::get('/news_GEST', [newsGESTController::class, 'index'])
    ->name('news.gest');


//wotsh video
Route::get('show_video_Gest/{id_video}', [showVidoeController::class, 'indexGest'])
    ->name('show_video.showGest');
////////////////Auth pages
Route::get('home_AUTH', [homeController::class, 'index'])
    ->name('home_AUTH')
    ->middleware('auth');
//historique
Route::get('historique_AUTH', [historiqueController::class, 'index'])
    ->name('historique_AUTH')
    ->middleware('auth');

Route::get('historique_AUTH/{id_video}/delete', [historiqueController::class, 'destroyOne'])
    ->name('historique_AUTH.delete_one')
    ->middleware('auth');

Route::get('historique_AUTH/delete', [historiqueController::class, 'destroy'])
    ->name('historique_AUTH.delete')
    ->middleware('auth');

Route::get('hot_AUTH', [hotController::class, 'index'])
    ->name('hot_AUTH')
    ->middleware('auth');

//chanel
//**main */
Route::get('my_chanel_AUTH', [my_chanelController::class, 'index'])
    ->name('my_chanel_AUTH')
    ->middleware('auth');
    //**videos */
    Route::get('my_videos_AUTH', [my_chanelController::class, 'my_videos_AUTH'])
    ->name('my_videos_AUTH')
    ->middleware('auth');

    Route::post('my_videos_AUTH/{id_chanel}/upload_main', [videosController::class, 'upload_main_video'])
    ->name('my_videos_AUTH.uploadmain')
    ->middleware('auth');

    //wotsh video
    Route::get('show_video/{id_video}', [showVidoeController::class, 'index'])
    ->name('show_video.show')
    ->middleware('auth');

    //striks
    Route::get('show_video/striks/{id_video}/striks_main', [videosController::class, 'striks_main_video'])
        ->name('show_video.striks_main')
        ->middleware('auth');
    //delete video
    Route::get('my_videos_AUTH/{id_video}/delete', [VideosController::class, 'destroy'])
    ->name('my_video.delete')
    ->middleware('auth');
    //edite video
    Route::post('my_videos_AUTH/{id_video}/edit', [VideosController::class, 'edit'])
    ->name('my_video.edit')
    ->middleware('auth');

    Route::post('my_videos_AUTH/{id_chanel}/upload', [videosController::class, 'upload_video'])
    ->name('my_videos_AUTH.upload')
    ->middleware('auth');
    //**playlist */
    Route::get('playlist_AUTH', [Play_listController::class, 'playlist_AUTH'])
    ->name('playlist_AUTH')
    ->middleware('auth');

    Route::post('playlist_AUTH/{id_chanel}/create', [Play_listController::class, 'playlist_AUTH_create'])
    ->name('playlist_AUTH.create')
    ->middleware('auth');

    Route::post('playlist_AUTH/{id_playlist}/edit', [Play_listController::class, 'playlist_AUTH_edite'])
    ->name('playlist_AUTH.edite')
    ->middleware('auth');

    Route::get('playlist_AUTH/{id_playlist}/delete', [Play_listController::class, 'playlist_AUTH_delete'])
    ->name('playlist_AUTH.delete')
    ->middleware('auth');

    Route::post('playlist_AUTH/{id_videos}/add_videos', [Play_listController::class, 'playlist_AUTH_add_videos'])
    ->name('playlist_AUTH.add_videos')
    ->middleware('auth');

    Route::get('playlist_AUTH/{id_videos}/delete_videos', [Play_listController::class, 'playlist_AUTH_delete_videos'])
    ->name('playlist_AUTH.delete_videos')
    ->middleware('auth');
    //**about */
    Route::get('my_about_AUTH/{id_chanel}', [my_chanelController::class, 'my_about_AUTH'])
    ->name('my_about_AUTH')
    ->middleware('auth');
    //**subs */
    Route::get('my_subscribs_AUTH', [my_chanelController::class, 'my_subscribs_AUTH'])
    ->name('my_subscribs_AUTH')
    ->middleware('auth');
    //creat chanel
    Route::post('my_chanel_AUTH/create', [my_chanelController::class, 'store'])
    ->name('my_chanel_AUTH.create')
    ->middleware('auth');

    Route::post('my_chanel_AUTH/{id_chanel}/edit', [my_chanelController::class, 'edit'])
    ->name('my_chanel_AUTH.edite')
    ->middleware('auth');

    Route::put('my_chanel_AUTH/{id_chanel}/links', [my_chanelController::class, 'add_links'])
    ->name('my_chanel_AUTH.links')
    ->middleware('auth');

    Route::put('my_chanel_AUTH/{id_link}/remove', [my_chanelController::class, 'remove_links'])
    ->name('my_chanel_AUTH.links_remove')
    ->middleware('auth');

    //creat coment
    Route::get('show_video/Coments_AUTH/{id_videos}/create', [CommentsController::class, 'store'])
    ->name('Coments_AUTH.create')
    ->middleware('auth');

    Route::get('show_video/Coments_AUTH/{id_coments}/createSub', [CommentsController::class, 'storeSub'])
    ->name('Coments_AUTH.createSub')
    ->middleware('auth');

//**other */
    Route::get('chanel_AUTH/{id_chanel}', [chanelController::class, 'index'])
    ->name('other_chanel_AUTH')
    ->middleware('auth');
    //**videos */
    Route::get('other_videos_AUTH/{id_chanel}', [chanelController::class, 'other_videos_AUTH'])
    ->middleware('auth');
    //**playlist */
    Route::get('other_playlist_AUTH/{id_chanel}', [chanelController::class, 'other_playlist_AUTH'])
    ->name('other_playlist_AUTH')
    ->middleware('auth');
    //**about */
    Route::get('other_about_AUTH/{id_chanel}', [chanelController::class, 'other_about_AUTH'])
    ->name('other_about_AUTH')
    ->middleware('auth');
    //**subs */
    Route::get('other_subscribs_AUTH/{id_chanel}/{id_user}', [chanelController::class, 'other_subscribs_AUTH'])
    ->name('other_subscribs_AUTH')
    ->middleware('auth');

//**other gest */
    Route::get('chanel_gest/{id_chanel}', [chanel_gest_Controller::class, 'index'])
    ->name('chanel_gest');

    //**videos */
    Route::get('other_videos_gest/{id_chanel}', [chanel_gest_Controller::class, 'other_videos_AUTH'])
    ->name('other_videos_gest');

    //**playlist */
    Route::get('other_playlist_gest/{id_chanel}', [chanel_gest_Controller::class, 'other_playlist_AUTH'])
    ->name('other_playlist_gest');

    //**about */
    Route::get('other_about_gest/{id_chanel}', [chanel_gest_Controller::class, 'other_about_AUTH'])
    ->name('other_about_gest');

    //**subs */
    Route::get('other_subscribs_gest/{id_chanel}/{id_user}', [chanel_gest_Controller::class, 'other_subscribs_AUTH'])
    ->name('other_subscribs_gest');



    // 

Route::get('news_AUTH', [newsController::class, 'index'])
    ->name('news_AUTH')
    ->middleware('auth');

Route::get('subscribe_AUTH', [subscribeController::class, 'index'])
    ->name('subscribe_AUTH')
    ->middleware('auth');

//support
Route::get('support_AUTH', [supportController::class, 'index'])
    ->name('support_AUTH')
    ->middleware('auth');

Route::get('support_AUTH/create', [supportController::class, 'create'])
    ->name('support_AUTH.create')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


////////////////admin controller

    Route::get('admin_taleb/dashboard', [homeadminController::class, 'dashboard'])
    ->name('admin_taleb.dashboard')
    ->middleware('auth');

    Route::get('admin_taleb/videos', [videosadminController::class, 'videos'])
    ->name('admin_taleb.videos')
    ->middleware('auth');

    //chanels
    Route::get('admin_taleb/chanels', [chanelsadminController::class, 'chanels'])
    ->name('admin_taleb.chanels')
    ->middleware('auth');

    Route::get('admin_taleb/chanels/{id_chanel}/chanels_delete', [chanelsadminController::class, 'chanels_delete'])
    ->name('admin_taleb.chanels_delete')
    ->middleware('auth');
    //COMMENTS
    Route::get('admin_taleb/comments', [commentsadminController::class, 'comments'])
    ->name('admin_taleb.comments')
    ->middleware('auth');
    Route::get('admin_taleb/comments/{id_chanel}/comments_delete', [commentsadminController::class, 'destroy'])
    ->name('admin_taleb.comments_delete')
    ->middleware('auth');

    //rapport
    Route::get('admin_taleb/rapports', [rapportsadminController::class, 'index'])
    ->name('admin_taleb.rapports')
    ->middleware('auth');

    Route::get('admin_taleb/rapports/{id_user}/message', [rapportsadminController::class, 'rapports'])
    ->name('admin_taleb.message')
    ->middleware('auth');

    Route::get('admin_taleb/rapports/{id_user}/delete', [rapportsadminController::class, 'destroy'])
    ->name('admin_taleb.rapports_message_delete')
    ->middleware('auth');

    Route::get('admin_taleb/rapports/{id_user}/create', [rapportsadminController::class, 'create'])
    ->name('admin_taleb.rapports_message_create')
    ->middleware('auth');

    //users
    Route::get('admin_taleb/users', [usersadminController::class, 'index'])
    ->name('admin_taleb.users')
    ->middleware('auth');

    Route::post('admin_taleb/users/{id_user}/chaneg_state_users', [usersadminController::class, 'chaneg_state_users'])
    ->name('admin_taleb.chaneg_state_users')
    ->middleware('auth');

    Route::get('admin_taleb/users/{id_user}/destroy', [usersadminController::class, 'destroy'])
    ->name('admin_taleb.destroy')
    ->middleware('auth');

require __DIR__.'/auth.php';
