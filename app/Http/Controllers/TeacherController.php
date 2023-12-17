<?php

namespace App\Http\Controllers;

use App\Imports\MarksExcelImport;
use App\Models\Claim;
use App\Models\Course;
use App\Models\Mark;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher.home');
    }


    public function indexmarks()
    {
        $client = new \GuzzleHttp\Client();

        try {
            $req = $client->get('http://localhost:9000/api/v2/auca/teacher/' . auth()->user()->email . '/courses');
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to connect to remote server. check back later');
        }

        $response = json_decode($req->getBody());
        $courses = $response->courses;

        $courseIds = [];
        foreach ($courses as $course) {
            $c = Course::updateOrCreate([
                'code' => $course->code,
                'name' => $course->name,
                'credits' => $course->credits,
            ]);
            $courseIds[] = $c->id;
        }
        auth()->user()->teacher->courses()->sync($courseIds);

        $marks = auth()->user()->teacher->marks->reverse();

        return view('teacher.marks.index', compact('courses', 'marks'));
    }

    function indexclaims()
    {
        $teacher = auth()->user()->teacher;

        $marks = Mark::where('teacher_id', $teacher->id)->get();

        return view('teacher.claims.index', compact('marks'));
    }

    public function createmarks($code)
    {
        $course = Course::where('code', $code)->first();

        return view('teacher.marks.create', compact('course'));
    }

    public function storemarks(Course $course)
    {
        request()->validate([
            'title' => 'required',
            'group' => 'required',
            'url' => 'required|mimes:xlsx'
        ]);

        // get current semester
        $client = new \GuzzleHttp\Client();
        try {
            $req = $client->get('http://localhost:9000/api/v2/auca/semester/current');
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to connect to remote server. check back later');
        }
        $response = json_decode($req->getBody());

        if (!$response) {
            return back()->with('error', 'No current semester available.');
        }
        $semester = $response;

        // create marks
        $mark = Mark::create([
            'teacher_id' => auth()->user()->teacher->id,
            'course_id' => $course->id,
            'title' => request('title'),
            'group' => request('group'),
            'semester_name' => $semester->name,
            'semester_start_date' => $semester->start_date,
            'semester_end_date' => $semester->end_date,
            'claim_deadline' => Carbon::now()->addDays(5),
        ]);

        // Process the Excel file
        Excel::import(new MarksExcelImport($mark->id), request()->file('url'));

        return redirect()->route('teacher.marks.index')->with('success', 'marks uploaded successully.');
    }

    public function editmarks(Mark $mark)
    {
        return view('teacher.marks.edit', compact('mark'));
    }


    public function updatemarks(Mark $mark)
    {
        request()->validate([
            'group' => 'required',
            'title' => 'required',
            'url' => 'required|mimes:xlsx'
        ]);

        $mark->group = request('group');
        $mark->title = request('title');
        $mark->update();

        // delete old mark excels
        $mark->markExcels()->delete();
        // Process the Excel file
        Excel::import(new MarksExcelImport($mark->id), request()->file('url'));

        return redirect()->route('teacher.claims.index')->with('success', 'marks updated successully.');
    }

    function deleteclaim(Claim $claim)
    {
        $claim->delete();

        return back()->with('success', 'claim deleted successfully');
    }
}
