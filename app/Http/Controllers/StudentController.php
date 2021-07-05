<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        // $students = Student::all();
        $students = Student::paginate(5);
        return view('welcome', ['students' => $students]);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        $student = new Student();
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->save();   

        return redirect()->route('home')->with('successMsg', 'Student created successfully!');
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
        $current_student = Student::find($id);
        return view('edit', compact('current_student'));
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
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        $student_to_update = Student::find($id);
        $student_to_update->first_name = $request->first_name;
        $student_to_update->last_name = $request->last_name;
        $student_to_update->save();

        return redirect()->route('home')->with('successMsg', 'Student updated succussfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::find($id)->delete();   
        return redirect()->route('home')->with('successMsg', 'Student deleted succussfully!');
    }
}
