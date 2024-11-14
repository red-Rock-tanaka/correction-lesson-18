<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $list = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', ['lists' => $list]);
    }

    public function createForm()
    {
        return view('posts.createForm');
    }

    public function create(Request $request)
    {
        $request->validate([
            'newPost' => 'required|not_regex:/^\s*$/u|max:100', // 半角・全角スペースのみを禁止し、100文字以下を要求
        ], [
            'newPost.required' => '文字を入力してください。',
            'newPost.not_regex' => '文字を入力してください。', // 半角・全角スペースのみの場合のエラーメッセージ
            'newPost.max' => '100文字以下で入力してください。', // 100文字を超えた場合のエラーメッセージ
        ]);

        $post = new Post;
        $post->contents = $request->input('newPost');
        $post->user_name = auth()->user()->name;
        $post->save();
        return redirect('/index');
    }

    public function updateForm($id)
{
    $post = DB::table('posts')
        ->where('id', $id)
        ->first();
    return view('posts.updateForm', ['post' => $post]);
}
    public function update(Request $request)
{
    $request->validate([
        'upPost' => 'required|not_regex:/^\s*$/u|max:100', // 半角・全角スペースのみを禁止し、100文字以下を要求
    ], [
        'upPost.required' => '文字を入力してください。',
        'upPost.not_regex' => '文字を入力してください。',
        'upPost.max' => '100文字以下で入力してください。',
    ]);

    $id = $request->input('id');
    $up_post = $request->input('upPost');
    DB::table('posts')
        ->where('id', $id)
        ->update(['contents' => $up_post]);
    return redirect('/index');
}
    public function delete($id)
    {
        DB::table('posts')
            ->where('id', $id)
            ->delete();
        return redirect('/index');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    // コントローラーの例
    public function search(Request $request) {
        $query = $request->input('query');
        $lists = Post::where('contents', 'LIKE', '%' . $query . '%')->get(); // 検索処理
        return response()->json($lists);
    }
}
