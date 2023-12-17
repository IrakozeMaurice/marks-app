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
          <span><b>Uploaded marks for: </b><b class="text-blue-500">{{ $course->name }} Group:
              {{ $registration->courses->find($course->id)->pivot->group }}</b></span>
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
                <th>Actions</th>
                <th>Claim deadline</th>
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
                  @if ($mark->claimDeadlineExpired())
                    <button class="button is-disabled is-small is-danger" disabled><i
                        class="fas fa-hand-paper mr-2"></i>Claim is disabled</button>
                  @else
                    <button class="button is-disabled is-small is-primary"
                      onclick="document.getElementById('modal_{{ $mark->id }}').classList.add('is-active')"><i
                        class="fas fa-hand-paper mr-2"></i>Claim</button>
                  @endif
                </td>

                {{-- modal --}}
                <div id="modal_{{ $mark->id }}" class="modal">
                  <div class="modal-background"></div>
                  <div class="modal-card">
                    @if ($mark->claimDeadlineExpired())
                      <header class="modal-card-head">
                        <p class="modal-card-title has-text-danger text-center">claim deadline expired</p>
                        <button class="delete" aria-label="close"
                          onclick="document.getElementById('modal_{{ $mark->id }}').classList.remove('is-active')"></button>
                      </header>
                    @else
                      <header class="flex justify-between bg-gray-100 p-4">
                        <div>
                          <p class=""><span class="has-text-info">Course:
                            </span>
                            <span class="text-sm font-semibold">{{ $mark->course->name }}</span>
                          </p>
                          <p class=""><span class="has-text-info">Marks:
                            </span>
                            <span class="text-sm font-semibold">{{ $mark->title }}</span>
                          </p>
                          <p class="mb-0"><span class="has-text-info">Student Id:
                            </span>
                            <span class="text-sm font-semibold">{{ auth()->user()->student->rollno }}</span>
                          </p>
                        </div>
                        <div>
                          <button class="delete" aria-label="close"
                            onclick="document.getElementById('modal_{{ $mark->id }}').classList.remove('is-active')"></button>
                        </div>
                      </header>
                      <section class="modal-card-body">
                        <form id="claim_form_{{ $mark->id }}" method="POST"
                          action="{{ route('student.claims.store', $mark->id) }}">
                          @csrf


                          <div id="success_message_{{ $mark->id }}"
                            class="text-lg has-text-primary text-center font-bold bg-gray-200 rounded-lg mb-4 py-2 hidden">
                            Claim submitted successfully
                          </div>

                          <div class="field" style="width: 70%;">
                            <label class="label">Description</label>
                            <div class="control">
                              <textarea name="description" id="description_{{ $mark->id }}"
                                onkeyup="toggleDescriptionError({{ $mark->id }})"
                                class="textarea placeholder:text-gray-400"
                                placeholder="add description here..."></textarea>
                              <span id="description_error_{{ $mark->id }}" class="help is-danger hidden"></span>
                            </div>
                          </div>

                      </section>
                      <footer class="modal-card-foot">
                        <a onclick="handleClaimSubmission({{ $mark->id }})"
                          id="btn_submit_claim_{{ $mark->id }}"
                          class="button is-success">Submit
                          claim</a>
                        <button class="button"
                          onclick="document.getElementById('modal_{{ $mark->id }}').classList.remove('is-active')">Cancel</button>
                      </footer>
                      </form>
                    @endif
                  </div>
                </div>
                {{-- modal --}}

                <td class="text-lg">
                  @if ($mark->claimDeadlineExpired())
                    <small class="has-text-danger">Claim deadline expired</small>
                  @else
                    <small
                      class="ml-2 font-bold">({{ $mark->claim_deadline->diff(\Carbon\Carbon::now())->format('%d days, %h h %i min %s sec') }})</small>
                  @endif
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
          <div><b>no marks uploaded yet for this course !</b></div>
        @endif
      </div>
    </div>
    <script src="{{ asset('js/axios.min.js') }}"></script>
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

      function toggleDescriptionError(markid) {
        if (!document.getElementById('description_error_' + markid).classList.contains('hidden')) {
          document.getElementById('description_error_' + markid).classList.add('hidden');
        }
      }

      function handleClaimSubmission(markid) {
        document.getElementById('btn_submit_claim_' + markid).classList.add('is-loading');
        var formData = new FormData(document.getElementById('claim_form_' + markid));
        axios.post('/dashboard/claims/' + markid, {
            description: formData.get('description'),
            _token: '{{ csrf_token() }}'
          })
          .then(function(response) {
            console.log('here');
            document.getElementById('btn_submit_claim_' + markid).classList.remove('is-loading');

            document.getElementById('description_' + markid).value = '';
            document.getElementById('success_message_' + markid).classList.remove('hidden');
            console.log(response);
          })
          .catch(function(error) {
            if (error.response.data.errors.description) {
              if (document.getElementById('description_error_' + markid).classList.contains('hidden')) {
                document.getElementById('description_error_' + markid).classList.remove('hidden');
                document.getElementById('description_error_' + markid).textContent = error.response.data.errors
                  .description;
              }
            }
            document.getElementById('btn_submit_claim_' + markid).classList.remove('is-loading');
            console.log(error.response.data.errors.description);
          });
      }
    </script>
</x-app-layout>
