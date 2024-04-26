<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Collection;

class CollectionController extends Controller
{
    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function store($post_id)
    {
        $this->collection->user_id = Auth::user()->id;
        $this->collection->post_id = $post_id;
        $this->collection->save();

        return redirect()->back();

    }

    public function destroy($post_id)
    {
        $this->collection
            ->where('user_id', Auth::user()->id)
            ->where('post_id', $post_id)
            ->delete();

            return redirect()->back();
    }



}
