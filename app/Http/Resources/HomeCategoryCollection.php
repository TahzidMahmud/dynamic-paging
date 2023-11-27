<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HomeCategoryCollection extends ResourceCollection
{
    private $top_3_products;

    public function __construct($resource, $top_3_products = false)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;

        $this->top_3_products = $top_3_products;
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'slug' => $data->slug,
                    'name' => $data->getTranslation('name'),
                    'banner' => api_asset($data->banner),
                    'big_banner' => api_asset($data->big_banner),
                    'featured_products' => $this->top_3_products ? new ProductCollection($data->featured_products(10)->get()) : [],
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
