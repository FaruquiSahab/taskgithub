<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Cache;
use DB;

class EventController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
    
    /**
     * Display a listing of Event.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	DB::connection()->enableQueryLog();
        
        $events = Cache::remember('events','60',function(){
        	return Event::all();
        });
        // $events = Event::all();
        $log = DB::getQueryLog();
        print_r($log);
        // return $events;
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating new Event.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created Event in storage.
     *
     * @param  \App\Http\Requests\StoreEventsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = Event::create($request->all());

        return redirect()->route('events.index');
    }


    /**
     * Show the form for editing Event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return view('events.edit', compact('event'));
    }

    /**
     * Update Event in storage.
     *
     * @param  \App\Http\Requests\UpdateEventsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());

        return redirect()->route('events.index');
    }


    /**
     * Display Event.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);

        return view('events.show', compact('event'));
    }


    /**
     * Remove Event from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('admin.events.index');
    }
}
