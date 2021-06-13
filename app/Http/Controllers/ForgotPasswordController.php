<?php

namespace App\Http\Controllers;

use App\Events\ForgotPasswordEvent;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    public function forgotPassword()
    {
        return Inertia::render('auth/forgot-password');
    }

    public function recoverPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $email = $request->email;

        $user = User::where('email', $email)->first();

        if(!$user) {
            return redirect()->route('forgot-password')->with(['type' => 'error', 'message' => 'E-mail nao encontrado!']);
        }

        $passwordExists = PasswordReset::where('email', $email)->where('expires_in', '>=', Carbon::now()->toDateTimeLocalString())->first();

        if ($passwordExists) {
            return redirect()->route('forgot-password')->with(['type' => 'error', 'message' => 'Recuperação de senha já solicitada!']);
        }

        $token = Str::random(60);

        PasswordReset::create([
            'email' => $user->email,
            'token' => $token,
            'expires_in' => Carbon::now()->addHour(1)
        ]);

        event(new ForgotPasswordEvent($user, $token));

        return redirect()->route('login')->with(['type' => 'success', 'message' => 'Recuperação de senha enviada com sucesso!']);
    }

    public function resetPasswordView(Request $request)
    {
        if(!$request->has('token')) {
            return redirect()->route('login')->with(['type' => 'error', 'message' => 'Necessario informar o token!']);
        }

        $token = $request->token;

        $tokenIsExists = PasswordReset::where('token', $token)->first();

        if(!$tokenIsExists) {
            return redirect()->route('login')->with(['type' => 'error', 'message' => 'Token invalido!']);
        }

        return Inertia::render('auth/reset-password', [
            'token' => $token
        ]);
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);

        $token = $request->token;

        $passwordNotExpired = PasswordReset::where('token', $token)->where('expires_in', '>', Carbon::now()->toDateTimeLocalString())->first();

        if(!$passwordNotExpired) {
            PasswordReset::where('token', $token)->delete();
            return redirect()->route('login')->with(['type' => 'error', 'message' => 'Token esta expirado!']);
        }

        User::where('email', $passwordNotExpired->email)->update([
            'password' => bcrypt($request->password)
        ]);

        PasswordReset::where('token', $token)->delete();
        return redirect()->route('login')->with(['type' => 'success', 'message' => 'Senha resetada com sucesso!']);
    }
}
