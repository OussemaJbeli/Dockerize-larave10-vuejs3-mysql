<?php

namespace App\Http\Controllers\Admin_pages;

use App\Http\Controllers\Controller;
use App\Models\Chanels;
use App\Models\User;
use App\Models\Videos;
use App\Models\Views;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Inertia\Inertia;

class homeadminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $countusers = User::count();
        $countvideos = Videos::count();
        $countChanels = Chanels::count();
        $countusers_have_chanel = User::join('chanels','chanels.id_user','=','users.id')->count();

        //shart data
        $startDate = new DateTime('first day of this month');
        $endDate = new DateTime('last day of this month');

        $dateRange = [];

        while ($startDate <= $endDate) {
            $dateRange[] = $startDate->format('j');
            $startDate->modify('+1 day');
        }
        
        $startDate = Carbon::now()->firstOfMonth(); // Start of the current month
        $endDate = Carbon::now()->endOfMonth(); // End of the current month

        $viewsByDay = Views::select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as views_count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('day')
            ->orderBy('day', 'desc') // Optional: Order by day in descending order
            ->get();
        
        $today = Carbon::today();
        $lastDayOfMonth = $today->endOfMonth();
        $dayNumber = $lastDayOfMonth->day;

        $viewsDay = [];

        for ($i = 1; $i <= $dayNumber; $i++) {
            $viewsDay[$i] = 0; // Initialize with zero views
        }
        
        foreach ($viewsByDay as $views) {
            $viewsDay[$views->day] = $views->views_count;
        }

        //chart 2
        $usersWithoutChannels = User::leftJoin('chanels', 'chanels.id_user', '=', 'users.id')
            ->whereNull('chanels.id_user')
            ->count();

        return Inertia::render('admin_pages/dashboard/index',[
            'countusers' => $countusers,
            'countusers_have_chanel' => $countusers_have_chanel,
            'countvideos' => $countvideos,
            'countChanels' => $countChanels,
            //shart
            'dateRange' => $dateRange,
            'viewsByDay' => $viewsByDay,
            'viewsDay' => $viewsDay,
            'usersWithoutChannels' => $usersWithoutChannels,

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
