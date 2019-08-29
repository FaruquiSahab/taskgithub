@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Disable Two Factor Authentication(2FA)</div>

                <div class="panel-body">
                    <center>
                        <form class="form-horizontal" role="form" method="GET" action="{{ url('2fa/disable') }}">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">Password</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input class="form-control" type="password" name="password" id="password" required autocomplete="off" autofocus="true">
                                        @if (session('error'))
                                        <div class="alert alert-error">
                                            <code class="alert alert-danger">{{ session('error') }}</code>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-5">
                                        <input class="btn btn-primary  col-md-6" type="submit">
                                    </div>
                                </div>
                        </form>
                    </center>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection