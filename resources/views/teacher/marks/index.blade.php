@extends('layouts.teacher.dashboard')

@section('content')
  <div>

    @if (session('success'))
      <div class="notification is-primary">
        <strong>{{ session('success') }}</strong>
      </div>
    @endif
    <h1 class="mb-4">List of my courses</h1>

    <table class="table mt-2 small">
      <tr>
        <th>Course code</th>
        <th>Course Name</th>
        <th>Credits</th>
        <th>Actions</th>
      </tr>
      @foreach ($courses as $course)
        <tr>
          <td>{{ $course->code }}</td>
          <td>{{ $course->name }}</td>
          <td>{{ $course->credits }}</td>
          <td><a href="{{ route('teacher.marks.create', $course->code) }}"
              class="button is-small has-background-info has-text-white">Upload marks</a></td>
          {{-- <td>
            @if ($user->approved)
              <span class="badge badge-info p-1">approved</span>
            @else
              <a class="button is-primary" href="{{ route('admin.users.edit', $user->id) }}">
                approve</a>
            @endif
          </td> --}}
        </tr>
      @endforeach
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table>
  </div>
@endsection
