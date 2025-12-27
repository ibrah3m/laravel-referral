<?php

namespace Jijunair\LaravelReferral\Traits;

use Illuminate\Support\Str;
use Jijunair\LaravelReferral\Models\Referral;

trait Referrable
{
    /**
     * Get the referrals associated with the user.
     */
    public function referrals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    /**
     * Get the referral account of the user.
     */
    public function referralAccount(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Referral::class, 'id', 'user_id');
    }

    /**
     * Check if the user has a referral account.
     */
    public function hasReferralAccount(): bool
    {
        return !is_null($this->referralAccount);
    }

    /**
     * Get the referral link for the user.
     */
    public function getReferralLink(): string
    {
        if ($this->hasReferralAccount()) {
            return url('/') . "/" . config('referral.route_prefix') . "/" . $this->getReferralCode();
        }
        return "";
    }

    /**
     * Get the referral code of the user's referral account.
     */
    public function getReferralCode(): ?string
    {
        if ($this->hasReferralAccount()) {
            return $this->referralAccount->referral_code;
        }
        
        return null;
    }

    /**
     * Create a referral account for the user.
     */
    public function createReferralAccount(?int $referrerID = null): void
    {

        $prefix = config('referral.ref_code_prefix');
        $length = config('referral.referral_length');
        $referralCode = $this->generateUniqueReferralCode($prefix, $length);

        $ref = new Referral;
        $ref->user_id = $this->getKey();
        $ref->referrer_id = $referrerID;
        $ref->referral_code = $referralCode;
        $ref->save();
    }

    /**
     * Generate a unique referral code.
     */
    private function generateUniqueReferralCode(string $prefix, int $length): string
    {
        $prefix = strtolower($prefix);
        // Generate an initial referral code
        $code = $prefix . strtolower(Str::random($length));

        // Check if the generated code already exists in the database
        while (Referral::where('referral_code', $code)->exists()) {
            // If code already exists, generate a new one until a unique code is found
            $code = $prefix . strtolower(Str::random($length));
        }
        
        return $code;
    }
}
