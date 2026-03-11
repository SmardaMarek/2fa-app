<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;

class MfaController extends Controller
{
    /**
     * Show the MFA setup view for users who don't have it enabled.
     */
    public function setup(Request $request)
    {
        $user = $request->user();

        if ($user->hasMfaEnabled()) {
            return redirect()->route('dashboard');
        }

        $google2fa = new Google2FA();

        $secret = session('google2fa_secret');
        if (!$secret) {
            $secret = $google2fa->generateSecretKey();
            session(['google2fa_secret' => $secret]);
        }

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        $bacon = new \BaconQrCode\Writer(new \BaconQrCode\Renderer\ImageRenderer(
            new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200),
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        ));
        $qrCodeSvg = $bacon->writeString($qrCodeUrl);

        return view('auth.mfa-setup', [
            'qrCodeSvg' => $qrCodeSvg,
            'secret' => $secret
        ]);
    }

    /**
     * Verify the initial MFA setup code.
     */
    public function verifySetup(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6']
        ]);

        $user = $request->user();
        $secret = session('google2fa_secret');

        if (!$secret) {
            return redirect()->route('mfa.setup')->withErrors(['error' => 'Secret not found in session']);
        }

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secret, $request->code);

        if ($valid) {
            $user->forceFill([
                'google2fa_secret' => $secret,
                'google2fa_confirmed_at' => now(),
            ])->save();

            session()->forget('google2fa_secret');
            session(['mfa_verified' => true]);

            return redirect()->intended(route('dashboard', absolute: false));
        }

        return back()->withErrors(['code' => 'Invalid authentication code. Please try again.']);
    }

    /**
     * Show the MFA challenge view for users who have it enabled.
     */
    public function challenge(Request $request)
    {
        if (session('mfa_verified')) {
            return redirect()->route('dashboard');
        }

        return view('auth.mfa-challenge');
    }

    /**
     * Verify the MFA code during login.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6']
        ]);

        $user = $request->user();
        $google2fa = new Google2FA();

        try {
            if ($google2fa->verifyKey($user->google2fa_secret, $request->code)) {
                session(['mfa_verified' => true]);
                $request->session()->regenerate();

                return redirect()->intended(route('dashboard', absolute: false));
            }
        } catch (IncompatibleWithGoogleAuthenticatorException|InvalidCharactersException|SecretKeyTooShortException $e) {

        }

        return back()->withErrors(['code' => 'Invalid authentication code. Please try again.']);
    }
}
