@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{ translate('Add New Product') }}</h5>
    </div>
    <form class="form form-horizontal mar-top" action="{{ route('product.store') }}" method="POST"
        enctype="multipart/form-data" id="product_form">
        @csrf
        <div class="row gutters-5">
            <div class="col-lg">

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Product Name') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name"
                                    placeholder="{{ translate('Product Name') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Unit') }}</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="unit"
                                    placeholder="{{ translate('Unit (e.g. 500 Gram, 2 Litre, 5 Pc etc)') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Minimum Purchase Qty') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="min_qty" value="1" min="1" required>
                                <small
                                    class="text-muted">{{ translate('Customer need to purchase this minimum quantity for this product. Minimum should be 1.') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Maximum Purchase Qty') }}</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="max_qty" value="0" min="0">
                                <small
                                    class="text-muted">{{ translate('Customer will be able to purchase this maximum quantity for this product. Default 0 for unlimited.') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Low Stock Warning Qty') }}<span
                                class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="low_stock_qty" value="1" min="1">
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
                                <textarea class="aiz-text-editor" name="short_description"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Full Description') }}</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Performance') }}</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="performance"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Application') }}</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="application"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Specification & Approval') }}</label>
                            <div class="col-md-8">
                                <textarea class="aiz-text-editor" name="specification_n_approval"></textarea>
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
                                    <input type="hidden" name="thumbnail_img" class="selected-files">
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
                                    <input type="hidden" name="photos" class="selected-files">
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
                                <div class="input-group" data-toggle="aizuploader" data-type="image" data-mu>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="technical_sheet" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"
                                for="signinSrEmail">{{ translate('Safety Sheet') }}<small>(PDF)</small></label>
                            <div class="col-md-8">
                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                    data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="safety_sheet" class="selected-files">
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
                                <input type="checkbox" name="is_contact_to_buy" value="0" onchange="contact_to_buy(this)" id="is_contact_to_buy">
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- price and stock -->
                <div class="card price_and_stock" id="price_and_stock">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product price, stock') }}</h5>
                        <div class="d-flex mt-2">
                            <label class="mb-0 mr-3 ml-0">{{ translate('Variant Product') }}</label>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" name="is_variant" onchange="is_variant_product(this)">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="no_product_variant">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Regular price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" step="0.01" min="0" value="1"
                                        placeholder="{{ translate('Price') }}" name="price" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Purchase price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" step="0.01" min="0" value="1"
                                        placeholder="{{ translate('Purchase Peice') }}" name="purchase_price" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('SKU') }} <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="test" placeholder="{{ translate('SKU') }}" name="sku"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Stock') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" lang="en" min="0" value="0"
                                    placeholder="{{ translate('Stock') }}" name="stock" class="form-control"
                                    required>
                                </div>
                            </div>
                        </div>
                        <div class="has_product_variant" style="display: none">
                            <div class="alert alert-info">
                                {{ translate('Select an option for this product and then select choices of each option. Max 3 options') }}
                            </div>

                            <div class="customer_choice_options">
                                <div class="form-group row gutters-10 ">
                                    <div class="col-xxl-3 col-xl-4 col-md-5 attr-names">
                                        <select class="form-control aiz-selectpicker" name="product_options[]"
                                            onchange="get_option_choices(this)" data-live-search="true"
                                            title="{{ translate('Select an option') }}">
                                            @foreach ($attributes as $key => $attribute)
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
                            </div>
                            <div class="sku_combination" id="sku_combination">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card product_discount" id="product_discount">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Discount') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 control-label"
                                for="start_date">{{ translate('Discount Date Range') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control aiz-date-range" name="date_range"
                                    placeholder="Select Date" data-time-picker="true" data-format="DD-MM-Y HH:mm:ss"
                                    data-separator=" to " autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Discount') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="number" lang="en" min="0" value="0" step="0.01"
                                    placeholder="{{ translate('Discount') }}" name="discount" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control aiz-selectpicker" name="discount_type">
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
                                    <input type="number" step="0.01" value="0" class="form-control" name="weight" min="0"
                                        required>
                                    <div class="input-group-append"><span
                                            class="input-group-text">{{ get_setting('weight_unit') }}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Height') }}</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" step="0.01" value="0" class="form-control" name="height" min="0"
                                        required>
                                    <div class="input-group-append"><span
                                            class="input-group-text">{{ get_setting('dimension_unit') }}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Length') }}</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" step="0.01" value="0" class="form-control" name="length" min="0"
                                        required>
                                    <div class="input-group-append"><span
                                            class="input-group-text">{{ get_setting('dimension_unit') }}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Width') }}</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number" step="0.01" value="0" class="form-control" name="width" min="0"
                                        required>
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
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product informations') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="all-informations">

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
                                    placeholder="{{ translate('Meta Title') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Description') }}</label>
                            <div class="col-md-8">
                                <textarea name="meta_description" rows="8" class="form-control"></textarea>
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
                                    <input type="hidden" name="meta_image" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
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
                        <select class="form-control aiz-selectpicker" name="status">
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
                        <select class="form-control aiz-selectpicker" name="brand_id" data-live-search="true"
                            title="{{ translate('Select Brand') }}">
                            @foreach (\App\Models\Brand::all() as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Skin Types') }}</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-control aiz-selectpicker" name="skin_type_ids[]"  multiple data-live-search="true"
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
                        <select class="form-control aiz-selectpicker" name="concern_ids[]"  multiple data-live-search="true"
                            title="{{ translate('Select Concern') }}">
                            @foreach (\App\Models\Concern::all() as $concern)
                                <option value="{{ $concern->id }}">{{ $concern->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                <div class="card">

                    <div class="card-body">
                        <div class="form-group mb-3">
                            <h5 class="mb-0 h6">{{ translate('Same Shipping Charge for Fixed Quantity') }}</h5>
                            <div class="d-flex mt-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="same_shipping_charge" value="0" onchange="shipping_charge_same(this)" id="same_shipping_charge">
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
                            <input type="number"  name="shipping_in" value="0" min="0" step="1" class="form-control">
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
                            <input type="number"  name="shipping_out" value="0" min="0" step="1" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header d-felx flex-column">
                        <h5 class="mb-2 h6">{{ translate('Product Category') }}</h5>
                        <input type="text" class="form-control " name="search_cat" id="search_cat" placeholder="Search Category By Name">
                    </div>
                    <div class="card-body ">
                        <div class="h-300px overflow-auto c-scrollbar-light">
                            <ul class="list-unstyled">
                                @foreach ($categories as $category)
                                    <li>
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" value="{{ $category->id }}" name="category_ids[]">
                                            <span class="aiz-square-check"></span>
                                            <span>{{ $category->getTranslation('name') }}</span>
                                        </label>
                                        @if ($category->children_categories_count > 0)
                                            <ul class="list-unstyled ml-3">
                                                @foreach ($category->childrenCategories as $childCategory)
                                                    <li>
                                                        <label class="aiz-checkbox">
                                                            <input type="checkbox" value="{{ $childCategory->id }}"
                                                                name="category_ids[]">
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
                                                                                name="category_ids[]">
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
                            placeholder="{{ translate('Type and hit enter to add a tag') }}">
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

                            <div class="form-row">
                                <div class="form-group col-6">
                                    <input type="number" lang="en" min="0" value="0" step="0.01"
                                        placeholder="{{ translate('Tax') }}" name="taxes[]" class="form-control"
                                        required>
                                </div>
                                <div class="form-group col-6">
                                    <select class="form-control aiz-selectpicker" name="tax_types[]" required>
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
                            <input type="checkbox" name="has_warranty">
                            <span></span>
                        </label>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="mar-all text-right mb-3">
            <button type="submit" class="btn btn-primary" id="upload-product">{{ translate('Upload Product') }}</button>
            <button type="submit" class="btn btn-success" value="publish">{{ translate('Upload Product & Publish') }}</button>

        </div>

    </form>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#search_cat').change(function(){
                var search_cat = $(this).val();
                $.ajax({
                    url: "{{ route('product.ajax_category_search') }}",
                    type: "POST",
                    data: {search_cat:search_cat,_token:"{{ csrf_token() }}"},
                    success: function(data){
                        $('.c-scrollbar-light').html(data);
                    }
                });
            });
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
