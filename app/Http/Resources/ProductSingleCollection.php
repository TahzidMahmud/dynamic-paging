<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSingleCollection extends JsonResource
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
            'name' => $this->getTranslation('name'),
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
            'slug' => $this->slug,
            'technical_sheet' => api_asset($this->technical_sheet),
            'safety_sheet' => api_asset($this->safety_sheet),
            'tags' => explode(',', $this->tags),
            'featured' => (integer) $this->featured,
            'stock' => (integer) $this->stock,
            'min_qty' => (integer) $this->min_qty,
            'max_qty' => (integer) $this->max_qty,
            'unit' => $this->getTranslation('unit'),
            'contact_to_buy' => $this->contact_to_buy,
            'discount' => $this->discount,
            'discount_type' => $this->discount_type,
            'base_price' => (double) product_base_price($this),
            'highest_price' => (double) product_highest_price($this),
            'base_discounted_price' => (double) product_discounted_base_price($this),
            'highest_discounted_price' => (double) product_discounted_highest_price($this),
            'standard_delivery_time' => (integer) $this->standard_delivery_time,
            'express_delivery_time' => (integer) $this->express_delivery_time,
            'is_variant' => $this->is_variant,
            'has_warranty' => $this->has_warranty,
            'review_summary' => [
                'average' => (double) $this->rating,
                'total_count' => (integer) $this->reviews_count,
                'count_5' => (integer) $this->reviews_5_count,
                'count_4' => (integer) $this->reviews_4_count,
                'count_3' => (integer) $this->reviews_3_count,
                'count_2' => (integer) $this->reviews_2_count,
                'count_1' => (integer) $this->reviews_1_count,
            ],
            'description' => $this->getTranslation('description'),
            'short_description' => $this->short_description,
            'performance' => $this->performance,
            'application' => $this->application,
            'specification_n_approval' => $this->specification_n_approval,
            'variations' => filter_product_variations($this->variations,$this),
            'variation_options' => generate_variation_options($this->variation_combinations),
            'informations' => json_decode($this->informations ?? '[]'),
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
        $variations_img = $this->variations->pluck('img')->toArray();
        $product_img = explode(',', $this->photos);
        $images = array_unique(array_filter(array_merge($variations_img,$product_img)));
        $result = array();
        foreach ($images as $item) {
            $a['img'] = (int) $item;
            $a['url'] = api_asset($item);
            array_push($result, $a);
        }
        return $result;
    }
}
