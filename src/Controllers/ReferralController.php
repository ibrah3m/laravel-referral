<?php

namespace Ibrah3m\LaravelReferral\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;

class ReferralController extends Controller
{
    /**
     * Assign a referral code to the user.
     */
    public function assignReferrer(string $referralCode): RedirectResponse
    {
        $refCookieName = config('referral.cookie_name');
        $refCookieExpiry = config('referral.cookie_expiry');
        if (Cookie::has($refCookieName)) {
            // Referral code cookie already exists, redirect to configured route
            return redirect()->route(config('referral.redirect_route'));
        } else {
            // Create a referral code cookie and redirect to configured route
            $ck = Cookie::make($refCookieName, $referralCode, $refCookieExpiry);
            return redirect()->route(config('referral.redirect_route'))->withCookie($ck);
        }
    }

    /**
     * Generate referral codes for existing users.
     */
    public function createReferralCodeForExistingUsers(): JsonResponse
    {
        $userModel = resolve(config('referral.user_model'));
        $users = $userModel::cursor();

        foreach ($users as $user) {
            if (!$user->hasReferralAccount()) {
                $user->createReferralAccount();
            }
        }

        return response()->json(['message' => 'Referral codes generated for existing users.']);
    }
}
