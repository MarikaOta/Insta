{{-- Clickable Image --}}
<div class="container p-0">
    <a href="{{ route('post.show',$post->id) }}">
        <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="w-100">
    </a>
</div>
<div class="card-body">
    {{-- heart icon + no. of likes + categories (on the right side) --}}
    <div class="row align-items-center">
        <div class="col-auto">
            @if ($post->isLiked())
                <form action="{{ route('like.destroy', $post->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn shadow-none sm p-0"><i class="fa-solid fa-heart text-danger"></i></button>
                </form>
            @else
                <form action="{{ route('like.store', $post->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn shadow-none sm p-0"><i class="fa-regular fa-heart"></i></button>
                </form>
            @endif
        </div>
        <div class="col-auto px-0">
            <span>{{ $post->likes->count() }}</span>
        </div>
        <div class="col text-end">
            @forelse ($post->categoryPost as $category_post)
                <span class="badge bg-secondary bg-opacity-50">{{ $category_post->category->name }}</span>
            @empty
                <div class="badge bg-dark text-wrap">Uncategorized</div>
            @endforelse
            {{-- @foreach($post->categoryPost as $category_post)
                <div class="badge bg-secondary bg-opacity-50">{{$category_post->category->name}}</div>
            @endforeach --}}
        </div>
    </div>

    {{-- Owner of the post + description of the post --}}
    <a href="{{ route('profile.show',$post->user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $post->user->name }}</a>
    {{-- &nbsp; is use to add a very small space --}}
    &nbsp;
    <p class="d-inline fw-light">{{ $post->description }}</p>
    <p class="text-uppercase text-muted xsmall">{{ date('M d, Y',strtotime($post->created_at)) }}</p>
    <p class="text-danger small">Post in {{ $post->created_at->diffForHumans() }}</p>

    {{-- date(format, unix-time) --}}
    {{-- strtotime('2024-04-04 11:57:31')  i can see--}}
    {{-- date('M d, Y', 1657760251) compoter memory --}}

    @include('users.posts.contents.comments')

</div>


