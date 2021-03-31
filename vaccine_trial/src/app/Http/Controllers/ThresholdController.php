<?php

namespace App\Http\Controllers;

use App\Threshold;
use App\Vaccination;
use Illuminate\Http\Request;

class ThresholdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positiveCases = Vaccination::where('test', true)->get()->count();
        return response()->json([
            'positive_cases' => $positiveCases,
            'thresh_hold' => Threshold::first()->threshhold
        ]);
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
        //validtation

        $this->validate($request, [
            'threshhold' => 'required | integer'
        ]);

        try {
            $threshold =  Threshold::first();
        if($threshold == null){
            $threshold =  new $threshold();
        }

        $threshold->threshhold = $request->threshhold;
        if($threshold->save()){
            return response()->json([
                'status' => true,
                'message' => 'Threshold updated successfully.'
            ]);
        }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred. Try again later'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Threshold  $threshold
     * @return \Illuminate\Http\Response
     */
    public function show(Threshold $threshold)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Threshold  $threshold
     * @return \Illuminate\Http\Response
     */
    public function edit(Threshold $threshold)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Threshold  $threshold
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Threshold $threshold)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Threshold  $threshold
     * @return \Illuminate\Http\Response
     */
    public function destroy(Threshold $threshold)
    {
        //
    }
}
