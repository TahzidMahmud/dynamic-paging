<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferActionLog extends Model
{
    protected $guarded=[];

    /**
     * Get the user that owns the OfferActionLog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
