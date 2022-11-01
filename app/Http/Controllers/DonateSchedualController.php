<?php

namespace App\Http\Controllers;

use App\Models\donate_schedual;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DonateSchedualController extends Controller
{
    public function __construct()
    {
        $this->middleware('blood_compare')->only('store');
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
            'message' => trans("response.test"),
            'data' => $donate_schedual,
            
        ] , Response::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
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
            "message" => "Created Successfuly",
            "data" => $donate_schedual,
            
        ] , Response::HTTP_ACCEPTED);

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function show($user_id )
    {
        $user_schedual = donate_schedual::where('id','=',$user_id)->with('user','blood_type')->get();
        return response()->json([
            "message" => "Fetch Data Successfuly",
            "data" => $user_schedual,
            
        ] , Response::HTTP_ACCEPTED);

        // dd($user_schedual); The dd Function is so important for debugging and checking your work
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\donate_schedual  $donate_schedual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $donate_schedual)
    {
            $request->validate([
          $new_amount =  "amount" => 'required|min:1|integer',
        ]);
        donate_schedual::where('id','=',$donate_schedual)->with('user','blood_type')->update([

            "amount" => $request->amount
        ]);
        return response()->json([
            "message" => "Data Updates Successfuly",
            
        ] , Response::HTTP_ACCEPTED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( $user_id)
    {
        if (donate_schedual::where('id')== $user_id) {
            donate_schedual::where('id','=',$user_id)->delete();
            return response()->json([
                "message" => "Data Deleted Successfuly",
            ] , Response::HTTP_ACCEPTED);
        }else {
            return response()->json([
                "message" => "schedual with this id not found ",
            ] , Response::HTTP_NOT_FOUND);
        }
    }
}
