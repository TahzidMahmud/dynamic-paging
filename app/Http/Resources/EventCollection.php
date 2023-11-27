<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventCollection extends ResourceCollection
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
                    'name' => $data->name,
                    'description' => $data->description,
                    'banner' => api_asset($data->banner)??null,
                    'images' => $this->prepareImages($data->images)
                ];
            }),

        ];
    }

    protected function prepareImages($images){
        $result = array();
        $images = json_decode($images);
        foreach ($images as $item) {
            $a['img'] = api_asset($item);
            array_push($result, $a);
        }
        return $result;
    }
}
