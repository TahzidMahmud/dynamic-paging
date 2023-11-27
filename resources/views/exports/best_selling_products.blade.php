<table class="table table-bordered aiz-table mb-0">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th> SKU </th>
            <th> Number of Sale </th>
            <th> Purchase Price </th>
            <th> Selling Price </th>
            <th> Variant </th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $key => $product)
            @foreach ($product->variations as $key => $variation )
                        @php
                            $name = '';
                            $code_array = array_filter(explode('/', $variation->code));
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
                        @endphp

                <tr>
                    <td>
                        {{ $product->getTranslation('name') }}
                    </td>
                    <td>
                        @foreach ($product->categories as $category)
                            @if(!$product->categories->isEmpty()) <span class="badge badge-inline badge-md bg-soft-dark mb-1"> {{$category->name}}</span> @else  @endif <br>

                        @endforeach
                    </td>
                    <td>
                        {{ $variation->sku }}
                    </td>
                    <td>
                        <span class="badge badge-inline badge-md bg-soft-dark mb-1">{{$product->num_of_sale}}</span>
                    </td>
                    <td>
                        {{ $variation->purchase_price }}
                    </td>
                    <td>
                        {{ $variation->price }}
                    </td>

                    <td>
                        {{$name}}
                    </td>
                    <td>
                        {{ $variation->stock }}
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
