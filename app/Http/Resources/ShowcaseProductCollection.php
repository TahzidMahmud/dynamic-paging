<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShowcaseProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'name' => $data->name,
                    'slug' => $data->slug,
                    'thumbnail_image' => api_asset($data->thumbnail_img),
                    'technical_sheet' => api_asset($data->technical_sheet),
                    'safty_sheet' => api_asset($data->safty_sheet),
                    'description' => $data->description,
                ];
            })
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
