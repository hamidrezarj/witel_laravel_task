<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use app\Models\User;
use App\Policies\StudentPolicy;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    private $sex_types = ['Male', 'Female', 'Other'];
    private $date_picker_format = 'm/d/Y';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = '';
        $lastname_order = '';
        $birthdate_order = '';
        $searched_firstname = '';
        $searched_sex = '';
        $default_lastname_url = 'sort=last_name&order=desc';
        $default_birthdate_url = 'sort=birth_date&order=desc';

        $lastname_href = url()->current() . '/';
        $birthdate_href = $lastname_href;
        $students = new Student();

        if ($request->has('search_firstname') && isset($request->search_firstname)) {
            $searched_firstname = $request->search_firstname;
            $students = $students->where('first_name', 'LIKE', '%' . $searched_firstname . '%');

            $lastname_href .= ('?search_firstname=' . $searched_firstname);
            $birthdate_href .= ('?search_firstname=' . $searched_firstname);


            if ($request->has('search_sex') && isset($request->search_sex)) {
                $searched_sex = $request->search_sex;
                $lastname_href .= '&' . 'search_sex=' . $searched_sex;
                $birthdate_href .= '&' . 'search_sex=' . $searched_sex;

                $students = $students->where('sex', $searched_sex);
            }

            # if url consists of both filter and sort, do filter followed by sort.
            if ($request->has('sort') && $request->has('order')) {

                if (($request->sort == 'last_name' || $request->sort == 'birth_date') && ($request->order == 'asc' || $request->order == 'desc')) {
                    $sort = $request->sort;
                    $students = $students->orderBy($sort, $request->order);

                    if ($request->order == 'desc')
                        $next_order = 'asc';
                    else
                        $next_order = 'desc';

                    if ($sort == 'last_name') {
                        $lastname_order = $request->order;
                        $lastname_href .= '&' . 'sort=' . $request->sort . '&order=' . $next_order;
                        $birthdate_href .= '&' . $default_birthdate_url;
                    } else {
                        $birthdate_order = $request->order;
                        $birthdate_href .= '&' . 'sort=' . $request->sort . '&order=' . $next_order;
                        $lastname_href   .= '&' . $default_lastname_url;
                    }
                } else
                    return redirect()->route('index')->with('bad_param_error', "'Don't fucking mess with my code, bitch.");
            } else {
                # make default url for sort.
                $lastname_href   .= '&' . $default_lastname_url;
                $birthdate_href  .= '&' . $default_birthdate_url;
            }
        } else if ($request->has('search_sex') && isset($request->search_sex)) {

            $searched_sex = $request->search_sex;
            $students = $students->where('sex', $searched_sex);

            $lastname_href .= ('?search_sex=' . $searched_sex);
            $birthdate_href .= ('?search_sex=' . $searched_sex);

            if ($request->has('search_firstname') && isset($request->search_firstname)) {
                $lastname_href .= '&' . 'search_firstname=' . $searched_firstname;
                $birthdate_href .= '&' . 'search_firstname=' . $searched_firstname;

                $searched_firstname = $request->search_firstname;
                $students = $students->where('first_name', 'LIKE', '%' . $searched_firstname . '%');
            }

            # if url consists of both filter and sort, do filter followed by sort.
            if ($request->has('sort') && $request->has('order')) {

                if (($request->sort == 'last_name' || $request->sort == 'birth_date') && ($request->order == 'asc' || $request->order == 'desc')) {
                    $sort = $request->sort;
                    $students = $students->orderBy($sort, $request->order);

                    if ($request->order == 'desc')
                        $next_order = 'asc';
                    else
                        $next_order = 'desc';

                    if ($sort == 'last_name') {
                        $lastname_order = $request->order;
                        $lastname_href .= '&' . 'sort=' . $request->sort . '&order=' . $next_order;
                        $birthdate_href .= '&' . $default_birthdate_url;
                    } else {
                        $birthdate_order = $request->order;
                        $birthdate_href .= '&' . 'sort=' . $request->sort . '&order=' . $next_order;
                        $lastname_href   .= '&' . $default_lastname_url;
                    }
                } else
                    return redirect()->route('home')->with('bad_param_error', "'Don't fucking mess with my code, bitch.");
            } else {
                # make default url for sort.
                $lastname_href   .= '&' . $default_lastname_url;
                $birthdate_href  .= '&' . $default_birthdate_url;
            }
        }

        # THIS IS THE MOST IMPORTANT PIECE OF THIS PROJECT TILL NOW..
        else if ($request->has('sort') && $request->has('order')) {

            if (($request->sort == 'last_name' || $request->sort == 'birth_date') && ($request->order == 'asc' || $request->order == 'desc')) {
                $sort = $request->sort;

                if ($request->order == 'desc')
                    $next_order = 'asc';
                else
                    $next_order = 'desc';

                if ($sort == 'last_name') {
                    $lastname_order = $request->order;
                    $lastname_href .= '?sort=' . $request->sort . '&order=' . $next_order;
                    $birthdate_href .= '?' . $default_birthdate_url;
                } else {
                    $birthdate_order = $request->order;
                    $birthdate_href .= '?sort=' . $request->sort . '&order=' . $next_order;
                    $lastname_href  .= '?' . $default_lastname_url;
                }

                if ($request->has('search_sex') && isset($request->search_sex)) {
                    $searched_sex = $request->search_sex;
                    $lastname_href .= '&' . 'search_sex=' . $searched_sex;
                    $birthdate_href .= '&' . 'search_sex=' . $searched_sex;

                    $students = $students->where('sex', $searched_sex);
                }

                # if url consists of both filter and sort, do filter followed by search. 
                if ($request->has('search_firstname') && isset($request->search_firstname)) {
                    $lastname_href .= '&' . 'search_firstname=' . $searched_firstname;
                    $birthdate_href .= '&' . 'search_firstname=' . $searched_firstname;

                    $searched_firstname = $request->search_firstname;
                    $students = $students->where('first_name', 'LIKE', '%' . $searched_firstname . '%');
                }

                $students = $students->orderBy($sort, $request->order);
            } else
                return redirect()->route('index')->with('bad_param_error', "'Don't fucking mess with my code, bitch.");
        } else {
            $lastname_href  .= '?' . $default_lastname_url;
            $birthdate_href .= '?' . $default_birthdate_url;
        }

        $students = $students->paginate(5)->withQueryString();

        return view('welcome', [
            'sex_types'          => $this->sex_types,
            'students'           => $students,
            'sort'               => $sort,
            'lastname_order'     => $lastname_order,
            'birthdate_order'    => $birthdate_order,
            'searched_firstname' => $searched_firstname,
            'searched_sex'       => $searched_sex,
            'lastname_href'      => $lastname_href,
            'birthdate_href'     => $birthdate_href,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Student::class);
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
        # first assign to student which is being created its corresponding user model.
        $user_id = Auth::user()->id;
        $owner_user = User::find($user_id);        
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
            'user_id' => 'unique:students',
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
            $file_name = $request->image_file->hashName();
            $student->image_path = $file_name;
        }

        $owner_user->student()->save($student);
        return redirect()->route('index')->with('successMsg', 'Student created successfully!');
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
    public function edit(Request $request, $id)
    {
        $current_student = Student::find($id);
        
        # check if user has permission to edit.
        $this->authorize('update', $current_student);

        $page_num = '';
        if ($request->has('page'))
            $page_num = $request->page;

        Redirect::setIntendedUrl(url()->previous());

        return view('edit', [
            'current_student' => $current_student,
            'sex_types'       => $this->sex_types,
            'page'            => $page_num,
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
        return redirect()->intended()->with('successMsg', 'Student updated succussfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $student = Student::find($id);
        
        $response = Gate::inspect('delete', $student);
        if(!$response->allowed())
            abort(403, $response->message());

        $student->delete();
        $page_num = 0;
        if ($request->has('page') && $request->has('count')) {

            if (intval($request->count) > 1)
                $page_num = $request->page;
            else
                $page_num = intval($request->page) - 1;
        }

        $intended_url = url()->previous();

        $old_string = 'page=' . $request->page;
        $new_string = 'page=' . $page_num;

        # now we should replace page number in previous url with $page_num value
        if (Str::contains($intended_url, $old_string)) {
            $intended_url = Str::replace($old_string, $new_string, $intended_url);
        }

        Redirect::setIntendedUrl($intended_url);

        return redirect()->intended()->with('successMsg', 'Student deleted succussfully!');
    }

    public function search_ajax(Request $request)
    {

        $students = new Student();
        if ($request->has('search_firstname')) {
            $students = Student::where('first_name', 'LIKE', '%' . $request->search_firstname . '%')->get();

            if (count($students) == 0)
                return response()->json('No results found!', 404);
            else
                return response()->json($students);
        } else
            return response()->json($students, 404);
    }
}
