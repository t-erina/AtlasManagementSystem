<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

use App\Models\Users\Subjects;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    /**
     * フォームリクエストのバリデーション設定
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return Illuminate\Http\Response
     */

    public function registerPost(RegisterRequest $request)
    {
        if ($request->isMethod('post')) {
            return back();
        };

        $validated = $request->validated();
        $message = $request->messages();

        DB::beginTransaction();
        try {
            $old_year = $validated['old_year'];
            $old_month = $validated['old_month'];
            $old_day = $validated['old_day'];
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $validated['subject'];

            $user_get = User::create([
                'over_name' => $validated['over_name'],
                'under_name' => $validated['under_name'],
                'over_name_kana' => $validated['over_name_kana'],
                'under_name_kana' => $validated['under_name_kana'],
                'mail_address' => $validated['mail_address'],
                'sex' => $validated['sex'],
                'birth_day' => $birth_day,
                'role' => $validated['role'],
                'password' => bcrypt($validated['password'])
            ]);
            $user = User::findOrFail($user_get->id);
            $user->subjects()->attach($subjects);
            DB::commit();
            return view('auth.login.login');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('loginView', compact('message'));
        }
    }
}
