<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponActionLog extends Model
{
    protected $guarded=[];
    /**
     * Get the user that owns the CouponActionLog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
