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
            <a href="{{ route('student.archived') }}">Archived courses</a>
          </li>
        </ul>
      </div>
    </div>
  </header>

  <div class="py-3">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="px-6 py-3 bg-white border-b border-gray-200">
          <span><b>Archived marks for: </b><b class="text-blue-500">{{ $course->name }} Group:
              {{ $registration->courses->find($course->id)->pivot->group }}</b></span>
          <span class="text-sm font-bold ml-4">Semester: </span> <span
            class="text-blue-500">{{ $registration->semester_name }}</span>
          <span class="text-sm font-bold ml-4">From: </span> <span
            class="text-blue-500">{{ $registration->semester_start_date->format('Y-M-d') }}</span>
          <span class="text-sm font-bold ml-4">To: </span> <span
            class="text-blue-500">{{ $registration->semester_end_date->format('Y-M-d') }}</span>
        </div>
      </div>

      <div class="px-6 py-4">

        @if (count($marks) > 0)
          @foreach ($marks as $mark)
            <table class="table bordered" style="table-layout: fixed;
            width: 100%;">
              <tr>
                <th>Title</th>
                <th>Course</th>
                <th>Action</th>
              </tr>

              <tr>
                <td>{{ $mark->title }}</td>
                <td>{{ $mark->course->name }}</td>
                <td class="flex items-center gap-2">
                  <a id="link_{{ $mark->id }}" class="button is-small is-info"
                    onclick="toggleMarks({{ $mark->id }})">
                    <i id="icon_{{ $mark->id }}"
                      class="fas fa-plus mr-2 rounded-full p-1 flex items-center border"></i>
                    <span>View</span>
                  </a>
                </td>
              </tr>
              <table id="table_{{ $mark->id }}"
                class="hidden table-bordered small text-sm bg-gray-200 w-3/4 border p-4 small mb-6">
                @foreach ($mark->markExcels as $markExcel)
                  <tr>
                    @if ($markExcel->column0)
                      <td
                        class="{{ $markExcel->column0 == auth()->user()->student->rollno ? 'rollno' : '' }}">
                        {{ $markExcel->column0 }}
                      </td>
                    @endif
                    @if ($markExcel->column1)
                      <td class="{{ $markExcel->column1 == auth()->user()->student->rollno ? 'rollno' : '' }}">
                        {{ $markExcel->column1 }}</td>
                    @endif
                    @if ($markExcel->column2)
                      <td class="{{ $markExcel->column2 == auth()->user()->student->rollno ? 'rollno' : '' }}">
                        {{ $markExcel->column2 }}</td>
                    @endif
                    @if ($markExcel->column3)
                      <td class="{{ $markExcel->column3 == auth()->user()->student->rollno ? 'rollno' : '' }}">
                        {{ $markExcel->column3 }}</td>
                    @endif
                    @if ($markExcel->column4)
                      <td class="{{ $markExcel->column4 == auth()->user()->student->rollno ? 'rollno' : '' }}">
                        {{ $markExcel->column4 }}</td>
                    @endif
                    @if ($markExcel->column5)
                      <td class="{{ $markExcel->column5 == auth()->user()->student->rollno ? 'rollno' : '' }}">
                        {{ $markExcel->column5 }}</td>
                    @endif
                    @if ($markExcel->column6)
                      <td class="{{ $markExcel->column6 == auth()->user()->student->rollno ? 'rollno' : '' }}">
                        {{ $markExcel->column6 }}</td>
                    @endif
                    @if ($markExcel->column7)
                      <td class="{{ $markExcel->column7 == auth()->user()->student->rollno ? 'rollno' : '' }}">
                        {{ $markExcel->column7 }}</td>
                    @endif
                    @if ($markExcel->column8)
                      <td class="{{ $markExcel->column8 == auth()->user()->student->rollno ? 'rollno' : '' }}">
                        {{ $markExcel->column8 }}</td>
                    @endif
                    @if ($markExcel->column9)
                      <td class="{{ $markExcel->column9 == auth()->user()->student->rollno ? 'rollno' : '' }}">
                        {{ $markExcel->column9 }}</td>
                    @endif
                  </tr>
                @endforeach
              </table>
          @endforeach
          </table>
        @else
          <div><b>no marks found for this course !</b></div>
        @endif
      </div>
    </div>
    <script>
      // show / hide marks
      function toggleMarks(markid) {

        document.getElementById('table_' + markid).classList.toggle('hidden');

        document.getElementById('icon_' + markid).classList.toggle('fa-plus');

        document.getElementById('icon_' + markid).classList.toggle('fa-minus');

        if (document.getElementById('link_' + markid).children[1].textContent == "View") {
          document.getElementById('link_' + markid).children[1].textContent = "Hide";
        } else {
          document.getElementById('link_' + markid).children[1].textContent = "View";
        }
      }
    </script>
</x-app-layout>
