<?php

namespace App\Http\Controllers;
dd(1);
use App\Http\Requests\StudentRequest;
use App\Repositories\Student\StudentRepository;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct(StudentRepository $studentRepository)
    {
        // here we declare the repository
        $this->studentRepository = $studentRepository;
    }

    public function index()
    {
        $student =  $this->studentRepository->all();
        return response()->json(['success' => $student], $this-> successStatus);
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
    public function store(StudentRequest $request)
    {
        $input = $request->all();
        $student_create = $this->studentRepository->create($input);
        return response()->json(['created'=>$student_create], $this-> successStatus);
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
        $student_by_id = $this->studentRepository->findById($id);
        return response()->json(['dataById'=>$student_by_id], $this-> successStatus);

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
    public function update(StudentRequest $request, $id)
    {
        $input = $request->all();
        $student_update =  $this->studentRepository->update($input,$id);
        return response()->json(['updated'=>$student_update], $this-> successStatus);
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
