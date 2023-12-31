@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{ translate('Offer Information') }}</h5>
    </div>

    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Edit Offer Information') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('offers.update', $offer->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Title') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Title') }}" id="name" name="title"
                                value="{{ $offer->title }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{ translate('Banner') }} <small>(1920x500)</small></label>
                        <div class="col-md-9">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="banner" value="{{ $offer->banner }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>

                    @php
                        $start_date = date('d-m-Y H:i:s', $offer->start_date);
                        $end_date = date('d-m-Y H:i:s', $offer->end_date);
                    @endphp

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="start_date">{{ translate('Date') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control aiz-date-range"
                                value="{{ $start_date . ' to ' . $end_date }}" data-format="DD-MM-Y HH:mm:ss"
                                name="date_range" data-time-picker="true" placeholder="Select Date" data-past-disable="true"
                                data-separator=" to ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="products">{{ translate('Products') }}</label>
                        <div class="col-sm-9">
                            @php

                                $offer_products_serials= \App\Models\OfferProduct::where('offer_id', $offer->id)
                                    ->pluck('serial_number')
                                    ->toArray();

                            @endphp

                            <select name="products[]" id="products" class="form-control with-ajax" multiple required data-placeholder="{{ translate('Choose Products') }}"
                            data-serials="{{ json_encode($offer_products_serials)}}" data-live-search="true" data-selected-text-format="count" data-toggle="products-search">
                                @foreach($offer->products as $product)
                                    <option value="{{ $product->id }}" selected>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="alert alert-danger">
                        {{ translate('If any product has discount or exists in another offer, that discount will be replaced by this discount & time limit.') }}
                    </div>
                    <br>
                    <div class="form-group row" id="discount_table">

                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            var product_ids = $('#products').val();
            if (product_ids.length > 0) {
                $.post('{{ route('offers.product_discount_edit') }}', {
                    _token: '{{ csrf_token() }}',
                    product_ids: product_ids,
                    serial_ids: $('#products').attr('data-serials'),
                    offer_id: {{ $offer->id }}
                }, function(data) {
                    $('#discount_table').html(data);
                    AIZ.plugins.bootstrapSelect();
                });
            } else {
                $('#discount_table').html(null);
            }

            $('#products').on('change', function() {
                get_offer_discount();
            });

            function get_offer_discount() {
                var product_ids = $('#products').val();
                if(product_ids.length > 0){
                    $.post('{{ route('offers.product_discount') }}', {_token:'{{ csrf_token() }}', product_ids:product_ids}, function(data){
                        $('#discount_table').html(data);
                        $(".aiz-selectpicker").selectpicker();
                    });
                }
                else{
                    $('#discount_table').html(null);
                }
            }
        });
    </script>
@endsection
