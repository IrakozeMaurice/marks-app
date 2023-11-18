<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginToken;
use App\Models\Teacher;
use App\Models\TeacherUser;
use Illuminate\Http\Request;

class TeacherAuthController extends Controller
{
    /**
     * Display teacher login view
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (Auth::guard('is_teacher')->check()) {
            return redirect()->route('teacher.home');
        } else {
            return view('auth.teacherLogin');
        }
    }

    /**
     * Handle an incoming teacher authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request, AuthenticatesTeacher $auth)
    {

        // 1. validate input
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        // 2. check if teacher exists in school db
        $client = new \GuzzleHttp\Client();
        $req = $client->get('http://localhost:9000/api/v2/auca/teacher/' . request('email'));
        $response = json_decode($req->getBody());

        // 3. if teacher does not exist in school db
        if (!$response) {
            return back()->with('error', 'teacher email does not exist');
        } else {
            // create new teacher for first time login
            $teacher = Teacher::where('email', request('email'))->first();
            if (!$teacher) {
                $teacher = Teacher::create([
                    'names' => $response->names,
                    'email' => $response->email,
                    'phone' => $response->phone,
                ]);
                // create user also
                $user = TeacherUser::create([
                    'teacher_id' => $teacher->id,
                    'names' => $teacher->names,
                    'email' => $teacher->email,
                ]);
                // 4. else send email link with login token
                $auth->invite($user);
            } else {

                // 4. else send email link with login token
                $auth->invite($teacher->user);
            }
            return back()->with('success', 'Please check Login link sent to ' . request('email'));
        }

        if (auth()->guard('is_teacher')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $user = auth()->user();

            return redirect()->intended(url('/teacher/dashboard'));
        } else {
            return redirect()->back()->withError('Credentials doesn\'t match.');
        }

        //-------------------------------------------//
        // $this->validate($request, [
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        // if (auth()->guard('is_teacher')->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ])) {
        //     $user = auth()->user();

        //     return redirect()->intended(url('/teacher/dashboard'));
        // } else {
        //     return redirect()->back()->withError('Credentials doesn\'t match.');
        // }
        //----------------------------------------------------//
    }

    public function authenticate(LoginToken $token)
    {
        Auth::guard('is_teacher')->login($token->teacherUser);

        $token->delete();

        return redirect()->intended(url('/teacher/dashboard'));
    }
    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('is_teacher')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
