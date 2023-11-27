<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Utility\CategoryUtility;

class AllCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'name' => $data->getTranslation('name'),
                    'banner' => api_asset($data->banner),
                    'icon' => api_asset($data->icon),
                    'slug' => $data->slug,
                    'children' => new CategoryCollection($data->categories),
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
