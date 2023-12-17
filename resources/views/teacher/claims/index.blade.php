@extends('layouts.teacher.dashboard')

@section('content')
  <div>

    @if (session('success'))
      <div class="notification is-primary">
        <strong>{{ session('success') }}</strong>
      </div>
    @endif

    <div class="box mb-4">
      <h2><b>Student claims</b></h2>
    </div>

    @if (count($marks) > 0)
      @foreach ($marks as $mark)
        @if ($mark->claims->count() > 0)
          <table class="table bordered" style="table-layout: fixed;
            width: 100%;">
            <tr>
              <th>Title</th>
              <th>Course</th>
              <th># of Claims</th>
              <th>Actions</th>
            </tr>

            <tr>
              <td>{{ $mark->title }}</td>
              <td>{{ $mark->course->name }}</td>
              <td>{{ $mark->claims->count() }}</td>
              <td class="flex items-center gap-2">
                <a id="link_{{ $mark->id }}" class="button is-small is-info list-none"
                  onclick="toggleMarks({{ $mark->id }})">
                  <i id="icon_{{ $mark->id }}"
                    class="fas fa-plus mr-2 rounded-full p-1 flex items-center border"></i>
                  <span>View marks</span>
                </a>
              </td>
            </tr>

            <table id="table_{{ $mark->id }}"
              class="hidden table-bordered small text-sm bg-gray-200 border p-4 small mb-6 float-left clear-both"
              style="width: 60%;">
              @foreach ($mark->markExcels as $markExcel)
                <tr>
                  @if ($markExcel->column0)
                    <td>
                      {{ $markExcel->column0 }}
                    </td>
                  @endif
                  @if ($markExcel->column1)
                    <td>
                      {{ $markExcel->column1 }}</td>
                  @endif
                  @if ($markExcel->column2)
                    <td>
                      {{ $markExcel->column2 }}</td>
                  @endif
                  @if ($markExcel->column3)
                    <td>
                      {{ $markExcel->column3 }}</td>
                  @endif
                  @if ($markExcel->column4)
                    <td>
                      {{ $markExcel->column4 }}</td>
                  @endif
                  @if ($markExcel->column5)
                    <td>
                      {{ $markExcel->column5 }}</td>
                  @endif
                  @if ($markExcel->column6)
                    <td>
                      {{ $markExcel->column6 }}</td>
                  @endif
                  @if ($markExcel->column7)
                    <td>
                      {{ $markExcel->column7 }}</td>
                  @endif
                  @if ($markExcel->column8)
                    <td>
                      {{ $markExcel->column8 }}</td>
                  @endif
                  @if ($markExcel->column9)
                    <td>
                      {{ $markExcel->column9 }}</td>
                  @endif
                </tr>
              @endforeach
            </table>
            <div id="claims_{{ $mark->id }}" class="hidden float-right clear-both p-2" style="width: 40%;">
              <h2 class="box py-2 font-bold mb-2">Claims for this marks</h2>
              @foreach ($mark->claims as $claim)
                <div class="text-sm bg-gray-200 p-4 mb-2">
                  <p class="px-2 font-bold">Student Id: <span class="has-text-info">{{ $claim->student->rollno }}</span>
                  </p>
                  <p class="px-2 font-bold">Student names: <span
                      class="has-text-info">{{ $claim->student->names }}</span>
                  </p>
                  <p class="px-2 font-bold py-2 border shadow-sm rounded-lg">Claim description: <span
                      class="has-text-info">{{ $claim->description }}</span>
                  </p>
                  <div class="mt-2">
                    <form action="{{ route('student.claims.delete', $claim->id) }}" method="POST">
                      @csrf
                      @method('DELETE')

                      <button type="submit"
                        class="button is-danger is-small py-1">mark as done</button>
                    </form>
                  </div>
                </div>
              @endforeach
              <div class="clear-both">
                <a href="{{ route('teacher.marks.edit', $mark->id) }}"
                  class="button is-primary is-small">Edit / Update marks</a>
              </div>
            </div>
        @endif
      @endforeach
      </table>
    @else
      <div><b>no marks uploaded yet !</b></div>
    @endif
  </div>
  <script>
    // show / hide marks
    function toggleMarks(markid) {

      document.getElementById('table_' + markid).classList.toggle('hidden');
      document.getElementById('claims_' + markid).classList.toggle('hidden');

      document.getElementById('icon_' + markid).classList.toggle('fa-plus');

      document.getElementById('icon_' + markid).classList.toggle('fa-minus');

      if (document.getElementById('link_' + markid).children[1].textContent == "View marks") {
        document.getElementById('link_' + markid).children[1].textContent = "Hide marks";
      } else {
        document.getElementById('link_' + markid).children[1].textContent = "View marks";
      }
    }
  </script>
@endsection
