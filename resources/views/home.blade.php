@extends('layouts.app')



@section('content')
    <div class="container">
        
        <center> Test Form</center>
            <div class="row">
                {{-- Delete Modal --}}
                    <div class="modal" id="deletemodal" tabindex="-1" role="dialog">
                      <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Student</h5>
                                </div>
                                <div class="modal-body">
                                    <h2>Are You Sure To Want To Delete ? </h2>
                                </div>
                                <div class="modal-footer">
                                    <form id="deleteform">
                                        <input type="hidden"  id="deleteid" name="id" value="">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </form>
                                </div>
                            </div>
                      </div>
                    </div>
                {{-- End Delete Modal --}}

                {{-- Update Modal --}}
                    <div class="modal" id="updatemodal" tabindex="-1" role="dialog">
                      <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Student</h5>
                                </div>
                                        <div class="modal-body">
                                            <form id="updateform" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden" id="updateid" name="id" value="">
                                            <div class="col-md-12">   
                                                <div class="form-group col-md-5">
                                                    <label for="name">Name</label>
                                                    <input type="text" id="update_name" name="name" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="email">Email</label>
                                                    <input type="email" id="update_email" name="email" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">   
                                                <div class="form-group col-md-5">
                                                    <label for="address">Address</label>
                                                    <input type="textarea" id="update_address" name="address" class="form-control" required>

                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="father_name">Father Name</label>
                                                    <input type="text" id="update_father_name" name="father_name" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">   
                                                <div class="form-group col-md-5">
                                                    <label for="date_of_birth">Date Of Birth</label>
                                                    <input type="date" id="update_date_of_birth" name="date_of_birth" class="form-control" required>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="file">File</label>
                                                    <input type="file" id="files" name="file_path" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">   
                                                <div class="form-group col-md-5">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            
                                            
                                        </div>
                            </div>
                      </div>
                    </div>
                {{-- End Update Modal --}}

                

                <div class="col-md-8 col-md-offset-2">
                    {{-- <div class="panel panel-default"> --}}
                        <form id="dummyForm" enctype="multipart/form-data">

                            {{ csrf_field() }}
                            <div class="col-md-12">   
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <br><br><br><br>
                            <div class="col-md-12">   
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="address">Address</label>
                                    <input type="textarea" id="address" name="address" class="form-control" required>

                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="father_name">Father Name</label>
                                    <input type="text" id="father_name" name="father_name" class="form-control" required>
                                </div>
                            </div>
                            <br><br><br><br>
                            <div class="col-md-12">   
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="date_of_birth">Date Of Birth</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="file">File</label>
                                    <input type="file" id="file" name="file_path" class="form-control" required>
                                </div>
                            </div>
                            <br><br><br><br>
                            <div class="col-md-12">   
                                <div class="form-group col-md-5">
                                    <input id="btnsubmit" type="submit" class="btn btn-primary">
                                </div>
                                <div class="form-group col-md-5">
                                    <input type="button" value="Reset" class="btn btn-warning" id="reset">
                                </div>
                            </div>    
                        </form>

                        <form class="hidden" id="myform" enctype="multipart/form-data">

                            {{ csrf_field() }}
                            <div class="form-group col-md-5">
                                <input type="text" id="newname" name="name" class="form-control" required>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="text" id="newemail" name="email" class="form-control" required>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="text" id="newaddress" name="address" class="form-control" required>

                            </div>
                            <div class="form-group col-md-5">
                                <input type="text" id="newfather_name" name="father_name" class="form-control" required>
                            </div>
                            <div class="form-group col-md-5">
                                <input type="text" id="newdate_of_birth" name="date_of_birth" class="form-control" required>
                            </div>
                            
                        </form>
                    {{-- </div> --}}
                </div>

                <br><br><br>
                <div id="form_output"></div>
                


                {{-- Table Initialization --}}
                    <div class="col-md-12">
                        <table class="table" id="mytable">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Email</th>
                                    <th>F.Name</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                {{-- End --}}
                <br><br><br>
                {{-- HighCharts --}}

                <input type="hidden" id="total" value="{{ $total }}">
                <input type="hidden" id="p1" value="{{ $p1 }}">
                <input type="hidden" id="p2" value="{{ $p2 }}">
                <input type="hidden" id="p3" value="{{ $p3 }}">
                <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

                {{--  --}}
            </div>
    </div>

    

    {{--Start   of Tawk.to Script --}}
        {{-- <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/5d482ad8e5ae967ef80e83cc/default';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();
        </script> --}}
    {{--End     of Tawk.to Script --}}

    {{--Start   of CRISP --}}
        {{-- <script type="text/javascript">
            window.$crisp=[];window.CRISP_WEBSITE_ID="6e589f69-b4ca-4516-9a10-4f7c30a636ea";
            (function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();
        </script> --}}
    {{--End     of CRISP --}}

    {{--Start   of TIDIO --}}
        {{-- <script src="//code.tidio.co/lalnbnelkbwsabti4ab4gpftfaxkx1qr.js">
            
        </script> --}}
    {{--End     of TIDIO --}}

    {{--Start   of HELP CRUNCH --}}
        {{-- <script type="text/javascript">
            (function(w,d){
              w.HelpCrunch=function(){w.HelpCrunch.q.push(arguments)};w.HelpCrunch.q=[];
              function r(){var s=document.createElement('script');s.async=1;s.type='text/javascript';s.src='https://widget.helpcrunch.com/';(d.body||d.head).appendChild(s);}
              if(w.attachEvent){w.attachEvent('onload',r)}else{w.addEventListener('load',r,false)}
            })(window, document)
        </script>
        <script type="text/javascript">
              HelpCrunch('init', 'localtest', {
                applicationId: 1,
                applicationSecret: 'kQkS5QDppGEzCkndCfq0smCtdguyqIVPMaKvTcx4vCzPHoQcxg2yKMqACOBfaL3utjGtzvYso/FuTPP+10FnSw=='
              });

              HelpCrunch('showChatWidget');
        </script> --}}
    {{--End     of HELP CRUNCH --}}

      
    {!! JsValidator::formRequest('App\Http\Requests\StudentValidateRequest', '#dummyForm'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\StudentUpdateValidRequest', '#updateform'); !!}
    
@endsection
