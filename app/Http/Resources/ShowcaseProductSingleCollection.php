<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowcaseProductSingleCollection extends JsonResource
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
            'id' => (integer) $this->id,
            'name' => $this->name,
            'meta' => [
                'title' => $this->meta_title,
                'image' => api_asset($this->meta_image),
                'description' => $this->meta_description,
            ],
            'brand' => [
                'id' => optional($this->brand)->id,
                'name' => optional($this->brand)->getTranslation('name'),
                'slug' => optional($this->brand)->slug,
                'logo' => api_asset(optional($this->brand)->logo),
            ],
            'photos' => $this->convertPhotos($this),
            'thumbnail_image' => api_asset($this->thumbnail_img),
            'technical_sheet' => api_asset($this->technical_sheet),
            'safty_sheet' => api_asset($this->safty_sheet),
            'tags' => explode(',', $this->tags),
            'description' => $this->description,
            'shop' => [
                'name' => $this->shop->name,
                'logo' => api_asset($this->shop->logo),
                'rating' => (double) $this->shop->rating,
                'review_count' => $this->shop->reviews_count,
                'slug' => $this->shop->slug,
            ]
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }

    protected function convertPhotos(){
        $product_img = explode(',', $this->photos);
        $images = array_unique(array_filter(array_merge($product_img)));
        $result = array();
        foreach ($images as $item) {
            $a['img'] = (int) $item;
            $a['url'] = api_asset($item);
            array_push($result, $a);
        }
        return $result;
    }
}
