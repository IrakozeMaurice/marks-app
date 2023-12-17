<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Course;
use App\Models\Mark;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function index()
    {
        // when user logs in

        $student = auth()->user()->student;

        $client = new \GuzzleHttp\Client();

        // 1. retrieve student's current registration

        try {
            $req = $client->get('http://localhost:9000/api/v2/auca/registration/' . $student->rollno);
        } catch (\Throwable $th) {

            return back()->with('error', 'Failed to connect to remote server. check back later');
        }
        $response = json_decode($req->getBody());

        if ($response) {

            // 2. save registration associated with the student if not exists

            $registration = Registration::where('student_id', $student->id)
                ->where('semester_end_date', $response->semester_end_date)->first();

            if (!$registration) {

                $registration = Registration::create([
                    'student_id' => $student->id,
                    'semester_name' => $response->semester_name,
                    'semester_start_date' => $response->semester_start_date,
                    'semester_end_date' => $response->semester_end_date,
                ]);

                // 3. save or update courses and attach them to current registration

                foreach ($response->courses as $course) {
                    Course::updateOrCreate([
                        'code' => $course->code,
                        'name' => $course->name,
                        'credits' => $course->credits,
                    ]);
                }

                foreach ($response->courses as $course) {
                    $c = Course::where('code', $course->code)->first();
                    $registration->courses()->attach($c->id, ['group' => $course->pivot->group]);
                }
            }
        } else {
            $registration = null;
        }

        return view('student.dashboard', compact('registration'));
    }

    public function indexenrolled()
    {

        $student = auth()->user()->student;

        // get current registration

        $registration = Registration::where('student_id', $student->id)
            ->where('semester_end_date', '>=', now()->format('Y-m-d'))->first();

        return view('student.enrolled', compact('registration'));
    }

    public function indexarchived()
    {
        $student = auth()->user()->student;
        $registrations = Registration::where('student_id', $student->id)
            ->where('semester_end_date', '<', now()->format('Y-m-d'))->get();

        return view('student.archived', compact('registrations'));
    }

    public function showmarks(Registration $registration, $course_code)
    {
        $course = Course::where('code', $course_code)->first();

        $marks = Mark::where('semester_end_date', $registration->semester_end_date)
            ->where('course_id', $course->id)
            ->where('group', $registration->courses->find($course)->pivot->group)
            ->get();

        return view('student.showmarks', compact('marks', 'registration', 'course'));
    }

    public function showmarksarchived(Registration $registration, $course_code)
    {
        $course = Course::where('code', $course_code)->first();

        $marks = Mark::where('semester_end_date', $registration->semester_end_date)
            ->where('course_id', $course->id)
            ->where('group', $registration->courses->find($course)->pivot->group)
            ->get();

        return view('student.showmarksarchived', compact('marks', 'registration', 'course'));
    }

    public function storeclaim(Mark $mark)
    {
        if ($mark->claimDeadlineExpired()) {
            return [
                'error' => 'claim deadline expired'
            ];
        }

        request()->validate([
            'description' => 'required'
        ]);

        Claim::create([
            'student_id' => auth()->user()->student->id,
            'mark_id' => $mark->id,
            'description' => request('description'),
        ]);
    }
}
