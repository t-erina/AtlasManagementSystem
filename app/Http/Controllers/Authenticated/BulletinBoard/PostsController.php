<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function show(Request $request)
    {
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::with('subCategories')->get();
        $like = new Like;
        $post_comment = new Post;
        if (!empty($request->keyword)) {
            $posts = Post::with('user', 'postComments')
                ->where('post_title', 'like', '%' . $request->keyword . '%')
                ->orWhere('post', 'like', '%' . $request->keyword . '%')->get();
        } else if ($request->category_word) {
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')
                ->whereHas('subCategories', function ($q) use ($request) {
                    $q->where('sub_category', $request->category_word);
                })
                ->get();
        } else if ($request->like_posts) {
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
                ->whereIn('id', $likes)->get();
        } else if ($request->my_posts) {
            $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id)
    {
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput()
    {
        $main_categories = MainCategory::with('subCategories')->get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    public function postCreate(PostFormRequest $request)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        $sub_categories = $request->post_category_id;
        $category = Post::findOrFail($post->id);
        $category->subCategories()->attach($sub_categories);
        return redirect()->route('post.show');
    }

    public function postEdit(Request $request)
    {
        //バリデーションの追加
        $rules = [
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ];

        $messages = [
            'post_title.required' => ':attributeは入力必須項目です',
            'post_title.max' => ':attributeは100文字以内で入力してください',
            'post_body.required' => ':attributeは入力必須項目です',
            'post_body.max' => ':attributeは5000文字以内で入力してください',
        ];

        $attributes = [
            'post_title' => 'タイトル',
            'post_body' => '投稿内容'
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    public function mainCategoryCreate(Request $request)
    {
        //バリデーション
        $request->validate(
            [
                'main_category_name' => 'required|max:100|string|unique:main_categories,main_category',
            ],
            [
                'main_category_name.required' => '必須項目です',
                'main_category_name.max' => '最大文字数は100文字です',
                'main_category_name.string' => '文字列を入力してください',
                'main_category_name.unique' => '既に存在します'
            ]
        );

        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    public function subCategoryCreate(Request $request)
    {
        //バリデーション
        $request->validate(
            [
                'main_category_id' => 'required|exists:main_categories,id',
                'sub_category_name' => 'required|max:100|string|unique:sub_categories,sub_category'
            ],
            [
                'main_category_id.required' => 'メインカテゴリーを選択してください',
                'main_category_id.exists' => '存在しないカテゴリーです',
                'sub_category_name.required' => 'サブカテゴリーは必須項目です',
                'sub_category_name.max' => '最大文字数は100文字です',
                'sub_category_name.string' => '文字列を入力してください',
                'sub_category_name.unique' => 'このサブカテゴリーは既に存在します'
            ],
        );

        SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'sub_category' => $request->sub_category_name
        ]);
        return redirect()->route('post.input');
    }

    public function commentCreate(Request $request)
    {
        //コメントのバリデーション
        $request->validate(
            [
                'comment' => 'required|max:2500|string',
            ],
            [
                'comment.required' => '必須項目です',
                'comment.max' => '最大文字数は2500文字です',
                'comment.string' => '文字列を入力してください'
            ]
        );

        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard()
    {
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard()
    {
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->delete();

        return response()->json();
    }
}
