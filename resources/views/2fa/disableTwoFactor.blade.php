@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Two Factor Authentication(2FA) Secret Key</div>

                <div class="panel-body">
                    Two Factor Authentication(2FA) has been removed
                    <br /><br />
                    <a href="{{ url('/home') }}">Go Home</a>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection