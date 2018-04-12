<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Meal;
use App\Setting;

class MealsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('meals.index');
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
           'date'   => 'required|date', 
           'time'   => 'required',
           'name'  => 'required|max:255', 
           'calories' => 'required|numeric|min:0|max:99999' 
        ]);
        
        
        $meal = new Meal();
        $meal->user_id = auth()->user()->id;
        $meal->date = Carbon::parse($request->date . " " . $request->time);
        $meal->name = $request->name;
        $meal->calories = $request->calories;
        
        $meal->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $limit = Setting::find($id);
        return response()->json(['setting' => $limit]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
           'date'   => 'required|date', 
           'time'   => 'required',
           'name'  => 'required|max:255', 
           'calories' => 'required|numeric|min:0|max:99999'
        ]);
        
        
        $meal = Meal::find($id);
        $meal->user_id = auth()->user()->id;
        $meal->date = Carbon::parse($request->date . " " . $request->time);
        $meal->name = $request->name;
        $meal->calories = $request->calories;
        
        $meal->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meal = Meal::find($id);
        $meal->delete();
    }
    
    public function search($dates){
        
        if(count($range = explode(",", $dates)) > 1){
            $meals = Meal::where('user_id', auth()->user()->id)->whereRaw("DATE(date) BETWEEN ? and ?", [$range[0], $range[1]])->orderBy('date')->get();
        }else{
            $meals = Meal::where('user_id', auth()->user()->id)->whereDate('date', $dates)->orderBy('date')->get();
        }
        
        return response()->json(['meals' => $meals]);
    }
}
