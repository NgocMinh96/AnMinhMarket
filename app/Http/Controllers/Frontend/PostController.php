<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostList;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $postList = PostList::select('*')
            ->where('status', 1)
            ->orderBy('created_at', 'DESC');

        if (isset($request->search_value)) $postList->where("title", 'like', "%$request->search_value%");
        $postList = $postList->paginate(env('PAGINATION_CLIENT_POST'));

        $postSpecial = PostList::select('*')->where('status', 1)->where('special', 1)->limit(5)->get();

        session()->flashInput($request->input());
        return view('frontend.post.index', compact('postList', 'postSpecial'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = PostList::select('*')->where('id', $id)->first();
        $postSpecial = PostList::select('*')->where('status', 1)->where('special', 1)->limit(5)->get();
        return view('frontend.post.show', compact('post', 'postSpecial'));
    }
}
