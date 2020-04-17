<?php


namespace App\Repositories\Post;


use App\Models\Post\Post;
use Illuminate\Support\Facades\DB;

class PostRepository
{
    public function all(){
        return Post::all();
    }

    public function create($input){
        return Post::create($input);
    }

    public function findById($id){
        return  Post::find($id);
    }
    public function update($input,$id){
        $data  = Post::find($id);
        return DB::raw($data->update($input));
    }
}
