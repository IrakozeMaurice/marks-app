@extends('layouts.teacher.dashboard')

@section('content')
  <div>
    {{ auth()->user()->names }}
  </div>
@endsection
