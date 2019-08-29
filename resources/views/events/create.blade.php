@extends('layouts.app')

    @section('content')
        <div class="col-md-12">
            <div class="col-md-8" style="margin-left: 20%;">
                <center>
                    <h3 class="page-title">Create New Event</h3>
                    <form method="POST" action="{{ route('events.store') }}">
                        {{ csrf_field() }}  
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Create Event
                            </div>
                            
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 form-group">
                                        <label class="control-label">Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Suitable Event Title" required>
                                        <p class="help-block"></p>
                                        @if($errors->has('title'))
                                            <p class="help-block">
                                                {{ $errors->first('title') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 form-group">
                                        <label class="control-label">Event Start Time</label>
                                        <input type="datetime-local" name="start_time" class="form-control" required>
                                        <p class="help-block"></p>
                                        @if($errors->has('start_time'))
                                            <p class="help-block">
                                                {{ $errors->first('start_time') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary">
                    </form>
                </center>
                <h2>
                     <a href="{{ route('events.index') }}" class="label label-default">Event Index</a>
                </h2>
            </div>
        </div>
    @stop

