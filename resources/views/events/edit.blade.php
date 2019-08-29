@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="col-md-8" style="margin-left: 20%;">
            <h3 class="page-title">Update Event</h3>
            
            <form method="PUT" action="{{ route('events.update',[$event->id]) }}">

            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Details
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Suitable Event Title" required value="{{ $event->title }}">
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
                            <input type="datetime" name="start_time" class="form-control" required value="{{ $event->start_time }}">
                            <p class="help-block"></p>
                            @if($errors->has('start_time'))
                                <p class="help-block">
                                    {{ $errors->first('start_time') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    
                </div>
                <input style="margin:10px;" type="submit" class="btn btn-primary">
            </form>
            </div>

            
            <h2>
                <a href="{{ route('events.index') }}" class="label label-default">Event Index</a>
            </h2>
        </div>
    </div>
@stop