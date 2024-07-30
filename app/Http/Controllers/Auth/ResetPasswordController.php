<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\resetPasswordJob;
use App\Models\Keranjang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $dataKeranjang = collect();
        
        if (Auth::check()) {
            $dataKeranjang = Keranjang::orderBy('updated_at', 'desc')
                ->where('user_id', auth()->user()->id)
                ->get();
        }

        if ($request->has('token') && $request->has('email')) {
            $user = User::where('email', $request->email)->first();
            if ($user && $request->token === $user->reset_token) {
                $updatedAt = Carbon::parse($user->updated_at);
                if ($updatedAt->diffInMinutes(now()) <= 60) {
                    return view('otentikasi.resetPassword', [
                        'judul' => 'Reset Password',
                        'token' => $request->token,
                        'email' => $request->email,
                        'dataKeranjang' => $dataKeranjang,
                    ]);
                } else {
                    return redirect('/lupa-password')->with('error', 'Sesi kamu sudah habis');
                }
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
    }

    public function sendResetToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found']);
        }

        $token = Password::createToken($user);
        $user->update(['reset_token' => $token]);
        dispatch(new resetPasswordJob($token, $user->nama, $user->email));

        return redirect()->back()->with('success', 'Email berhasil dikirim, silahkan buka email');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|max:20|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || $request->token !== $user->reset_token) {
            return redirect('/')->withErrors(['token' => 'Invalid token or email']);
        }

        $user->update([
            'reset_token' => null,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Password berhasil diupdate, silahkan login!');
    }
}
