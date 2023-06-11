@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 m-auto d-flex">
  <div class="post_view w-75 mt-5">
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p class="post_username"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p class="post_title"><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        <!-- カテゴリー -->
        <input type="submit" name="category_word" class="category_btn" value="{{ $post->subCategories->first()->sub_category }}" form="postSearchRequest">
        <div class="d-flex post_status">
          <div class="mr-5">
            <!-- コメント -->
            <p class="post_icons m-0"><i class="fa fa-comment"></i><span class="comment_count">{{ $post->postComments->count() }}</span></p>
          </div>
          <div>
            <!-- いいね -->
            @if(Auth::user()->is_Like($post->id))
            <p class="post_icons m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @else
            <p class="post_icons m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area w-25">
    <div class="m-4">
      <div class="search_content_margin"><a class="post_btn blue btn_big" href="{{ route('post.input') }}">投稿</a></div>
      <div class="search_form search_content_margin">
        <input class="search_input" type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input class="search_submit" type="submit" value="検索" form="postSearchRequest">
      </div>
      <div class="search_content search_content_margin">
        <input type="submit" name="like_posts" class="category_btn pink btn_big" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="category_btn yellow btn_big" value="自分の投稿" form="postSearchRequest">
      </div>
      <ul>
        <p>カテゴリー表示</p>
        @foreach($categories as $category)
        <li class="main_categories" category_id="{{ $category->id }}">
          <div class="accordion_btn">
            <span>{{ $category->main_category }}</span>
            <div class="arrow"><span class="arrow_inner"></span></div>
          </div>
          <ul class="sub_category_wrapper js_tab">
            @foreach($category->subCategories as $subCategory)
            <li class="sub_category"><input type="submit" name="category_word" class="sub_category_input" value="{{ $subCategory->sub_category }}" form="postSearchRequest"></li>
            @endforeach
          </ul>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
