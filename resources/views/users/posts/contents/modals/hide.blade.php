<div class="modal fade" id="hide-comment-{{$comment->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-eye-slash"></i>  Hide Post
                </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to hide this post?</p>
            </div>
            <div class="modal-footer border-0">
                <div class="modal-footer border-0">
                    <form action="{{ route('comment.hide',$comment->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        &middot;
                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning btn-sm">Hide</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
