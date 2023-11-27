<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    private $withChildren;

    public function __construct($resource, $withChildren = false)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;

        $this->withChildren = $withChildren;
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->getTranslation('name'),
                    'banner' => api_asset($data->banner),
                    'big_banner' => api_asset($data->big_banner),
                    'image' => api_asset($data->image),
                    'icon' => api_asset($data->icon),
                    'slug' => $data->slug,
                    'children' => $this->withChildren ? new CategoryCollection($data->categories, true) : [],
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
