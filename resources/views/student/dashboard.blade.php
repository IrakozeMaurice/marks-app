<x-app-layout>

  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8 flex gap-4">
      <div class="header flex items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          <a class="text-blue-500 underline" href="/dashboard">{{ __('Dashboard') }}</a>
        </h2>
      </div>
      <div class="menu flex justify-center items-center flex-1">
        <ul class="flex justify-center items-center gap-8">
          <li class="bg-gray-300 px-4 py-1 rounded-lg"><a href="{{ route('student.enrolled') }}">Enrolled courses <span
                class="bg-blue-500 rounded-full text-white"
                style="display: inline-block;width: 20px; height: 20px; text-align: center;line-height: 20px;">{{ $registration ? $registration->courses->count() : 0 }}</span></a>
          </li>
          <li><a href="{{ route('student.archived') }}">Archived courses</a></li>
        </ul>
      </div>
    </div>
  </header>

  <div class="py-3">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="px-6 py-3 bg-white border-b border-gray-200">
          Welcome <span class="text-blue-600">{{ auth()->user()->names }}</span>
        </div>
      </div>

      <div class="mt-2 mb-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="px-6 py-2 bg-white border-b border-gray-200">
          <span><b>Your current registration form</b></span>
        </div>
      </div>
      @if ($registration)

        <div class="border p-4 text-sm" style="width: 80%;margin:auto;">
          <div class="row">
            <div class="col-md-6 text-left">
              <p>Student Number: {{ $registration->student->rollno }}</p>
              <p>Student Names: {{ $registration->student->names }}</p>
            </div>
            <div class="col-md-6 text-right">
              <p>Faculty: {{ $registration->student->faculty }}</p>
              <p>Department: {{ $registration->student->department }}</p>
              <p>Program: {{ $registration->student->program }}</p>
            </div>
          </div>
          <hr>
          <table class="table table-borderless">
            <thead>
              <tr>
                <th>CODE</th>
                <th>COURSE DESCRIPTION</th>
                <th>CREDITS</th>
                <th>GROUP</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($registration->courses as $course)
                <tr>
                  <td>{{ $course->code }}</td>
                  <td>{{ $course->name }}</td>
                  <td>{{ $course->credits }}</td>
                  <td>{{ $course->pivot->group }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="p-6">You have no current registration</div>
      @endif
    </div>
</x-app-layout>
