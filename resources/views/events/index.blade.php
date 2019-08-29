@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="col-md-8" style="margin-left: 20%;">
            <h3 class="page-title">Events Index</h3>
            <p>
                <a href="{{ route('events.create') }}" class="btn btn-success">Create New Event</a>
            </p>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Events Table
                </div>

                <div class="panel-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Event Title</th>
                                <th>Event Date Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (count($events) > 0)
                                @foreach ($events as $event)
                                    <tr data-entry-id="{{ $event->id }}">
                                        <td field-key='title'>{{ $event->title }}
                                        </td>
                                        <td field-key='start_time'>{{ $event->start_time }}</td>
                                        <td>
                                            <a href="{{ route('events.show',[$event->id]) }}" class="btn btn-xs btn-primary">
                                                View
                                            </a>
                                            <a href="{{ route('events.edit',[$event->id]) }}" class="btn btn-xs btn-info">
                                                Update
                                            </a>
                                            <form style="display: inline-block;" method="DELETE" onsubmit="return confirm('Are You Sure');" action="{{ route('events.destroy',[$event->id]) }}">
                                                <input type="submit" value="Delete" class="btn btn-xs btn-danger">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">No Records</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
