@extends('layouts.sidebar')

@section('content')
<div class="calendar_wrapper vh-100">
  <div class="calendar_container">
    <div class="m-auto">
      <p class="calendar_month">{{ $calendar->getTitle() }}</p>
      <div>
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
@endsection
