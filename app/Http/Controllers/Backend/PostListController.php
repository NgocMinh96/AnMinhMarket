<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PostList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (session('postlist_row') == null) $request->session()->put('postlist_row', env('PAGINATION'));
        if (isset($request->select_row)) $request->session()->put('postlist_row', $request->select_row);
        $query = PostList::select('*')->orderBy('id', 'DESC');

        if (isset($request->search_value)) $query->where('title', 'like', "%$request->search_value%");
        if ($request->start != '' && $request->end != '') {
            $start = date('Y-m-d H:i:s', strtotime($request->start));
            $end   = date('Y-m-d 23:59:59', strtotime($request->end));
            $query->whereBetween('created_at', [$start, $end]);
        }
        if ($request->status != '') $query->where('status', $request->status);
        if ($request->special != '') $query->where('special', $request->special);
        if ($request->author != '') $query->where('author_name', $request->author);

        $posts = $query->paginate(session('postlist_row'));
        $author = PostList::select('author_name')->groupBy('author_name')->get();

        session()->flashInput($request->input());
        return view('backend.postlist.index', compact('posts', 'author'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.postlist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errorMsgs = [
            'title.required'            => 'Bạn chưa nhập tiêu đề',
            'description.required'      => 'Bạn chưa nhập mô tả',
            'content.required'          => 'Bạn chưa nhập nội dung',
            'image.required'            => 'Bạn chưa chọn hình ảnh',
            'image.mimes'               => 'Định dạng hình là jpeg,png,jpg',
            'image.image'               => 'Chỉ được tải lên tệp hình ảnh',
            'ordering.numeric'          => 'Chỉ được nhập số từ 0 đến 100',
            'ordering.mix'              => 'Chỉ được nhập số từ 0 đến 100',
            'ordering.max'              => 'Chỉ được nhập số từ 0 đến 100',
        ];

        $rule = [
            'title'         => 'required|string|max:120',
            'description'   => 'required|string|max:300',
            'content'       => 'required',
            'ordering'      => 'numeric|min:0|max:100',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rule, $errorMsgs);

        if ($validator->passes()) {
            $imageName = time() . '.' . $request->image->extension();
            $data = [
                'title'         => $request->title,
                'slug'          => Str::slug($request->title, '-'),
                'description'   => $request->description,
                'content'       => $request->content,
                'status'        => $request->status,
                'special'       => $request->special,
                'ordering'      => $request->ordering,
                'keyword'       => $request->keyword,
                'image'         => $imageName,
                'author_id'     => $request->user()->id,
                'author_name'   => $request->user()->name,
            ];
            PostList::create($data);
            $request->image->move(public_path('images'), $imageName);

            return redirect()->route('backend.postlist.index')->with('success', 'Thêm mới thành công');
        } else {
            return back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $post = PostList::find($id);
        if ($user->hasRole('admin') == true || $post->author_id == $user->id) {
            return view('backend.postlist.edit', compact('post'));
        } else {
            return redirect()->back()->with('warning', 'Bạn không thể chỉnh sửa bài viết của người khác');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $errorMsgs = [
            'title.required'            => 'Bạn chưa nhập tiêu đề',
            'description.required'      => 'Bạn chưa nhập mô tả',
            'content.required'          => 'Bạn chưa nhập nội dung',
            'image.mimes'               => 'Định dạng hình là jpeg,png,jpg',
            'image.image'               => 'Chỉ được tải lên tệp hình ảnh',
            'ordering.numeric'          => 'Chỉ được nhập số từ 0 đến 100',
            'ordering.mix'              => 'Chỉ được nhập số từ 0 đến 100',
            'ordering.max'              => 'Chỉ được nhập số từ 0 đến 100',
        ];

        $rule = [
            'title'         => 'required|string|max:120',
            'description'   => 'required|string|max:300',
            'content'       => 'required',
            'ordering'      => 'numeric|min:0|max:100',
            'image'         => 'image|mimes:jpeg,png,jpg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rule, $errorMsgs);

        if ($validator->passes()) {
            $data = [
                'title'         => $request->title,
                'slug'          => Str::slug($request->title, '-'),
                'description'   => $request->description,
                'content'       => $request->content,
                'status'        => $request->status,
                'special'       => $request->special,
                'ordering'      => $request->ordering,
                'keyword'       => $request->keyword,
            ];

            if ($request->file('image') !== null) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $post = PostList::find($id);
                $imagePath = 'images/' . $post->picture;
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
                $data = $data + ['image' => $imageName];
            };

            PostList::where('id', $id)->update($data);

            return redirect()->route('backend.postlist.index')->with('success', 'Thay đổi thành công');
        } else {
            return back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->user()->hasRole('admin')) {
            $data = PostList::find($id);
            $image_path = 'images/' . $data->image;
            if (file_exists($image_path)) {
                @unlink($image_path);
            }
            PostList::destroy($id);
            return redirect()->back()->with('success', 'Xóa dữ liệu thành công');
        } else {
            return redirect()->back()->with('warning', 'Bạn không có quyền xóa bài viết');
        }
    }
}
