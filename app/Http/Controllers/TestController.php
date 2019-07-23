<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\Student;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function studentsData()
    {
        $students = Student::all();
        return DataTables::of($students)
        ->addColumn('names',function($student)
        {
            return 
            '<strong>' .$student->name. '</strong>';
        })
        ->addColumn('age',function($student)
        {
            return 
            $student->age;
        })
        ->addColumn('email',function($student)
        {
            return '<strong>' .$student->email. '</strong>';
        })
        ->addColumn('fname',function($student)
        {
            return $student->father_name;
        })
        ->addColumn('action',function($student)
        {
            return '<form action="' .route('viewfile',$student->id). '"><input type="submit" value="View" class="btn btn-primary"></form>';
        })
        ->rawColumns(['names', 'email', 'action'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $error_array = array();
        $success_output = '';
        $validation = Validator::make($request->all(),[
            'email'=>['required','unique:students'],
            'name'=>['required','regex:/^[a-zA-Z ]*$/'],
            'address'=>'required',
            'father_name'=>'required',
            'date_of_birth'=>'required',
            'file'=>['required','mimes:pdf'],
        ]);
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else
        {
            $student = new Student();
            $student->name = $request->name;
            $student->email = $request->email;
            $student->address = $request->address;
            $student->father_name = $request->father_name;
            $student->date_of_birth = $request->date_of_birth;
            $student->age = \Carbon\Carbon::parse($request->date_of_birth)->age;
            $student->file = $request->file;
            $student->save();
            $id = $student->id;
            if ($request->hasFile('file'))
            {
                // return "File";
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                Storage::disk('public')->put($file->getFilename().'.'.$extension,  File::get($file));
                $path = $request->file('file')->getRealPath();
                $student = Student::find($id);
                $student->file = $file->getFilename();
                $student->save();
            }
            $success_output =  "sass";
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
    }

    public function viewfile($id)
    {
        $student = Student::where('id',$id)->first();
        $path = $student->file;
        return response()->file(storage_path('app/public/'.$path).'.pdf', [
            'Content-Type' => 'application/pdf'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
