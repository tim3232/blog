<div class="media mt-3" style="background: #FFFDDD; padding: 10px; border-radius: 5px">

    <a class="pr-3" href="#">
        <img src="http://fakeimg.pl/50x50" alt="Generic placeholder image">
    </a>
    <div class="media-body">
        <h5 class="mt-0">{{$replies->user->name}}
            @auth
                @if(auth()->user()->id == $replies->user_id)
            <a class="btn btn-danger delete" href="{{route('delete-comment',['id'=>$replies->id])}}">Delete</a>
                @endif
            @endauth
        </h5>
        <p>
            {{$replies->description}}
            @auth
                <a href="#" data-toggle="modal" data-target="#commentReplie{{$replies->id}}" style="margin-top: 10px">reply</a>
            @endauth
        </p>

    </div>
</div>


    <div class="modal fade" id="commentReplie{{$replies->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="form-submit"  method="post" enctype="multipart/form-data" action="{{route('create-comment')}}">

                {{csrf_field()}}
                <div class="modal-content" style="padding: 5px">
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea class="form-control" name="description" required style="min-height: 150px"></textarea>
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

@if ($replies->description)
        @foreach ($replies->replies as $comment)
            @include('replies', ['replies' => $comment])
        @endforeach

@endif
