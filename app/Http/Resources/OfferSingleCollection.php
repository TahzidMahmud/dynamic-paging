<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OfferSingleCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->resource['offer']->title,
            'slug' => $this->resource['offer']->slug,
            'banner' => api_asset($this->resource['offer']->banner),
            'start_date' =>date('M d, Y H:i:s', $this->resource['offer']->start_date),
            'end_date' => date('M d, Y H:i:s', $this->resource['offer']->end_date),
            'categories' => $this->resource['cats'],
            'brands' => $this->resource['brands'],

        ];
    }
    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
