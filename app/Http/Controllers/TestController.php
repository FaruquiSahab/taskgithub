<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Session;
use DataTables;
use DB;
use Auth;
use App\Student;
use App\User;

class TestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \DataTables
     */
    public function studentsData()
    {
        // Get ALL Students
        DB::statement(DB::raw('set @rownum=0'));
        $students = Student::get(['students.*', 
                    DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
        // return DataTables with modified columns
        return DataTables::of($students)
        ->addColumn('names',function($student)
        {
            return '<strong>' .$student->name. '</strong>';
        })
        ->addColumn('email',function($student)
        {
            return '<strong>' .$student->email. '</strong>';
        })
        ->addColumn('fname',function($student)
        {
            return $student->father_name;
        })
        ->addColumn('file',function($student)
        {
            return '<a class="btn btn-primary" target="_blank" href="' .route('viewfile',$student->id). '">View</a>';
        })
        // generating UPDATE/DELETE button
        ->addColumn('action',function($student)
        {
            return '<a href="" data-toggle="modal" data-target="#updatemodal" data-id="' .encrypt($student->id). '" data-name="'.$student->name.'" data-email="'.$student->email.'" data-father_name="'.$student->father_name.'" data-address="'.$student->address.'" data-date_of_birth="'.$student->date_of_birth.'" class="btnupdate btn btn-warning">Update</a>
            <a href="" data-toggle="modal" data-target="#deletemodal" data-id="' .encrypt($student->id). '" style="margin-left:5px" class="btndelete btn btn-danger">Delete</a>';
        })
        // render HTML for following columns
        ->rawColumns(['names', 'email', 'file', 'action'])
        ->make(true);
    }

    /**
     * Validate Form Request
     * Encrypt All Fields And Return
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function takeRequest(Request $request)
    {
        $error_array = [];
        $success_output = '';
        $response = [];

        // Validating Data Before Encryption
        $validation = Validator::make($request->all(),[
            'email'=>['required','unique:students'],
            'name'=>['required','regex:/^[a-zA-Z ]*$/'],
            'address'=>'required',
            'father_name'=>'required',
            'date_of_birth'=>'required',
            'file_path'=>['required','mimes:pdf'],
        ]);
        
        // collect validation errors
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        // encrypting request with success output
        else
        {
            $response = [
                'name'          =>  encrypt($request->name),
                'email'         =>  encrypt($request->email),
                'address'       =>  encrypt($request->address),
                'father_name'   =>  encrypt($request->father_name),
                'date_of_birth' =>  encrypt($request->date_of_birth),
                'file_path'          =>  $request->file_path,
            ];
            $success_output = 'success';
        }
        
        // output array return with JSON encoded
        $output = [];
        $output = [
            'error'=>$error_array,
            'success'=>$success_output,
            'datas'=>$response,
        ];
        echo json_encode($output);
        exit();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error_array = [] ;
        $error_output = '';
        $success_output = '';
        $student = new Student();

        // decrypting values
        $values = array( 
            "name"=> decrypt($request->name),
            "email"=> decrypt($request->email),
            "address"=> decrypt($request->address),
            "date_of_birth"=> decrypt($request->date_of_birth),
            "father_name"=> decrypt($request->father_name),
            "file_path"=>  $request->file_path
        );

        // passing through validation
        $validation = Validator::make($values,[
            'email'=>['required','unique:students'],
            'name'=>['required','regex:/^[a-zA-Z ]*$/'],
            'address'=>'required',
            'father_name'=>'required',
            'date_of_birth'=>'required',
            'file_path'=>['required','mimes:pdf'],
        ]);

        // collecting vlidation errors if exists
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        // saving into database after validation
        else
        {
            $student->name          = $values['name'];
            $student->email         = $values['email'];
            $student->address       = $values['address'];
            $student->father_name   = $values['father_name'];
            $student->date_of_birth = $values['date_of_birth'];
            $student->age           =  Student::age($values['date_of_birth']);
            // Checking File Exists
            if ($request->hasFile('file_path'))
            {
                $file = $request->file('file_path');
                $extension = $file->getClientOriginalExtension();
                Storage::disk('public')->put($file->getFilename().'.'.$extension,  File::get($file));
                $path = $request->file('file_path')->getRealPath();
                $student->file_path = $file->getFilename();
            }
        }
        
        $student->save();
        $id = 0;
        $id = $student->id;
        if ($id > 0) {
            $success_output =  "success";
        } else {
            $error_output = 'error';
        }
        // output array return with JSON encoded
        $output = [
            'validate'  =>  $error_array,
            'error'     =>  $error_output,
            'success'   =>  $success_output
        ];
        echo json_encode($output);
        exit();
    }

    /**
     * View File Of Specific Student
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function viewfile($id)
    {
        // Find Student with the ID
        $student = Student::where('id',$id)->first();
        $path = $student->file_path;
        // Return File Response
        return response()->file(storage_path('app/public/'.$path).'.pdf', [
            'Content-Type' => 'application/pdf'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $error_array = [];
        $success_output = '';

        // validating data before updating
        $validation = Validator::make($request->all(),[
            'email'=>['required','unique:students,email,'.decrypt($request->id)],
            'name'=>['required','regex:/^[a-zA-Z ]*$/'],
            'address'=>'required',
            'father_name'=>'required',
            'date_of_birth'=>'required',
            'file_path'=>['required','mimes:pdf'],
        ]);
        // collecting validation errors
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else
        {
            // checking if file exists
            if ($request->hasFile('file_path'))
            {
                $file = $request->file('file_path');
                $extension = $file->getClientOriginalExtension();
                Storage::disk('public')->put($file->getFilename().'.'.$extension,  File::get($file));
                $path = $request->file('file_path')->getRealPath();
                $file_path = $file->getFilename();
            }
            $student = Student::findOrFail(decrypt($id));
            // delete previous file
            unlink(storage_path("app\public\\".$student->file_path.".pdf"));
            // update student
            $student->update($request->except(['token','id']));
            $student->update([
                'file_path'=>$file_path,
                'age' => Student::age($request->date_of_birth)
            ]);
            $success_output = 'success';
            
        }
        // output array return in JSON encoded form
        $output = [];
        $output = [
            'error'=>$error_array,
            'success'=>$success_output
        ];
        echo json_encode($output);
        exit();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // find student with given ID
        $student = Student::findOrFail(decrypt($id));
        // delete their file
        unlink(storage_path("app\public\\".$student->file_path.".pdf"));
        // record delete
        $student->delete();
        return json_encode('success');
    }

    /**
    *Display Users Index Page
    *
    *
    * @return view
    */
    public function usersindex()
    {
        $user = User::findOrFail(Auth::id());
        Session::push('values', [
                'id'        =>  encrypt($user->id),
                'name'      =>  encrypt($user->name),
                'email'     =>  encrypt($user->email),
                'protected' =>  encrypt($user->is_auth),
            ]);
        // return Session::all();
        return view('user.profile');
    }

    /**
    *Update User
    *
    *
    * @return redirect back
    */
    public function edituser(Request $request)
    {
        
    }

}
