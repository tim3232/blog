@extends('layouts.app')

@section('content')
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger mx-auto">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="row">
        @auth
            @if(auth()->user()->right)
                <button class="btn btn-success mx-auto" data-toggle="modal" data-target="#createPost">Create post</button>
            @endif
        @endauth

        <div class="col-lg-11 col-md-10 mx-auto">
            <div class="post-preview">
                @foreach($posts as $post)
                    <div  class="row image-row col-md-11" style="background-color: white; border-radius: 5px; padding: 5px">
                        <div class="col-md-4">
                            <img class="card-img-top" src="{{$post->image ? '/images/'.$post->image : '/img/logo.png'}}">
                        </div>
                        <div class="col-md">
                            <h5 class="card-title">
                                <a class="btn btn-success float-right" href="{{route('post',['id' => $post->id])}}">Details</a>
                                @auth
                                    @if(auth()->user()->id == $post->user_id)
                                        <a class="btn btn-danger float-right"  href="{{route('delete-post',['id' => $post->id])}}">Delete</a>
                                    @endif
                                @endauth
                            </h5>
                            <p class="post-meta">{{$post->name}}</p>
                            <p class="post-title">{{$post->body}}</p>
                            @auth
                                @if(auth()->user()->id == $post->user_id)
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPost{{$post->id}}">
                                        Change post
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </div>


                    <div class="modal fade" id="modalPost{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form class="form-submit"  method="post" enctype="multipart/form-data" action="{{route('update-post',['id'=>$post->id])}}">

                                {{csrf_field()}}
                                <div class="modal-content" style="padding: 5px">

                                    <div class="form-group">
                                        <label>Post name</label>
                                        <input class="form-control" name="name" type="text" value="{{$post->name}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Post text</label>
                                        <textarea class="form-control" name="body" type="text" required style="min-height: 150px;">{{$post->body}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group input-file">
                                            <button class="btn btn-default btn-choose" type="button">Choose</button>
                                            <input type="text" class="form-control align-self-center" placeholder='Choose a file...' />
                                            <button class="btn btn-warning btn-reset" type="button">Reset</button>
                                        </div>
                                    </div>

                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                @endforeach

                {{$posts->links()}}
            </div>

        </div>

        <div class="modal fade" id="createPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="form-submit"  method="post" enctype="multipart/form-data" action="{{route('create-post')}}">

                    {{csrf_field()}}
                    <div class="modal-content" style="padding: 5px">

                        <div class="form-group">
                            <label>Post name</label>
                            <input class="form-control" name="name" type="text" required>
                        </div>
                        <div class="form-group">
                            <label>Post text</label>
                            <textarea class="form-control" name="body" type="text" required style="min-height: 150px;"></textarea>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-file">
                                <button class="btn btn-default btn-choose" type="button">Choose</button>
                                <input type="text" class="form-control align-self-center" placeholder='Choose image...' />
                                <button class="btn btn-warning btn-reset" type="button">Reset</button>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection