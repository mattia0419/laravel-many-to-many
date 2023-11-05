<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

use App\Models\Post;
use App\Models\Type;
use App\Models\Technology;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.posts.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        Validator::make(
            $data,
            [
                'title' => 'required|string',
                'cover_image' => 'nullable|image',
                'content' => 'required',
                'slug' => 'required',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id'
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.string' => 'Il titolo deve essere una stringa',
                'cover_image.image' => 'Il file caricato deve essere un\'immagine',
                'content.required' => 'Il contenuto è obbligatorio',
                'slug.required' => 'Lo slug è obbligatorio',
                'type_id.exists' => 'Il tipo inserito non è valido',
                'technologies.exists' => 'La tecnologia inserita non è valida'
            ]
            )->validate();
        $post = new Post();
        $post->fill($data);
        if($request->hasFile('cover_image')){
            $post->cover_image = Storage::put('uploads/posts/cover_image', $data['cover_image']);
        }
         
        $post->save();
        if(Arr::exists($data, 'technologies')){
            $post->technologies()->attach($data['technologies']);
        }

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $types = Type::all();
        $technologies = Technology::all();

        $technology_ids = $post->technologies->pluck('id')->toArray();

        return view('admin.posts.edit', compact('post','types', 'technologies', 'technology_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->all();
        Validator::make(
            $data,
            [
                'title' => 'required|string',
                'cover_image' => 'nullable|image',
                'content' => 'required',
                'slug' => 'required',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id'
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.string' => 'Il titolo deve essere una stringa',
                'cover_image.image' => 'Il file caricato deve essere un\'immagine',
                'content.required' => 'Il contenuto è obbligatorio',
                'slug.required' => 'Lo slug è obbligatorio',
                'type_id.exists' => 'Il tipo inserito non è valido',
                'technologies.exists' => 'La tecnologia inserita non è valida'
            ]
            )->validate();
            
        $post->update($data);
        $post->fill($data);

        if($request->hasFile('cover_image')){
            if($post->cover_image){
                Storage::delete($post->cover_image);
            }

            $post->cover_image = Storage::put('uploads/posts/cover_image', $data['cover_image']);
        }

    $post->save();

        if(Arr::exists($data, 'technologies')){
            $post->technologies()->sync($data['technologies']);
        }
        else{
            $post->technologies()->detach();
        }
        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->technologies()->detach();
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
    public function deleteImage(Post $post){
        Storage::delete($post->cover_image);
        $post->cover_image = null;
        $post->save();
        return redirect()->back();
    }
}
