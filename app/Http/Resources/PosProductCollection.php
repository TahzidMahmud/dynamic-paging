<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PosProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                // dd($data);
                $name = '';
                if($data->code){

                    $code_array = array_filter(explode('/', $data->code));
                    $lstKey = array_key_last($code_array);

                    foreach ($code_array as $j => $comb) {
                        $comb = explode(':', $comb);

                        $option_name = \App\Models\Attribute::find($comb[0])->getTranslation('name');
                        $choice_name = \App\Models\AttributeValue::find($comb[1])->getTranslation('name');

                        $name .= $option_name . ': ' . $choice_name;

                        if ($lstKey != $j) {
                            $name .= ' / ';
                        }
                    }
                }
                return [
                    'id' => $data->id,
                    'name' => $data->name,
                    'variant_name' => $name,
                    'stock_qty'=>$data->stock_qty,
                    'stock_id'=>$data->stock_id,
                    'thumbnail_image' => uploaded_asset($data->thumbnail_img),
                    'price' => $data->stock_price,
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
