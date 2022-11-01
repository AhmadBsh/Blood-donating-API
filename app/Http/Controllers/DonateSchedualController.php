<?php

namespace App\Http\Controllers;

use App\Models\donate_schedual;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DonateSchedualController extends Controller
{
    public function __construct()
    {
        $this->middleware('blood_compare', ['except' => ['login','register']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donate_schedual = donate_schedual::with( 'user','blood_type')->get();
        return response()->json([
            'message' => 'Fetch data done',
            'data' => $donate_schedual,
            
        ] , Response::HTTP_ACCEPTED);
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
            "user_id" => 'required|exists:users,id',
            "amount" => 'required|min:1|integer',
            "blood_type_id" =>'required|exists:blood_types,id',
            "verified" =>'nullable',
        ]);
        $donate_schedual = donate_schedual::create([
            "user_id" =>$request->user_id,
            "amount" =>$request->amount,
            "blood_type_id" =>$request->blood_type_id,
            "verified" =>false,
        ]);
        return response()->json([
            'message' => 'Created Successfuly',
            'data' => $donate_schedual,
            
        ] , Response::HTTP_ACCEPTED);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\donate_schedual  $donate_schedual
     * @return \Illuminate\Http\Response
     */
    public function show(donate_schedual $donate_schedual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\donate_schedual  $donate_schedual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, donate_schedual $donate_schedual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\donate_schedual  $donate_schedual
     * @return \Illuminate\Http\Response
     */
    public function destroy(donate_schedual $donate_schedual)
    {
        //
    }
}
