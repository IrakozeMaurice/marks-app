<x-app-layout>

  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 flex gap-4">
      <div class="header flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          <a class="text-blue-500 underline" href="/dashboard">{{ __('Dashboard') }}</a>
        </h2>
      </div>
      <div class="menu flex justify-center items-center flex-1">
        <ul class="flex justify-center gap-8 items-center">
          <li>
            <a href="{{ route('student.enrolled') }}">Enrolled courses</a>
          </li>
          <li class="bg-gray-300 px-4 py-1 rounded-lg">
            <a href="">Archived courses</a>
          </li>
        </ul>
      </div>
    </div>
  </header>

  <div class="py-3">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="px-6 py-3 bg-white border-b border-gray-200">
          <span><b>Archived courses</b></span>
        </div>
      </div>

      <div class="px-6 py-4">

        @forelse ($registrations as $registration)
          <div class="bg-white overflow-hidden shadow-sm mb-4">
            <div class="bg-gray-200 text-sm flex gap-4 p-3">
              <div>
                <span><b>Semester: </b></span> <span class="has-text-info">{{ $registration->semester_name }}</span>
              </div>
              <div>
                <span><b>From: </b></span> <span
                  class="has-text-info">{{ $registration->semester_start_date->format('Y-M-d') }}</span>
              </div>
              <div>
                <span><b>To: </b></span> <span
                  class="has-text-info">{{ $registration->semester_end_date->format('Y-M-d') }}</span>
              </div>
            </div>
            <table class="table mb-0">
              <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Group</th>
                <th>Action</th>
              </tr>

              @foreach ($registration->courses as $course)
                <tr>
                  <td>{{ $course->code }}</td>
                  <td>{{ $course->name }}</td>
                  <td>{{ $course->pivot->group }}</td>
                  <td><a
                      href="{{ route('student.marks.showarchived', ['registration' => $registration->id, 'course_code' => $course->code]) }}">view
                      marks</a></td>
                </tr>
              @endforeach
            </table>
          </div>
        @empty
          <div><b>no previous semesters found !</b></div>
        @endforelse

      </div>
    </div>
</x-app-layout>
