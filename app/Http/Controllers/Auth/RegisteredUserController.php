<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'rollno' => ['required', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $client = new \GuzzleHttp\Client();
        // GET STUDENT
        try {
            $req = $client->get('http://localhost:9000/api/v2/auca/student/' . request('rollno'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to connect to remote server. check back later');
        }
        $response = json_decode($req->getBody());

        if (!$response) {
            return back()->withErrors(["unregisteredStudent" => "Student ID not registered in the school system"]);
        } else {

            // create student
            $student = Student::create([
                'rollno' => $response->rollno,
                'names' => $response->names,
                'email' => request('email'),
                'phone' => $response->phone,
                'faculty' => $response->faculty,
                'department' => $response->department,
                'program' => $response->program,
            ]);

            // create user account and associate it with the student
            $user = User::create([
                'student_id' => $student->id,
                'rollno' => $student->rollno,
                'names' => $student->names,
                'email' => $student->email,
                'password' => Hash::make($request->password),
            ]);


            event(new Registered($user));

            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        }
    }
}
