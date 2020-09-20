<div class="media mt-3">
    <a class="pr-3" href="#">
        <img class="user-logo" src="/img/user.png" alt="Generic placeholder image">
    </a>
    <div class="media-body">
        <h5 class="mt-0">{{$replies->user->name}}
            <span> <i class="fa fa-reply" aria-hidden="true"></i> {{$replies->user_to_replies->user->name}} </span>
            @auth
                @if(auth()->user()->id == $replies->user_id)
            <a class="btn btn-danger delete" href="{{route('delete-comment',['id'=>$replies->id])}}">Delete</a>
                @endif
            @endauth
        </h5>
            {{$replies->description}}
            @auth
                    <a href="#" data-toggle="modal" data-target="#commentReplie{{$replies->id}}" style="margin-top: 10px">
                        <i class="fa fa-comment" aria-hidden="true"> Reply</i>
                    </a>
            @endauth

    </div>
</div>


    <div class="modal fade" id="commentReplie{{$replies->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="form-submit"  method="post" enctype="multipart/form-data" action="{{route('create-comment')}}">

                {{csrf_field()}}
                <div class="modal-content" style="padding: 5px">
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>

                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <input type="hidden" name="parent_id" value="{{$replies->id}}">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@if ($replies->replies)
        @foreach ($replies->replies as $comment)
            @include('replies', ['replies' => $comment])
        @endforeach
@endif
