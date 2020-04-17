<?php


namespace App\Repositories\Student;


use App\Student;
use Illuminate\Support\Facades\DB;

class StudentRepository
{
    public function all(){
        return Student::all();
    }

    public function findById($id){
       return  Student::find($id);
    }

    public function create($input){
        return Student::create($input);
    }

    public function update($input,$id){
        $data  = Student::find($id);
        return DB::raw($data->update($input));

    }
}
