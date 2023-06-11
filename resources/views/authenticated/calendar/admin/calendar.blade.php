@extends('layouts.sidebar')

@section('content')
<div class="calendar_wrapper">
  <div class="calendar_container">
    <p class="calendar_month">{{ $calendar->getTitle() }}</p>
    <p>{!! $calendar->render() !!}</p>
  </div>
</div>
@endsection
