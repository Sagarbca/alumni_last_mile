<?php

namespace App\Http\Controllers\Post;

use App\Http\Requests\PostRequest;
use App\Repositories\Post\PostRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class PostController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository =  $postRepository;
    }

    public function index()
    {
        //
        $post =  $this->postRepository->all();
        /*foreach($posts as &$post){
            $post->image = Storage::disk('local')->get($post->image);
        }*/
        return response()->json(['success' => $post], $this-> successStatus);

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
    public function store(PostRequest $request)
    {
        $input = $request->all();
        $image = $input["image"];
        $input["image"] = Storage::disk('local')->put('images', $image);
        $post_create = $this->postRepository->create($input);
        return response()->json(['created'=>$post_create], $this-> successStatus);
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
        $post_by_id = $this->postRepository->findById($id);
        return response()->json(['dataById'=>$post_by_id], $this-> successStatus);
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
        $input = $request->all();
        $image = $input["image"];
        $input["image"] = Storage::disk('local')->put('images', $image);
        $post_update =  $this->postRepository->update($input,$id);
        return response()->json(['updated'=>$post_update], $this-> successStatus);
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
