<?php

namespace App\Http\Controllers\Auth;

   use App\Http\Controllers\Controller;
   use App\Models\User;
   use Illuminate\Foundation\Auth\RegistersUsers;
   use Illuminate\Support\Facades\Hash;
   use Illuminate\Support\Facades\Validator;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;

   class RegisterController extends Controller
   {
       use RegistersUsers;

       protected $redirectTo = '/login';

       public function __construct()
       {
           $this->middleware('guest');
       }

       protected function validator(array $data)
       {
           return Validator::make($data, [
               'name' => ['required', 'string', 'max:255', 'not_regex:/^\s*$/u', 'not_regex:/^[　]+$/u'],
               'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
               'password' => ['required', 'string', 'min:8', 'confirmed'],
           ], [
               'name.not_regex' => '文字を入力してください。',
           ]);
       }

       protected function create(array $data)
       {
           return User::create([
               'name' => $data['name'],
               'email' => $data['email'],
               'password' => Hash::make($data['password']),
           ]);
       }

       public function register(Request $request)
       {
           $this->validator($request->all())->validate();

           // ユーザーを作成
           $user = $this->create($request->all());

           // ユーザーを認証
           Auth::login($user); // ここを追加

           return redirect($this->redirectTo);
       }
   }
