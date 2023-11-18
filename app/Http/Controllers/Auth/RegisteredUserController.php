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
        $req = $client->get('http://localhost:9000/api/v2/auca/student/' . request('rollno'));
        $response = json_decode($req->getBody());

        if (!$response) {

            return back()->withErrors(["unregisteredStudent" => "Student ID not registered in the school system"]);
        } else {

            // STUDENT EXISTS IN SCHOOL SYSTEM
            // Returned data
            // {
            //     "rollno": 24111,
            //     "names": "Miss Nya Zboncak DDS",
            //     "email": "kristian.wolff@example.com",
            //     "phone": "1-985-531-1621"
            // }
            // CREATE STUDENT
            // CREATE USER
            // LOG IN THE USER

            $student = Student::create([
                'rollno' => $response->rollno,
                'names' => $response->names,
                'email' => request('email'),
                'phone' => $response->phone,
            ]);

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
