<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Buyer;
use App\Models\Seller;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function submitForgot(Request $request)
    {
        $request->validate([
            'identity' => 'required',
        ]);

        $identity = $request->identity;

        // Cek apakah user adalah buyer atau seller
        $user = Buyer::where('email', $identity)->orWhere('username', $identity)->first();
        $type = 'buyer';

        if (!$user) {
            $user = Seller::where('email', $identity)->orWhere('username', $identity)->first();
            $type = 'seller';
        }

        if (!$user) {
            return back()->withErrors(['identity' => 'Email atau username tidak ditemukan.']);
        }

        $otp = rand(100000, 999999); // Generate OTP 6 digit
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $otp, 'created_at' => now()]
        );

        // Kirim OTP via email
        Mail::send('emails.send-otp', ['otp' => $otp, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Kode OTP Reset Password');
        });

        // Redirect ke halaman verifikasi OTP
        return redirect()->route('verify.form', ['email' => $user->email]);

    }

   public function showVerifyForm(Request $request)
{
    $email = session('email') ?? $request->query('email');

    if (!$email) {
        return redirect()->route('forgot.form')->withErrors(['email' => 'Email tidak ditemukan, silakan ulangi proses.']);
    }

    return view('pages.general.verify-otp', [
        'email' => $email
    ]);
}

    public function submitVerify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $data = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$data || $data->token != $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        return redirect()->route('reset.form', ['email' => $request->email, 'otp' => $request->otp]);
    }

    public function showResetForm(Request $request)
    {
        return view('pages.general.reset-password', [
            'email' => $request->email,
            'otp' => $request->otp
        ]);
    }

    public function submitReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $data = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$data || $data->token != $request->otp) {
            return back()->withErrors(['otp' => 'Token tidak valid.']);
        }

        $hashedPassword = bcrypt($request->password);

        // Update password user
        if (Buyer::where('email', $request->email)->exists()) {
            Buyer::where('email', $request->email)->update(['password' => $hashedPassword]);
        } elseif (Seller::where('email', $request->email)->exists()) {
            Seller::where('email', $request->email)->update(['password' => $hashedPassword]);
        }

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password berhasil direset!');
    }
}
