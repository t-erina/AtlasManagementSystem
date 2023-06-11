@extends('layouts.sidebar')

@section('content')
<div class="search_content w-100">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="one_person">
      <div>
        <span class="card_item_name">ID : </span><span>{{ $user->id }}</span>
      </div>
      <div><span class="card_item_name">名前 : </span>
        <a class="card_item_username" href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span class="card_item_name">カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div>
        @if($user->sex == 1)
        <span class="card_item_name">性別 : </span><span>男</span>
        @else
        <span class="card_item_name">性別 : </span><span>女</span>
        @endif
      </div>
      <div>
        <span class="card_item_name">生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div>
        @if($user->role == 1)
        <span class="card_item_name">権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span class="card_item_name">権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span class="card_item_name">権限 : </span><span>講師(英語)</span>
        @else
        <span class="card_item_name">権限 : </span><span>生徒</span>
        @endif
      </div>
      <div>
        @if($user->role == 4)
        <span class="card_item_name">選択科目 :</span>
        @if(!empty($user->subjects))
        @foreach($user->subjects->sortBy("id") as $subject)
        <span>{{ $subject->subject }}</span>
        @endforeach
        @endif
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <div class="search_area w-25">
    <div class="search_wrapper">
      <h2 class="search_user_label">検索</h2>
      <div class="search_content_margin">
        <input type="text" class="search_user_input" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div class="search_content_margin">
        <lavel class="search_user_label">カテゴリ</lavel>
        <select form="userSearchRequest" name="category" class="search_user_input">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div class="search_content_margin">
        <label class="search_user_label">並び替え</label>
        <select name="updown" form="userSearchRequest" class="search_user_input">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="search_content_margin">
        <div class="accordion_btn_search search_conditions">
          <p class="m-0 search_user_label">検索条件の追加</p>
          <div class="arrow"><span class="arrow_inner"></span></div>
        </div>
        <div class="search_conditions_inner">
          <div class="search_content_margin">
            <label class="search_user_label">性別</label>
            <div class="search_radio">
              <span class="search_radio_btn">男<input type="radio" name="sex" value="1" form="userSearchRequest"></span>
              <span class="search_radio_btn">女<input type="radio" name="sex" value="2" form="userSearchRequest"></span>
            </div>
          </div>
          <div class="search_content_margin">
            <label class="search_user_label">権限</label>
            <select name="role" form="userSearchRequest" class="engineer search_user_input">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label class="search_user_label">選択科目</label>
            <div class="search_radio">
              @foreach($subjects as $subject)
              <span class="search_radio_btn">{{ $subject->subject }}<input type="checkbox" name="subjects[]" value="{{ $subject->id }}" form="userSearchRequest"></span>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div>
        <input type="submit" name="search_btn" value="検索" form="userSearchRequest" class="search_btn blue btn_big">
      </div>
      <div class="reset_wrapper">
        <input type="reset" value="リセット" form="userSearchRequest" class="reset_btn">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
