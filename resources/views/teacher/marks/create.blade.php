@extends('layouts.teacher.dashboard')

@section('content')
  <div>


    @if (session('success'))
      <div class="notification is-primary">
        <strong>{{ session('success') }}</strong>
      </div>
    @endif

    <div class="is-small has-text-info mb-4"><b class="has-text-dark">Course name: </b>{{ $course->name }}</div>
    <form method="POST" action="{{ route('teacher.marks.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="field" style="width: 20%;">
        <label class="label is-small">Marks Title:</label>
        <div class="control has-icons-left has-icons-right">
          <input name="title" class="input is-small" type="text" value="{{ old('title') }}">

          @error('title')
            <span class="help is-danger">{{ $message }}</span>
          @enderror

          <span class="icon is-small is-left">
            <i class="fas fa-align-right"></i>
          </span>
          <span class="icon is-small is-right">
            <i class="fas fa-check"></i>
          </span>
        </div>
      </div>

      <div class="field" style="width: 20%;">
        <label class="label is-small">select file:</label>
        <div class="control">
          <input name="url" class="input is-small" type="file">

          @error('url')
            <span class="help is-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="field">
        <p class="control">
          <button type="submit" class="button is-info is-small">
            Upload
          </button>
        </p>
      </div>

    </form>



  </div>
@endsection
