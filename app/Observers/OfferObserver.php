<?php

namespace App\Observers;

use App\Models\Offer;
use App\Models\OfferActionLog;


class OfferObserver
{
    /**
     * Handle the flash deal "created" event.
     *
     * @param  \App\Models\Offer  $offer
     * @return void
     */
    public function created(Offer $offer)
    {
        OfferActionLog::create([
            "user_id"=>auth()->user()->id,
            "user_name"=>auth()->user()->name,
            "offer_id"=>$offer->id,
            "offer_name"=>$offer->title,
            "action"=>"create"
        ]);

        return 1;
    }

    /**
     * Handle the flash deal "updated" event.
     *
     * @param  \App\Models\Offer  $offer
     * @return void
     */
    public function updated(Offer $offer)
    {
        OfferActionLog::create([
            "user_id"=>auth()->user()->id,
            "user_name"=>auth()->user()->name,
            "offer_id"=>$offer->id,
            "offer_name"=>$offer->title,
            "action"=>"update"
        ]);

        return 1;
    }

    /**
     * Handle the flash deal "deleted" event.
     *
     * @param  \App\Models\Offer  $offer
     * @return void
     */
    public function deleted(Offer $offer)
    {
        OfferActionLog::create([
            "user_id"=>auth()->user()->id,
            "user_name"=>auth()->user()->name,
            "offer_id"=>$offer->id,
            "offer_name"=>$offer->title,
            "action"=>"delete"
        ]);

        return 1;
    }

    /**
     * Handle the flash deal "restored" event.
     *
     * @param  \App\Models\Offer  $offer
     * @return void
     */
    public function restored(Offer $offer)
    {
        //
    }

    /**
     * Handle the flash deal "force deleted" event.
     *
     * @param  \App\Models\Offer  $offer
     * @return void
     */
    public function forceDeleted(Offer $offer)
    {
        //
    }
}
