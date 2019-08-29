<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HandleClosureController extends Controller
{
    /**
     * Show application welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view('welcome');
    }

    /**
     * Return Default Api Request.
     *
     * @return \Illuminate\Http\Response
     */
    public function apiuser(Request $request)
    {
        return $request->user();
    }
}
