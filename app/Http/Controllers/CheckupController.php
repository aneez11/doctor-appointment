<?php

namespace App\Http\Controllers;

use App\Models\Checkup;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckupController extends Controller
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
        $request->validate([
            'checkup_info' => 'required'
        ]);
        $data = [
            'date' => Carbon::now()->format('Y-m-d'),
            'checkup_info' => $request->checkup_info,
            'prescriptions' => $request->prescriptions,
            'appointment_id' => $request->appointment_id
        ];
        Checkup::create($data);
        return back()->with('success', 'Checkup Information added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkup  $checkup
     * @return \Illuminate\Http\Response
     */
    public function show(Checkup $checkup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checkup  $checkup
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkup $checkup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkup  $checkup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkup $checkup)
    {
        $request->validate([
            'checkup_info' => 'required'
        ]);
        $data = [
            'checkup_info' => $request->checkup_info,
            'prescriptions' => $request->prescriptions
        ];
        $checkup->update($data);
        return back()->with('success', 'Checkup Information added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkup  $checkup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkup $checkup)
    {
        //
    }
}
