<?php

namespace App\Http\Controllers\User;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function index(){
        return view("user.auth.login");
    }
    public function remember(){
        return view("user.auth.remember");
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name"              => 'required|string',
            "email"             => 'required|string',
            "cpf"               => 'required|string|max:11',
            "phone"             => 'required|string',
            "password"          => 'required|string',
        ], [
            'name' => "nome",
            'phone' => "celular",
            'password' => "senha",
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->getMessageBag()->first(), 500);
        } else {

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'cpf' => $request->input('cpf'),
                'phone' => substr($request->input('phone'), 0, 11),
                'password' => Hash::make($request->input('password')),
                'status' => 1,

            ]);

            $user->save();


            return ResponseHelper::success($user, __("Retornando usuário"));
        }
    }


    public function login(Request $request)
    {
        
        if (!Auth::guard("web")->attempt($request->only(['email', 'password']))) {
            // return ResponseHelper::error(__("Credenciais inválidas"), Response::HTTP_UNAUTHORIZED);
            return redirect()->route("user.auth")->with('error', __("Credenciais inválidas"));
        }

        $user = Auth::user();

        // $token = $user->createToken('token')->plainTextToken;
        // $cookie = cookie("jwt", $token, 60 * 24); //1 dia

        // return ResponseHelper::success($user, __('Sucesso'));//->withCookie($cookie);

        return redirect()->route("user.home");
        
        // if (!Auth::attempt($request->only(['email', 'password']))) {
        //     return ResponseHelper::error(__("Credenciais inválidas"), Response::HTTP_UNAUTHORIZED);
        // }

        // $user = Auth::user();

        // $token = $user->createToken('token')->plainTextToken;
        // $cookie = cookie("jwt", $token, 60 * 24); //1 dia

        // return ResponseHelper::success($user, __('Sucesso'))->withCookie($cookie);
    }

    public function user()
    {
        return ResponseHelper::success(Auth::user(), __("Retornando usuário"));
    }

    public function forgot(Request $request)
    {
        if(Auth::user()) {
            return ResponseHelper::error(__("Faça logout antes de realizar essa operação"), 403);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error(__("Campos inválidos"), 500);
        }

        $email = $request->input("email");

        $user = User::where("email", $email)->first();
        if (!$user) {
            return ResponseHelper::error(__("Usuário não encontrado"), 404);
        }

        Password::sendResetLink($request->all());

        return ResponseHelper::success(null, __("Email de recuperação enviado"));
    }

    public function reset(Request $request)
    {

        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return ResponseHelper::error(__("Token inválido"), 400);
        }

        return ResponseHelper::success(null, __("Senha alterada com sucesso"));
    }

    public function logout(Request $request)
    {
        if(!Auth::check()) {
            return ResponseHelper::error(__("Faça logout antes de realizar essa operação"), 403);
        }

        // $cookie = Cookie::forget("jwt");
        // return ResponseHelper::success([], __("Logout feito com sucesso")); //->withCookie($cookie);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route("user.auth");
    }
}
