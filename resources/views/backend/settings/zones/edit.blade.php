@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Zone Information') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('zones.update', $zone) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{ translate('Name') }}</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"value="{{ $zone->name }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{ translate('Districts') }}</label>
                        <div class="col-md-9">
                            <select class="select2 form-control aiz-selectpicker" name="states[]" data-title="{{ translate('Select Districts') }}" data-live-search="true" data-max-options="100" data-actions-box="true" data-selected-text-format="count" multiple required>
                                <option value="0">{{ translate('No District') }}</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" @if ($zone->id == $state->zone_id) selected @endif>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            {{ translate('Flat Delivery Cost') }}
                        </label>
                        <div class="col-md-9">
                            <input type="number" step="0.01" name="standard_delivery_cost" class="form-control" id="flat_delivery_cost" value="{{ $zone->flat_delivery_cost }}" placeholder="{{ translate('Flat Delivery Cost') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
