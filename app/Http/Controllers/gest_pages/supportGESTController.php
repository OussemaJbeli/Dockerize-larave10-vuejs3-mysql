<?php

namespace App\Http\Controllers\gest_pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class supportGESTController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('gest_pages/support/index');
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
