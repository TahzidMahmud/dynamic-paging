<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'title' => $data->title,
                    'slug' => $data->slug,
                    'short_description' => $data->short_description,
                    'banner' => api_asset($data->banner)??null,
                    'category' => $data->category->name??null,
                    'read_more' => route('api.blog.show', $data->slug),
                    'created_at' => $data->created_at->format('d M Y'),
                ];
            }),

        ];
    }
}
