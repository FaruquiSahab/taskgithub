@extends('layouts.app')


@section('content')
    
<hr>
    <div class="container">
	    <h1><i class="fa fa-user" aria-hidden="true"></i> User Profile</h1>
	  	<hr>
		<div class="row">
	      <!-- left column -->
	      <div class="col-md-3">
	      	<div class="text-center">
	        	@if(Auth::user()->google_id > 0)
	        	<img src="{{ Auth::user()->avatar }}" class="avatar img-circle" alt="avatar">
	        	@else
	          	<img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
	          	@endif
	          	{{-- <h6>Upload a different photo...</h6>
	          
	          	<input type="file" class="form-control"> --}}
	        </div>
	      </div>
	      
	      <!-- edit form column -->
	      <div class="col-md-9 personal-info">
	        {{-- <div class="alert alert-info alert-dismissable">
	          <a class="panel-close close" data-dismiss="alert">×</a> 
	          <i class="fa fa-coffee"></i>
	          This is an <strong>.alert</strong>. Use this to show important messages to the user.
	        </div> --}}
	        <h3>Personal info</h3>
	        
	        <form id="editform" class="form-horizontal" method="POST" action="">
	        	<input type="hidden" name="id" value="{{ Session::get('values')[0]['name'] }}" required="true">
	          <div class="form-group">
	            <label class="col-lg-3 control-label">Name:</label>
	            <div class="col-lg-8">
	              <input class="form-control" name="name" type="text" value="{{ decrypt(Session::get('values')[0]['name']) }}" required="true">
	            </div>
	          </div>
	          <div class="form-group">
	            <label class="col-lg-3 control-label">Email:</label>
	            <div class="col-lg-8">
	              <input class="form-control" type="text" value="{{ decrypt(Session::get('values')[0]['email']) }}" disabled>
	            </div>
	          </div>
	          <div class="form-group">
	            <label class="col-md-3 control-label">Old Password:</label>
	            <div class="col-md-8">
	              <input class="form-control" name="old_password" type="password" value required="true">
	            </div>
	          </div>
	          <div class="form-group">
	            <label class="col-md-3 control-label">New Password:</label>
	            <div class="col-md-8">
	              <input class="form-control" name="password" type="password" value required="true">
	            </div>
	          </div>
	          <div class="form-group">
	            <label class="col-md-3 control-label">Confirm Password:</label>
	            <div class="col-md-8">
	              <input class="form-control" name="password_confirmation" type="password" value required="true">
	            </div>
	          </div>
	          <div class="form-group">
	            <label class="col-md-3 control-label"></label>
	            <div class="col-md-8">
	              <input type="submit" id="editformbtn" class="btn btn-primary" value="Save Changes">
	            </div>
	          </div>
	        </form>
	      </div>
	  	</div>
	</div>
<hr>
{{-- {{ Session::forget('values') }} --}}
{{ Session::get('values')[0]['name'] }}

    <script type="text/javascript">
    	$('table').DataTable();
    	console.log('')
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\EditUserValidateRequest', '#editform'); !!}
@stop