<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{

    private $sex_types = ['Male', 'Female', 'Other'];
    private $date_picker_format = 'm/d/Y';
    private $sort_lastname_cnt = 0;
    private $sort_birthdate_cnt = 0;
    private $cnt = 0;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $sort = '';
        $order = '';

        # THIS IS THE MOST IMPORTANT PIECE OF THIS PROJECT TILL NOW..
        if ($request->has('sort') && $request->has('order')) {

            if(($request->sort == 'last_name' || $request->sort == 'birth_date') && ($request->order == 'asc' || $request->order == 'desc')){
                $sort = $request->sort;
                $order = $request->order;
                $students = Student::orderBy($sort, $order)->paginate(5);
            }
            else
                return redirect()->route('home')->with('bad_param_error', "'Don't fucking mess with my code, bitch.");
        } else {
            $students = Student::paginate(5);
        }

        return view('welcome', [
            'students'  => $students,
            'sort'      => $sort,
            'order'     => $order,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create', ['sex_types' => $this->sex_types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $today_date = Carbon::now()->toDate()->format($this->date_picker_format);

        $first_name = $request->first_name;
        $last_name = $request->last_name;


        Validator::make($request->all(), [

            'student_id' => 'required|digits:8|unique:students',
            'birth_date' => 'required|before_or_equal:' . $today_date,
            'sex' => 'required',
            'first_name' => [
                'required',
                Rule::unique('students')->where(function ($query) use ($first_name, $last_name) {
                    return $query->where('first_name', $first_name)
                        ->where('last_name', $last_name);
                }),
            ],

            'last_name' => [
                'required',
                Rule::unique('students')->where(function ($query) use ($first_name, $last_name) {
                    return $query->where('first_name', $first_name)
                        ->where('last_name', $last_name);
                }),
            ],


        ])->validate();

        // convert to y-m-d format.
        $formatted_birthdate = Carbon::parse($request->birth_date)->format('Y-m-d');

        $student = new Student();
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->student_id = $request->student_id;
        $student->birth_date = $formatted_birthdate;
        $student->sex = $request->sex;

        if ($request->hasFile('image_file')) {

            $request->image_file->store('profile_images', 'public');
            // $file_name = $request->image_file->getClientOriginalName();
            $file_name = $request->image_file->hashName();
            $student->image_path = $file_name;

            // Storage::put($file_name, $request->image_file);

        }

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
        return view('edit', ['current_student' => $current_student, 'sex_types' => $this->sex_types]);
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
        // dd($request);
        $today_date = Carbon::now()->toDate()->format($this->date_picker_format);

        $first_name = $request->first_name;
        $last_name = $request->last_name;

        $student_to_update = Student::find($id);
        Validator::make($request->all(), [
            'sex' => 'required',
            'student_id' => 'required|digits:8|unique:students,student_id,' . $student_to_update->id,
            'birth_date' => 'required|before_or_equal:' . $today_date,

            'first_name' => [
                'required',
                Rule::unique('students')->where(function ($query) use ($first_name, $last_name, $id) {
                    return $query->where('first_name', $first_name)
                        ->where('last_name', $last_name)->where('id', '!=', $id);
                }),
            ],

            'last_name' => [
                'required',
                Rule::unique('students')->where(function ($query) use ($first_name, $last_name, $id) {
                    return $query->where('first_name', $first_name)
                        ->where('last_name', $last_name)->where('id', '!=', $id);
                }),
            ],

        ])->validate();

        // convert to y-m-d format (IF CURRENT FORMAT IS NOT 'Y-m-d').
        $formatted_birthdate = Carbon::parse($request->birth_date)->format('Y-m-d');


        $student_to_update->first_name = $request->first_name;
        $student_to_update->last_name = $request->last_name;
        $student_to_update->student_id = $request->student_id;
        $student_to_update->birth_date = $formatted_birthdate;
        $student_to_update->sex = $request->sex;

        if ($request->hasFile('image_file')) {
            $request->image_file->store('profile_images', 'public');
            $student_to_update->image_path = $request->image_file->hashName();
        }

        $student_to_update->save();


        return redirect()->route('home')->with('successMsg', 'Student updated succussfully!');
    }

    // public function order(Request $request)
    // {

    //     if ($request->has('lastname_form')) {
    //         $students = Student::orderBy('last_name', 'asc')->get();
    //         // dd($students);
    //     } else if ($request->has('birthdate_form')) {
    //         echo "birthdaate";
    //     }

    //     return Redirect::route('home')->with(['sorted_students' => $students]);
    //     // return view('welcome', ['students' => $students]);
    // }

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
