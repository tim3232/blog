<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;


class MainController extends Controller
{

    public function posts(Post $post){
        $posts = $post->paginate(2);
        return view('posts',['posts' => $posts]);
    }

    public function post($id){
        $post = Post::with('comments')->findOrFail($id);
        return view('post',['post' => $post]);
    }

    public function delete_post($id){
        Post::find($id)->delete();
        return redirect()->route('posts');
    }

    public function create_comment(Request $request){
        Comment::create($request->all() + ['user_id' => 1]);
        return back();
    }

    public function delete_comment($id){
        Comment::find($id)->delete();
        return back();
    }

    public function create_post(Request $request){
        $this->validate($request, [
            'image' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);

        $post =  Post::create($request->all() + ['user_id' => auth()->user()->id]);

        if($request->hasFile('image')){
            $imageExtension = $request->file('image')->getClientOriginalExtension();
            $imageFilename = uniqid().'.'.$imageExtension;
            $post->image = $imageFilename;
            $post->save();
            $request->file('image')->move('images', $imageFilename);
        }

        return redirect()->route('post',['id' => $post->id]);
    }

    public function update_post(Request $request,$id){
        $post = Post::find($id);
        $this->validate($request, [
            'image' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
        $post->update($request->all());

        if($request->hasFile('image')){
            $imageExtension = $request->file('image')->getClientOriginalExtension();
            $imageFilename = uniqid().'.'.$imageExtension;
            $post->image = $imageFilename;
            $post->save();
            $request->file('image')->move('images', $imageFilename);
        }

        return back();
    }

    public function reset(){
        return view('auth.passwords.reset',['token' => csrf_token()]);
    }

}
