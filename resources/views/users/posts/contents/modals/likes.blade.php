<div class="modal fade" id="liked-post-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h3 class="h5 modal-title text-primary">
                    User who liked this post
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @forelse ($post->likes as $user_likes)
                    <ul>
                        <li>{{ $user_likes->user->name }}</li>
                    </ul>
                @empty
                    <p class="text-muted fw-bold text-danger">No likes yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
