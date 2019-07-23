@extends('layouts.app')

@section('content')
<div class="container">
    <center> Test Form</center>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <form id="myform" enctype="multipart/form-data">

                    {{ csrf_field() }}
                    <div class="form-group col-md-5">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="name">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="name">Address</label>
                        <input type="textarea" name="address" class="form-control" required>

                    </div>
                    <div class="form-group col-md-5">
                        <label for="name">Father Name</label>
                        <input type="text" name="father_name" class="form-control" required>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="name">Date Of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control" required>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="name">File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <div class="form-group col-md-5">
                        <input id="btnsubmit" type="submit" class="btn btn-primary">
                    </div>
                    <div class="form-group col-md-5">
                        <input type="button" value="Reset" class="btn btn-warning" id="reset">
                    </div>
                </form>
            </div>
            
        </div>
        
    </div>
    <div id="form_output"></div>
    <table class="table" id="mytable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Email</th>
                <th>F.Name</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
    <br><br><br>
    <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
</div>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all">
    <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>
    <!-- Laravel Javascript Validation -->
    {{-- <script type="text/javascript" src="{{ asset('vendor/proengsoft/laravel-jsvalidation/public/js/jsvalidation.js')}}"></script> --}}
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    
    <script type="text/javascript">
        // $('#myform').validate({
        //     rules:
        //     {
        //         name:"required",
        //         father_name:"required",
        //         date_of_birth:"required",
        //         address:"required",
        //         file:{
        //             required:true,
        //             accept: ".pdf",
        //         },
        //         email:{
        //             required:true,
        //             email:true
        //         }
        //     }
        // });

        $(document).ready(function()
        {
            $('#mytable').DataTable(
            {
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('studentdata') }}",
                "columns":
                [
                    { "data": "names" },
                    { "data": "age"},
                    { "data": "email" },
                    { "data": "fname" },
                    { "data": "action" }
                ]
            });
        });
        $(document).on('click','#btnsubmit',function(event)
        {
            // alert('ssss');
            event.preventDefault();
            var form = $('#myform')[0];
            var formData = new FormData(form);
            console.log('1st'+formData);
            if($('#myform').valid())
            {
                $.ajax({
                    url:"{{ route('students.store') }}",
                    type:"POST",
                    data: formData,
                    // async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        console.log(data);
                        data = JSON.parse(data,true);
                        if(data.error.length > 0)
                        {
                            var error_html = '';
                            for(var count = 0; count < data.error.length; count++)
                            {
                                error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                            }
                            $('#form_output').html(error_html);
                            setTimeout(function(){
                                $('.alert-danger').remove();
                          }, 5000)
                        }
                        else
                        {
                            $('#mytable').DataTable().ajax.reload(null, false);
                            // $('#myform')[0].reset(); //reset() not working
                        }
                    },
                    error:function(data)
                    {
                        console.log(data);
                    }
                });
            }
        });

        

        $('#reset').on('click',function()
        {
            // $('#myform')[0].reset(); //reset() not working
        });

        // Build the chart
        Highcharts.chart('container', 
        {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Students Age Percentage'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series:
            [{
                name: 'Students',
                colorByPoint: true,
                data: 
                [
                    {
                        name: 'Teen',
                        y: {{ $p1 }},
                        sliced: true,
                        selected: true
                    },
                    {
                        name: 'Above Teen',
                        y: {{ $p2 }}
                    }
                ]
            }]
        });
        $('.highcharts-exporting-group').addClass('hidden');
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\StudentValidateRequest', '#myform'); !!}
@endsection
