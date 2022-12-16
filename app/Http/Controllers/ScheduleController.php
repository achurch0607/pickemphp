<?php

namespace App\Http\Controllers;

use App\Models\schedule;
use App\Models\picks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Schedule $schedule, Picks $picks)
    {
        //
        
//        dd($request);
//        $week = $request->input('week');
        //need method to get current week in model
//        dd($request);
        $week = $request->input('week');
        $selectedWeek = $week ? $week : $schedule->getCurrentWeek();
//        dd($week);
        $currentSchedule = $schedule->getWeekSchedule($selectedWeek);
        $expiredGames = $schedule->getExpiredGames($selectedWeek);
        $userPicks = $picks->getCurrentUserPicks();
        
//        dd($currentSchedule);
        
        return view('schedule', compact('currentSchedule', 'selectedWeek', 'userPicks', 'expiredGames'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, schedule $schedule)
    {
        //
        $update = $schedule->insertPicks($request);
        $currentWeek =  16;
        $currentSchedule = $schedule->getWeekSchedule($currentWeek);
//        $this->show($request, $schedule);
        
        return view('schedule', compact('currentSchedule', 'currentWeek'));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(schedule $schedule)
    {
        //
    }
}
