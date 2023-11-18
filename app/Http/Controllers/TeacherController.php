<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Mark;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    //
    /**
     * redirect teacher after login
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('teacher.home');
    }


    public function indexmarks()
    {
        $client = new \GuzzleHttp\Client();
        // GET STUDENT
        $req = $client->get('http://localhost:9000/api/v2/auca/teacher/' . auth()->user()->email . '/courses');

        $response = json_decode($req->getBody());
        $courses = $response->courses;

        foreach ($courses as $course) {
            Course::updateOrCreate([
                'code' => $course->code,
                'name' => $course->name,
                'credits' => $course->credits,
            ])->teachers()->sync(auth()->user()->teacher_id);
        }
        // dd($response->courses);

        return view('teacher.marks.index', compact('courses'));
    }

    public function createmarks($code)
    {
        $course = Course::where('code', $code)->first();

        return view('teacher.marks.create', compact('course'));
    }

    public function storemarks()
    {
        request()->validate([
            'title' => 'required',
            'url' => 'required'
        ]);

        dd(request()->all());

        return back()->with('succes', 'marks uploaded successully.');
    }
}
