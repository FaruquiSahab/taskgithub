<?php

namespace App\Http\Controllers;

use App\Jobs\SendAuthorizeEmail;
use Illuminate\Http\Request;
use App\RedisPivot;
use App\RedisJob;
use App\Student;
use DataTables;
use Session;
use Tail;
use DB;

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
        $this->middleware('authorize');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        for($i = 0; $i < 100; $i++) {
            SendAuthorizeEmail::dispatch();
        }
        $below  = Student::where('age','<','13')->count();
        $teen   = Student::where('age','<','20')->where('age','>','12')->count();
        $above  = Student::where('age','>','19')->count();
        $total  = Student::count();
        $p1 = 0;  $p2 = 0;  $p3 = 0 ;
        if($total>0)
        {
            $p1 = ($teen/$total)    * 100;
            $p2 = ($above/$total)   * 100;
            $p3 = ($below/$total)   * 100;
        }
        return view('home',compact('p1','p2','p3','total'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \DataTables
     */
    public function demodata()
    {
        // Get ALL Students
        DB::statement(DB::raw('set @rownum=0'));
        $redis_pivots = RedisPivot::get(['redis_pivots.*', 
                    DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
        // return DataTables with modified columns
        return DataTables::of($redis_pivots)
        ->addColumn('column1', function($pivot)
        {
            return '<strong>Radnom</strong>';
        })
        ->addColumn('column2', function($pivot)
        {
            return '<strong>Radnom</strong>';
        })
        ->addColumn('column3', function($pivot)
        {
            return '<strong>Radnom</strong>';
        })
        ->addColumn('column4', function($pivot)
        {
            return '<strong>' . $pivot->job_operation . '</strong>';
        })
        // generating UPDATE/DELETE button
        ->addColumn('action', function($pivot)
        {
            return '<a href="#" class="btnupdate btn btn-warning">Update</a>
            <a href="#" class="btndelete btn btn-danger">Delete</a>';
        })
        // render HTML for following columns
        ->rawColumns(['column1', 'column2', 'column3', 'column4','action'])
        ->make(true);
    }
    
    
    
}
