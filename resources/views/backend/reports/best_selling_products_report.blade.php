@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">{{translate('Best Selling Product Report')}}</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <!--card body-->
            <div class="card-body">
                <form action="{{ route('best_selling_product_report.index') }}" method="GET">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">{{translate('Sort by')}} :</label>
                        <div class="col-md-3">
                            <select id="demo-ease" class="from-control aiz-selectpicker" data-live-search="true" name="category">
                                <option value="">Category N/A</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{request('category') == $category->id ? 'selected' : '' }} >{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary" type="submit">{{ translate('Filter') }}</button>
                        </div>
                        @can('export_reports')
                            <div class="col-md-2">
                                <a class="btn btn-light" href="{{ route('best_selling_product_report.index', ['category='.request('category'), 'page='.request('page'), 'export=export']) }}">{{ translate('Export') }}</a>
                            </div>
                        @endcan
                    </div>
                </form>
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
                <div class="aiz-pagination mt-4">
                    {{$products->appends(Request::all())->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
