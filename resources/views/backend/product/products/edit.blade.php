@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h1 class="mb-0 h6">{{ translate('Edit Product') }}</h5>
    </div>
    <form class="form form-horizontal mar-top" action="{{ route('product.update', $product->id) }}" method="POST"
        enctype="multipart/form-data" id="product_form">
        @csrf
        <input type="hidden" name="id" value="{{ $product->id }}">
        <input type="hidden" name="lang" value="{{ $lang }}">
        <input type="hidden" name="product_update" value="product_update">
        <ul class="nav nav-tabs nav-fill border-light">
            @foreach (\App\Models\Language::where('status',1)->get() as $key => $language)
                <li class="nav-item">
                    <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                        href="{{ route('product.edit', ['id' => $product->id, 'lang' => $language->code]) }}">
                        <img src="{{ static_asset('assets/img/flags/' . $language->flag . '.png') }}" height="11"
                            class="mr-1">
                        <span>{{ $language->name }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="row gutters-5">
            <div class="col-lg">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Product Name') }} <span
                                    class="text-danger">*</span> <i class="las la-language text-danger"
                                    title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name"
                                    placeholder="{{ translate('Product Name') }}"
                                    value="{{ $product->getTranslation('name', $lang) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Unit') }} <i
                                    class="las la-language text-danger"
                                    title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="unit"
                                    placeholder="{{ translate('Unit (e.g. 500 Gram, 2 Litre, 5 Pc etc)') }}"
                                    value="{{ $product->getTranslation('unit', $lang) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Minimum Purchase Qty') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="min_qty" min="1"
                                    value="{{ $product->min_qty }}" required>
                                <small
                                    class="text-muted">{{ translate('Customer need to purchase this minimum quantity for this product. Minimum should be 1.') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Maximum Purchase Qty') }}</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="max_qty"
                                    value="{{ $product->max_qty }}" min="0">
                                <small
                                    class="text-muted">{{ translate('Customer will be able to purchase this maximum quantity for this product. Default 0 for unlimited.') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Low Stock Warning Qty') }}<span
                                class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="low_stock_qty" value="{{ $product->low_stock_quantity }}" min="1">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Description') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Short Description (2 Lines)') }}</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="short_description">{{$product->short_description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Description') }} <i
                                    class="las la-language text-danger"
                                    title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="description">{!! $product->getTranslation('description', $lang) !!}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Performance') }}</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="performance">{{$product->performance}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Application') }}</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="application">{{$product->application}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label"> Specification & Approval</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="specification_n_approval">{{$product->specification_n_approval}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Images') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Thumbnail Image') }}
                                <small>(300x300)</small></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image" data-mu>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="thumbnail_img" class="selected-files"
                                        value="{{ $product->thumbnail_img }}">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <small
                                    class="text-muted">{{ translate('This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around the main object of your image as we had to crop some edge in different devices to make it responsive.') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">{{ translate('Gallery Images') }}<small>(600x600)</small></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                    data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="photos" class="selected-files"
                                        value="{{ $product->photos }}">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <small
                                    class="text-muted">{{ translate("These images are visible in the product details page gallery. Use 600x600 or higher sizes images for better quality. But try to keep file size low as it'll increase page load time.") }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Files') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Technical Sheet') }}
                                <small>(PDF)</small></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="document" data-mu>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="technical_sheet" class="selected-files" value="{{ $product->technical_sheet }}">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">{{ translate('Safety Sheet') }}<small>(PDF)</small></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="document"
                                    data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="safety_sheet" class="selected-files" value="{{ $product->safety_sheet }}">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Contact To Buy Product') }}</h5>
                        <div class="d-flex mt-2">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" name="is_contact_to_buy"  id="is_contact_to_buy" onchange="contact_to_buy(this)" @if ($product->contact_to_buy) checked @endif value={{$product->contact_to_buy}}>
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- price and stock -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product price, stock') }}</h5>
                        <div class="d-flex mt-2">
                            <label class="mb-0 mr-3 ml-0">{{ translate('Variant Product') }}</label>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" name="is_variant" onchange="is_variant_product(this)"
                                    @if ($product->is_variant) checked @endif>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $first_variation = $product->variations->first();
                            $price = !$product->is_variant ? $first_variation->price : 0;
                            $purchase_price = !$product->is_variant ? $first_variation->purchase_price : 0;
                            $sku = !$product->is_variant ? $first_variation->sku : null;
                            $stock = !$product->is_variant ? $first_variation->stock : 1;
                        @endphp


                        <div class="no_product_variant" @if ($product->is_variant) style="display:none;" @endif>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Regular price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" step="0.01" min="0" value="{{ $price }}"
                                        placeholder="{{ translate('Price') }}" name="price" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Purchase price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" step="0.01" min="0" value="{{ $purchase_price }}"
                                        placeholder="{{ translate('purchase_price') }}" name="purchase_price" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('SKU') }} <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="test" placeholder="{{ translate('SKU') }}" value="{{ $sku }}"
                                        name="sku" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Stock') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" lang="en" min="0" value="{{ $product->stock }}"
                                    placeholder="{{ translate('Stock') }}" name="stock" class="form-control"
                                    required>
                                    {{-- <select class="form-control aiz-selectpicker" name="stock"
                                        data-selected="{{ $stock }}">
                                        <option value="1">{{ translate('In stock') }}</option>
                                        <option value="0">{{ translate('Out of stock') }}</option>
                                    </select> --}}
                                </div>
                            </div>
                        </div>
                        <div class="has_product_variant" @if (!$product->is_variant) style="display:none;" @endif>
                            <div class="alert alert-info">
                                {{ translate('Select an option for this product and then select choices of each option. Max 3 options') }}
                            </div>

                            <div class="customer_choice_options">

                                @forelse (generate_variation_options($product->variation_combinations) as $key => $combination)
                                    <div class="form-group row gutters-10 ">
                                        <div class="col-xxl-3 col-xl-4 col-md-5 attr-names">
                                            <select class="form-control aiz-selectpicker" name="product_options[]"
                                                onchange="get_option_choices(this)" data-live-search="true"
                                                title="{{ translate('Select an option') }}"
                                                data-selected="{{ $combination['id'] }}">
                                                @foreach ($all_attributes as $attribute)
                                                    <option value="{{ $attribute->id }}">
                                                        {{ $attribute->getTranslation('name') }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col attr-values">
                                            @php
                                                $attribute_values = \App\Models\AttributeValue::where('attribute_id', $combination['id'])->get();
                                                $old_val = array_map(function ($val) {
                                                    return $val['id'];
                                                }, $combination['values']);
                                            @endphp
                                            <select class="form-control aiz-selectpicker"
                                                name="option_{{ $combination['id'] }}_choices[]" multiple
                                                data-live-search="true" onchange="update_sku()"
                                                data-selected="{{ json_encode($old_val) }}">
                                                @foreach ($attribute_values as $attribute_value)
                                                    <option value="{{ $attribute_value->id }}">
                                                        {{ $attribute_value->getTranslation('name') }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($key == 0)
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-icon btn-soft-secondary"
                                                    onclick="add_new_option()">
                                                    <i class="la-plus las opacity-70"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-auto">
                                                <button type="button" data-toggle="remove-parent" class="btn btn-icon p-0"
                                                    data-parent=".row" onclick="update_sku()">
                                                    <i class="la-2x la-trash las opacity-70"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="form-group row gutters-10 ">
                                        <div class="col-xxl-3 col-xl-4 col-md-5 attr-names">
                                            <select class="form-control aiz-selectpicker" name="product_options[]"
                                                onchange="get_option_choices(this)" data-live-search="true"
                                                title="{{ translate('Select an option') }}">
                                                @foreach ($all_attributes as $key => $attribute)
                                                    <option value="{{ $attribute->id }}">
                                                        {{ $attribute->getTranslation('name') }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col attr-values">
                                            <div class="form-control">
                                                <span>{{ translate('Select an option') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-icon btn-soft-secondary"
                                                onclick="add_new_option()">
                                                <i class=" la-plus las opacity-70"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                            <div class="sku_combination" id="sku_combination">
                                @if ($product->is_variant)
                                    @include('backend.product.products.sku_combinations_edit',['variations' =>
                                    $product->variations])
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Discount') }}</h5>
                    </div>
                    <div class="card-body">
                        @php
                            if ($product->discount_start_date) {
                                $start_date = date('d-m-Y H:i:s', $product->discount_start_date);
                                $end_date = date('d-m-Y H:i:s', $product->discount_end_date);
                                $discount_date = $start_date . ' to ' . $end_date;
                            } else {
                                $discount_date = '';
                            }
                        @endphp
                        <div class="form-group row">
                            <label class="col-sm-3 control-label"
                                for="start_date">{{ translate('Discount Date Range') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control aiz-date-range" name="date_range"
                                    placeholder="Select Date" data-time-picker="true" data-format="DD-MM-Y HH:mm:ss"
                                    data-separator=" to " value="{{ $discount_date }}" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Discount') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="{{ $product->discount }}" step="0.01"
                                    placeholder="{{ translate('Discount') }}" name="discount" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control aiz-selectpicker" name="discount_type"
                                    data-selected="{{ $product->discount_type }}">
                                    <option value="flat">{{ translate('Flat') }}</option>
                                    <option value="percent">{{ translate('Percent') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Shipping Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Weight') }}</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" name="weight" min="0"
                                        value="{{ $product->weight }}" required>
                                    <div class="input-group-append"><span
                                            class="input-group-text">{{ get_setting('weight_unit') }}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Height') }}</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" name="height" min="0"
                                        value="{{ $product->height }}" required>
                                    <div class="input-group-append"><span
                                            class="input-group-text">{{ get_setting('dimension_unit') }}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Length') }}</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" name="length" min="0"
                                        value="{{ $product->length }}" required>
                                    <div class="input-group-append"><span
                                            class="input-group-text">{{ get_setting('dimension_unit') }}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Width') }}</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" name="width" min="0"
                                        value="{{ $product->width }}" required>
                                    <div class="input-group-append"><span
                                            class="input-group-text">{{ get_setting('dimension_unit') }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product attributes') }}</h5>
                        <button class="btn btn-soft-dark" type="button"
                            onclick="add_new_attribute()">{{ translate('Add new attribute') }}</button>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            {{ translate('These attributes will be used only for filtering.') }}</div>
                        <div class="all-attributes">
                            @foreach ($product->attributes as $product_attribute)
                                <div class="form-group row gutters-10">
                                    <div class="col-xxl-3 col-xl-4 col-md-5 attr-names">
                                        <select class="form-control aiz-selectpicker" name="product_attributes[]"
                                            onchange="get_attributes_values(this)"
                                            data-selected="{{ $product_attribute->attribute_id }}"
                                            data-live-search="true" readonly>
                                            <option value="">{{ translate('Select an attribute') }}</option>
                                            @foreach ($all_attributes as $key => $attribute)
                                                <option value="{{ $attribute->id }}">
                                                    {{ $attribute->getTranslation('name') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col attr-values">
                                        @php
                                            $attribute_values = \App\Models\AttributeValue::where('attribute_id', $product_attribute->attribute_id)->get();
                                        @endphp
                                        <select class="form-control aiz-selectpicker"
                                            name="attribute_{{ $product_attribute->attribute_id }}_values[]"
                                            data-selected="{{ $product->attribute_values->where('attribute_id', $product_attribute->attribute_id)->pluck('attribute_value_id') }}"
                                            multiple data-live-search="true">
                                            @foreach ($attribute_values as $key => $attribute_value)
                                                <option value="{{ $attribute_value->id }}">
                                                    {{ $attribute_value->getTranslation('name') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" data-toggle="remove-parent" class="btn btn-icon p-0"
                                            data-parent=".row">
                                            <i class="la-2x la-trash las opacity-70"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product informations') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="all-informations">
                            @foreach(json_decode($product->informations ?? '[]') as $key => $inform)
                                <div class="row gutters-5 mb-3">
                                    <div class="col-md-4">
                                        <input type="text" placeholder="{{ translate('Title') }}" name="information_titles[]" value="{{ $inform->title }}" class="form-control">
                                    </div>
                                    <div class="col">
                                        <input type="text" placeholder="{{ translate('Details') }}" name="information_details[]" value="{{ $inform->detail }}" class="form-control">
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                            <i class="las la-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 border-top pt-4">
                            <button
                                class="btn btn-soft-dark"
                                type="button"
                                data-toggle="add-more"
                                data-target=".all-informations"
								data-content='<div class="row gutters-5 mb-3">
                                    <div class="col-md-4">
                                        <input type="text" placeholder="{{ translate('Title') }}" name="information_titles[]" class="form-control">
                                    </div>
                                    <div class="col">
                                        <input type="text" placeholder="{{ translate('Details') }}" name="information_details[]" class="form-control">
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                            <i class="las la-times"></i>
                                        </button>
                                    </div>
                                </div>'
                            >
                                Add New
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('SEO Meta Tags') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Meta Title') }}</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="meta_title"
                                    placeholder="{{ translate('Meta Title') }}" value="{{ $product->meta_title }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Description') }}</label>
                            <div class="col-md-8">
                                <textarea name="meta_description" rows="8"
                                    class="form-control">{{ $product->meta_description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">{{ translate('Meta Image') }}</label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="meta_image" class="selected-files"
                                        value="{{ $product->meta_image }}">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Slug') }}</label>
                            <div class="col-md-8">
                                <input type="text" placeholder="{{ translate('Slug') }}" id="slug" name="slug"
                                    value="{{ $product->slug }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-lg-auto w-lg-300px w-xxl-400px">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Status') }}</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-control aiz-selectpicker" name="status"
                            data-selected="{{ $product->published }}">
                            <option value="0">{{ translate('Draft') }}</option>
                            <option value="1" selected>{{ translate('Published') }}</option>
                        </select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Brand') }}</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-control aiz-selectpicker" name="brand_id"
                            data-selected="{{ $product->brand_id }}" data-live-search="true"
                            title="{{ translate('Select Brand') }}">
                            @foreach (\App\Models\Brand::all() as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card">

                    <div class="card-body">
                        <div class="form-group mb-3">
                            <h5 class="mb-0 h6">{{ translate('Same Shipping Charge for Fixed Quantity') }}</h5>
                            <div class="d-flex mt-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="same_shipping_charge" value="{{$product->same_shipping_charge}}" onchange="shipping_charge_same(this)" id="same_shipping_charge" @if ($product->same_shipping_charge) checked @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">
                          Shipping Charge Inside Dhaka
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">
                            Amount
                            </label>
                            <input type="number" value="{{$product->shipping_in}}" name="shipping_in" value="0" min="0" step="1" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">
                          Shipping Charge Outside Dhaka
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">
                            Amount
                            </label>
                            <input type="number" value="{{$product->shipping_out}}" name="shipping_out" value="0" min="0" step="1" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Skin Types') }}</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $product_skin_types = $product->skin_types->pluck('id')->toArray();
                        @endphp
                        <select class="form-control aiz-selectpicker" name="skin_type_ids[]" data-selected={{ json_encode($product_skin_types) }}  multiple data-live-search="true"
                            title="{{ translate('Select Skin Type') }}">
                            @foreach (\App\Models\SkinType::all() as $skin_type)
                                <option value="{{ $skin_type->id }}">{{ $skin_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Concerns') }}</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $product_concerns = $product->concerns->pluck('id')->toArray();
                        @endphp
                        <select class="form-control aiz-selectpicker" name="concern_ids[]" data-selected={{ json_encode($product_concerns) }}   multiple data-live-search="true"
                            title="{{ translate('Select Concern') }}">
                            @foreach (\App\Models\Concern::all() as $concern)
                                <option value="{{ $concern->id }}">{{ $concern->name }}</option>

                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Category') }}</h5>
                    </div>
                    <div class="card-body ">
                        <div class="h-300px overflow-auto c-scrollbar-light">
                            <ul class="list-unstyled">
                                @php
                                    $old_categories = $product->product_categories->pluck('category_id')->toArray();
                                @endphp
                                @foreach ($categories as $category)
                                    <li>
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" value="{{ $category->id }}" name="category_ids[]"
                                                @if (in_array($category->id, $old_categories)) checked @endif>
                                            <span class="aiz-square-check"></span>
                                            <span>{{ $category->getTranslation('name') }}</span>
                                        </label>
                                        @if (count($category->childrenCategories) > 0)
                                            <ul class="list-unstyled ml-3">
                                                @foreach ($category->childrenCategories as $childCategory)
                                                    <li>
                                                        <label class="aiz-checkbox">
                                                            <input type="checkbox" value="{{ $childCategory->id }}"
                                                                name="category_ids[]" @if (in_array($childCategory->id, $old_categories)) checked @endif>
                                                            <span class="aiz-square-check"></span>
                                                            <span>{{ $childCategory->getTranslation('name') }}</span>
                                                        </label>
                                                        @if (count($childCategory->childrenCategories) > 0)
                                                            <ul class="list-unstyled ml-3">
                                                                @foreach ($childCategory->childrenCategories as $grandChildCategory)
                                                                    <li>
                                                                        <label class="aiz-checkbox">
                                                                            <input type="checkbox"
                                                                                value="{{ $grandChildCategory->id }}"
                                                                                name="category_ids[]"
                                                                                @if (in_array($grandChildCategory->id, $old_categories)) checked @endif>
                                                                            <span class="aiz-square-check"></span>
                                                                            <span>{{ $grandChildCategory->getTranslation('name') }}</span>
                                                                        </label>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Tags') }}</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control aiz-tag-input" name="tags"
                            placeholder="{{ translate('Type and hit enter to add a tag') }}"
                            value="{{ $product->tags }}">
                        <small class="text-muted">{{ translate('These will be used for product search.') }}</small>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('VAT & Tax') }}</h5>
                    </div>
                    <div class="card-body">
                        @foreach (\App\Models\Tax::all() as $tax)
                            <label for="name">
                                {{ $tax->name }}
                                <input type="hidden" value="{{ $tax->id }}" name="tax_ids[]">
                            </label>

                            @php
                                $tax_amount = 0;
                                $tax_type = 'flat';
                                foreach ($product->taxes as $row) {
                                    if ($row->tax_id == $tax->id) {
                                        $tax_amount = $row->tax;
                                        $tax_type = $row->tax_type;
                                    }
                                }
                            @endphp

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <input type="number" lang="en" min="0" value="{{ $tax_amount }}" step="0.01"
                                        placeholder="{{ translate('Tax') }}" name="taxes[]" class="form-control"
                                        required>
                                </div>
                                <div class="form-group col-6">
                                    <select class="form-control aiz-selectpicker" name="tax_types[]"
                                        data-selected="{{ $tax_type }}" required>
                                        <option value="flat">{{ translate('Flat') }}</option>
                                        <option value="percent">{{ translate('Percent') }}</option>
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Warranty') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">{{ translate('Warranty available for this product?') }}</div>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" name="has_warranty" @if ($product->has_warranty) checked @endif>
                            <span></span>
                        </label>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="mar-all text-right mb-3">
            <button type="submit" class="btn btn-primary"
                id="upload-product">{{ translate('Update Product') }}</button>
        </div>
    </form>

@endsection

@section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            // $('body').addClass('side-menu-closed');
            $('.all-attributes').find('.attr-names').find('.aiz-selectpicker').siblings('.dropdown-toggle')
                .addClass("disabled");
            if ($('.customer_choice_options').find('.attr-names').find('.aiz-selectpicker').val() !== '') {
                $('.customer_choice_options').find('.attr-names').find('.aiz-selectpicker').siblings(
                    '.dropdown-toggle').addClass("disabled");
            }
        });
        $('#product_form').bind('submit', function(e) {
            // Disable the submit button while evaluating if the form should be submitted
            $("#upload-product").prop('disabled', true);

            var valid = true;

            if (!valid) {
                e.preventDefault();

                // Reactivate the button if the form was not submitted
                $("#upload-product").button.prop('disabled', false);
            }
        });

        function is_variant_product(el) {
            $(".has_product_variant").hide();
            $(".no_product_variant").hide();
            if ($(el).is(':checked')) {
                $('[name="sku"]').prop('required',false);
                $(".has_product_variant").show();
                $('.variations-sku').each(function(){
                    $(this).prop('required',true);
                });
            } else {
                $(".no_product_variant").show();
                $('[name="sku"]').prop('required',true);
                $('.variations-sku').each(function(){
                    $(this).prop('required',false);
                });
            }
        }
        function contact_to_buy(el) {

            if ($(el).is(':checked')) {
                $("#is_contact_to_buy").val('1');
            } else {
                $("#is_contact_to_buy").val('0');

            }
        }
        function shipping_charge_same(el) {

            if ($(el).is(':checked')) {
                $("#same_shipping_charge").val('1');
            } else {
                $("#same_shipping_charge").val('0');

            }
        }

        function add_new_attribute() {
            $.ajax({
                type: "POST",
                data: $('#product_form').serialize(),
                url: '{{ route('product.new_attribute') }}',
                success: function(data) {
                    if (data.count == -1) {
                        AIZ.plugins.notify('warning', '{{ translate('Please select an attribute.') }}');
                    } else if (data.count > 0) {
                        $('.all-attributes').find('.attr-names').find('.aiz-selectpicker').siblings(
                            '.dropdown-toggle').addClass("disabled");
                        $('.all-attributes').append(data.view);
                        AIZ.plugins.bootstrapSelect();
                    } else {
                        AIZ.plugins.notify('info', '{{ translate('No more arrtribute found.') }}');
                    }
                }
            });
        }

        function get_attributes_values(e) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': AIZ.data.csrf
                },
                type: "POST",
                data: {
                    attribute_id: $(e).val()
                },
                url: '{{ route('product.get_attribute_values') }}',
                success: function(data) {
                    $(e).closest('.row').find('.attr-values').html(data);
                    AIZ.plugins.bootstrapSelect();
                }
            });
        }

        function add_new_option() {
            $.ajax({
                type: "POST",
                data: $('#product_form').serialize(),
                url: '{{ route('product.new_option') }}',
                success: function(data) {
                    if (data.count == -2) {
                        AIZ.plugins.notify('warning', '{{ translate('Maximum option limit reached.') }}');
                    } else if (data.count == -1) {
                        AIZ.plugins.notify('warning', '{{ translate('Please select an option.') }}');
                    } else if (data.count > 0) {
                        $('.customer_choice_options').find('.attr-names').find('.aiz-selectpicker').siblings(
                            '.dropdown-toggle').addClass("disabled");
                        $('.customer_choice_options').append(data.view);
                        AIZ.plugins.bootstrapSelect();
                    } else {
                        AIZ.plugins.notify('info', '{{ translate('No more option found.') }}');
                    }
                }
            });
        }

        function get_option_choices(e) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': AIZ.data.csrf
                },
                type: "POST",
                data: {
                    attribute_id: $(e).val()
                },
                url: '{{ route('product.get_option_choices') }}',
                success: function(data) {
                    $(e).closest('.row').find('.attr-values').html(data);
                    AIZ.plugins.bootstrapSelect();
                }
            });
        }

        function update_sku() {
            $.ajax({
                type: "POST",
                url: '{{ route('product.sku_combination') }}',
                data: $('#product_form').serialize(),
                success: function(data) {
                    $('#sku_combination').html(data);
                    setTimeout(() => {
                        AIZ.uploader.previewGenerate();
                        AIZ.plugins.bootstrapSelect('refresh');
                    }, 500);
                }
            });
        }
    </script>

@endsection
