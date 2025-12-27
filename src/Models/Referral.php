<?php

namespace Ibrah3m\LaravelReferral\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'referral_code', 'referrer_id'
    ];

    /**
     * Get the user associated with the referral.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(config('referral.user_model'), 'user_id');
    }

    /**
     * Get the referrer associated with the referral.
     */
    public function referrer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(config('referral.user_model'), 'referrer_id');
    }

    /**
     * Retrieve the user by referral code.
     */
    public static function userByReferralCode(string $code): mixed
    {
        $referrer = self::where('referral_code', $code)->first();
        if ($referrer) {
            return App::make(config('referral.user_model'))->find($referrer->user_id);
        }
        return null;
        
    }
}
