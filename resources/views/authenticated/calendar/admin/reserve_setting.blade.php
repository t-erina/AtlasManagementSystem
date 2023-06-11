@extends('layouts.sidebar')
@section('content')
<div class="calendar_wrapper">
  <div class="calendar_container">
    <p class="calendar_month">{{ $calendar->getTitle() }}</p>
    <div>{!! $calendar->render() !!}</div>

    <div class="text-right">
      <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
    </div>
  </div>
</div>
@endsection
