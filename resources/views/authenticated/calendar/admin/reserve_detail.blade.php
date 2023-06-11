@extends('layouts.sidebar')

@section('content')
<div class="reserve_wrapper">
  <p class="reserve_day"><span>{{ $date }}日</span><span class="ml-3">{{ $part }}部</span></p>
  <div class="reserve_contaier">
    <table class="reserve_table">
      <tr class="text-center">
        <th class="w-25">ID</th>
        <th class="w-25">名前</th>
        <th></th>
        <th class="w-25">場所</th>
      </tr>
      @foreach($reservePersons as $reservePerson)
      @foreach($reservePerson->users as $user)
      <tr class="table_items text-center">
        <td class="w-25">{{ $user->id }}</td>
        <td class="w-25">{{ $user->over_name.$user->under_name }}</td>
        <td></td>
        <td class="w-25">リモート</td>
      </tr>
      @endforeach
      @endforeach
    </table>
  </div>
</div>
@endsection
