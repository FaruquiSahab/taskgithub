$(document).ready(function()
{

    // setting one time ajax headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            '_token': $('input[name="_token"]').val()
        }
    });

    // Rendering DataTable
    $('#mytable').DataTable(
    {
        "processing": false,
        "serverSide": false,
        "ajax": "/studentsData",
        "columns":
        [
            { "data": "rownum"},
            { "data": "names" },
            { "data": "age"},
            { "data": "email" },
            { "data": "fname" },
            { "data": "file" },
            { "data": "action" }
        ]
    });

    


    // Cloning File Input Tag
    $("#file").on('input',function()
    {
        $("#myform :input[name='file_path']").remove(); 
        var $this = $(this), $clone = $this.clone();
        $this.after($clone).appendTo('#myform');
    });

    // First Ajax Request For Validation Of Data
    $(document).on('click','#btnsubmit',function(event)
    {
        event.preventDefault();
        var form = $('#dummyForm')[0];
        var formData = new FormData(form);
        // if jsValidation validate form successfully
        if($('#dummyForm').valid())
        {
            $.ajax({
                url:"/encrypt/request",
                type:"POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(data)
                {
                    data = JSON.parse(data,true);
                    // Display Validation Error If Exists
                    if(data.error.length > 0)
                    {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++)
                        {
                            toastr.error(data.error[count],'Error Alert');
                        }
                    }
                    // Clonig Encrypted Data In New Form
                    else if(data.success=="success")
                    {
                        $('#newname').val(data.datas.name);
                        $('#newemail').val(data.datas.email);
                        $('#newaddress').val(data.datas.address);
                        $('#newdate_of_birth').val(data.datas.date_of_birth);
                        $('#newfather_name').val(data.datas.father_name);
                        var form = $('#myform')[0];
                        var newformData = new FormData(form);
                        // Sending Encrypted Data For Posting In DB
                        $.ajax({
                            url:"/students",
                            type:"POST",
                            data: newformData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success:function(data)
                            {
                                data = JSON.parse(data,true);
                                // Again Validation After Decrypting
                                if(data.validate.length > 0)
                                {
                                    var error_html = '';
                                    for(var count = 0; count < data.error.length; count++)
                                    {
                                        toastr.error(data.error[count],'Error Alert');
                                    }
                                }
                                // For Error 500
                                else if(data.error == 'error')
                                {
                                    toastr.error('Coresponding Server Down','Error Alert');
                                }
                                else if(data.success == 'success')
                                {
                                    // Actions After New Inserted Values
                                    toastr.success('Values Inserted Successfully','Success Alert');
                                    $('#mytable').DataTable().ajax.reload(null, false);
                                    $.ajax({
                                        url: "/charts/values",
                                        type: "GET",
                                        success:function(data){
                                            data = JSON.parse(data,true);
                                            $('#p1').val(data.p1);
                                            $('#p2').val(data.p2);
                                            $('#p3').val(data.p3);
                                            $('#total').val(data.total);
                                            myfunction();
                                            location.reload();
                                        }
                                    });
                                    $("#myform :input[name='file_path']").remove();
                                    $("form :input:not(:submit):not(:button):not(:hidden)").val('');
                                }
                            },
                            error:function(data)
                            {
                                // Error 500 For student.store()
                                toastr.error('Coresponding Server Down','Error Alert');
                            }
                        });
                    }
                },
                error:function(data)
                {
                    // Error 500 For Encrypt Method.
                    toastr.error('Coresponding Server Down','Error Alert');
                }
            });

        }
    });


    
    // Reset Form Input
    $('#reset').on('click',function()
    {
        $("form :input:not(:submit):not(:button):not(:hidden)").val('');
        $("#myform :input[name='file_path']").remove();
    });

    // Copy Id From Button Data Attribut To Input For Delete
    $(document).on('click', 'a.btndelete', function(event){
        $('#deleteid').val($(this).data('id'));
    });


    // Copy All Attr From Data Tag Too Input Fields
    $(document).on('click','a.btnupdate' , function()
    {
        $('#updateid').val($(this).data('id'));
        $('#update_name').val($(this).data('name'));
        $('#update_email').val($(this).data('email'));
        $('#update_address').val($(this).data('address'));
        $('#update_father_name').val($(this).data('father_name'));
        $('#update_date_of_birth').val($(this).data('date_of_birth'));
    });

    // Ajax Request For Update Form
    $('#updateform').on('submit', function(event){
        event.preventDefault();
        var form = $('#updateform')[0];
        var formData = new FormData(form);
        if($('#updateform').valid())
        {
            $.ajax({
                url: "/students/update/"+ $('#updateid').val(),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success:function(data){
                    data = JSON.parse(data,true);
                    // Display Validation Error If Exists
                    if(data.error.length > 0)
                    {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++)
                        {
                            toastr.error(data.error[count],'Error Alert');
                            // error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                        }
                    }
                    else if(data.success == 'success'){
                        // Actions After Update Request
                        toastr.success('Update Successfully','Success Alert');
                        $('#mytable').DataTable().ajax.reload(null, false);
                        $.ajax({
                            url: "/charts/values",
                            type: "GET",
                            success:function(data){
                                data = JSON.parse(data,true);
                                $('#p1').val(data.p1);
                                $('#p2').val(data.p2);
                                $('#p3').val(data.p3);
                                $('#total').val(data.total);
                                myfunction();
                                location.reload();
                            }
                        });
                        $('.btn-secondary').click();
                        myfunction();
                    }
                },
                error:function(data){
                    // Error 500 For Update()
                    toastr.error('Internal Server Error','Error Alert');
                }

            });
        }
    });

    // Ajax Request For Delete Form
    $('#deletemodal').on('submit', function(event){
        event.preventDefault();
        var form = $('#deleteform')[0];
        var formData = new FormData(form);
        $.ajax({
            url: "/students/"+ $('#deleteid').val(),
            type: "DELETE",
            data: {
                _token:$('input[name="_token"]').val()
            },

            success:function(data)
            {
                // Actions After Delete Request
                toastr.success('Deleted Successfully','Success Alert');
                $('#mytable').DataTable().ajax.reload(null, false);
                $.ajax({
                    url: "/charts/values",
                    type: "GET",
                    success:function(data){
                        data = JSON.parse(data,true);
                        $('#p1').val(data.p1);
                        $('#p2').val(data.p2);
                        $('#p3').val(data.p3);
                        $('#total').val(data.total);
                        myfunction();
                    }
                });
                $('.btn-secondary').click();
            },
            error:function(data){
                // Error 500 For Delete()
                toastr.error('Coresponding Server Down','Error Alert');
            }

        });
    });


    function myfunction()
    {
        // Build the chart
        if($('#total').val() > 0)
        {
            Highcharts.chart('container', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Classification Of Students Ages'
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
                series: [{
                    name: '',
                    colorByPoint: true,
                    data: [{
                        name: 'Teen Age',
                        y: parseInt($('#p1').val())
                    }, {
                        name: 'Above Teen Age',
                        y: parseInt($('#p2').val())
                    }, {
                        name: 'Below Teen Age',
                        y: parseInt($('#p3').val())
                    }]
                }]
            });

            // Hiding HighCharts Menu Button
            $('.highcharts-exporting-group').addClass('hidden');
            $('.highcharts-credits').addClass('hidden');
        }
    }

    myfunction();


});