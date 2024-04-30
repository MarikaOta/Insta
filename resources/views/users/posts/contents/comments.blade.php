<div class="mt-3">
    {{-- Show all the comments here --}}
           {{-- Show all comments --}}
           @if($post->comments->isNotEmpty())
                <hr>
                <ul class="list-group">
                    @foreach($post->comments->take(3) as $comment)
                        <li class="list-group-item border-0 p-0 mb-2">
                            <a href="{{ route('profile.show', $comment->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                            &nbsp;
                            <p class="d-inline fw-light">{{ $comment->body }}</p>
                            {{-- comment delete --}}
                            <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <span class="text-uppercase text-muted xsmall">
                                    {{ date('M d, Y',strtotime($comment->created_at)) }}
                                </span>

                                {{-- If the AUTH (the user that is authenticated and logged-in) User  is the owner of the comment, then show the DELETE button--}}
                                @if (Auth::user()->id === $comment->user->id)
                                    &middot;
                                    <button type="submit" class="border-0 bg-transparent text-danger p-0 small">Delete</button>
                                @endif
                            </form>

                            {{-- comment hide button--}}
                            @if (Auth::user()->id === $post->user->id)
                                @if ($comment->trashed())
                                    &middot;
                                    <button class="text-success bg-transparent p-0 small border-0" data-bs-toggle="modal" data-bs-target="#unhide-comment-{{$comment->id}}" title="Unhide">Unhide</button>
                                @else
                                    &middot;
                                    <button class="text-warning bg-transparent p-0 small border-0" data-bs-toggle="modal" data-bs-target="#hide-comment-{{$comment->id}}" title="Hide">Hide</button>
                                @endif

                            @endif
                            @include('users.posts.contents.modals.hide')
                        </li>
                    @endforeach

                    @if($post->comments->count() > 3)
                        <li class="list-group-item border-0 px-0 pt-0">
                            <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small">View All {{ $post->comments->count() }} comments</a>
                        </li>
                    @endif
                </ul>
            @endif


    <form action="{{ route('comment.store', $post->id) }}" method="post">
        @csrf
        <div class="input-group">
            <textarea name="comment_body{{ $post->id }}" id="" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{ old('comment_body' . $post->id) }}</textarea>
            <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
        </div>
        {{-- Error message area --}}
        @error('comment_body' . $post->id)
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </form>

    {{-- <div class="mt-3">
        @foreach($comments as $comment)
            <div class="input-group">
                <p>{{ $comment->user->name }}</p>
                <p>{{ $comment->body }}</p>
                <p>{{ $comment->created_at }}</p>
            </div>
        @endforeach
    </div> --}}


</div>
