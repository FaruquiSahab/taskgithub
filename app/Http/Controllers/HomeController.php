<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teen = Student::where('age','<','20')->count();
        $above = Student::where('age','>','19')->count();
        $total = Student::count();
        $p1 = ($teen/$total) * 100;
        $p2 = ($above/$total) * 100;
        return view('home',compact('p1','p2'));
    }

    // public function takeRequest(Request $request)
    // {
    //     // return $request->all();
    //     $e_request = encrypt($request->all());
    //     return decrypt($e_request);
    // }
}
