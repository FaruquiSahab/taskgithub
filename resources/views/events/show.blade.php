@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="col-md-8" style="margin-left: 20%;">
            <h3 class="page-title">Event {{ $event->title }}</h3>
            <div class="panel panel-default">
                <div class="panel-heading">
                    View a Event
                </div>

                <div class="panel-body table-responsive">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Event Title</th>
                                    <td field-key='title'>{{ $event->title }}</td>
                                </tr>
                                <tr>
                                    <th>Start Time</th>
                                    <td field-key='start_time'>{{ $event->start_time }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <p>&nbsp;</p>

                    <h2>
                        <a href="{{ route('events.index') }}" class="label label-default">Event Index</a>
                    </h2>
                </div>
            </div>
        </div>
    </div>
@stop

