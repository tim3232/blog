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
        <div class="col-lg-12 mx-auto">
            <div class="post-preview">
                    <div  class="row image-row" style="background-color: white; border-radius: 5px; padding: 5px">
                        <div class="col-md-4">
                            <img class="card-img-top" src="{{$post->image ? '/images/'.$post->image : '/img/logo.png'}}">
                        </div>
                        <div class="col-md">
                            <h5 class="card-title">
                                @auth
                                    @if(auth()->user()->id == $post->user_id)
                                        <a role="button" class="btn btn-danger float-right" href="{{route('delete-post',['id'=>$post->id])}}">Delete</a>
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

            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            @if(auth()->user())
                <div class="row">
                    <form class="form-submit mx-auto" style="margin-top: 10px"  method="post" enctype="multipart/form-data" action="{{route('create-comment')}}">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <textarea name="description" class="text-center"></textarea>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button class="btn-success" type="submit">Send comment</button>
                        </div>

                    </form>
                </div>
            @endif

                <div class="row" style="margin-top: 20px">
            @foreach($post->comments as $comment)

                    <div class="media col-md-12">
                        <img class="user-logo" src="/img/user.png" alt="Generic placeholder image">

                        <div class="media-body" style="word-break: break-all;">
                            <h5 class="mt-0">{{$comment->user->name}}
                                @auth
                                    @if(auth()->user()->id == $comment->user_id)
                                <a class="btn btn-danger delete" href="{{route('delete-comment',['id'=>$comment->id])}}">Delete</a>
                                    @endif
                                @endauth
                            </h5>
                            <div class="comment-container">
                                 {{$comment->description}}
                            </div>

                                @auth
                                    <a href="#" data-toggle="modal" style="margin-top: 10px" data-target="#commentReplie{{$comment->id}}">
                                        <i class="fa fa-comment" aria-hidden="true"> Reply</i>
                                    </a>
                                @endauth

                            @foreach($comment->replies as $replies)
                                @include('replies', ['replies' => $replies])
                            @endforeach
                        </div>
                    </div>

                    <div class="modal fade" id="commentReplie{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form class="form-submit"  method="post" enctype="multipart/form-data" action="{{route('create-comment')}}">

                                {{csrf_field()}}
                                <div class="modal-content" style="padding: 5px">

                                    <div class="form-group">
                                        <label>Comment</label>
                                        <textarea class="form-control" name="description" required></textarea>
                                    </div>

                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <input type="hidden" name="parent_id" value="{{$comment->id}}">
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

            @endforeach


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
                                    <textarea class="form-control" name="body" type="text" required style="min-height: 150px">{{$post->body}}</textarea>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-file">
                                        <button class="btn btn-default btn-choose" type="button">Choose</button>
                                        <input type="text" class="form-control align-self-center" placeholder='Choose image...' />
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

        </div>
        </div>
    </div>
@endsection