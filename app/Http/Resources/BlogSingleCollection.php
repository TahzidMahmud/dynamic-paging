<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductCollection;
use App\models\Product;

class BlogSingleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($reques)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'title' => $data->title,
                    'slug' => $data->slug,
                    'short_description' => $data->short_description,
                    'banner' => api_asset($data->banner)??null,
                    'category' => $data->category->name??null,
                    'description'=>$data->description,
                    'related_products'=>new ProductCollection(Product::whereIn('id',json_decode($data->products??'[]'))->get()),
                    'created_at' => $data->created_at->format('d M Y'),
                ];
            }),

        ];



    }
}
