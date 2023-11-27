@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Zone Information') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('zones.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{ translate('Name') }}</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{ translate('District') }}</label>
                        <div class="col-md-9">
                            <select class="select2 form-control aiz-selectpicker" name="states[]" data-title="{{ translate('Select districts') }}" data-live-search="true" data-max-options="100" data-actions-box="true" data-selected-text-format="count" multiple required>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            {{ translate('Standard Delivery Cost') }}
                        </label>
                        <div class="col-md-9">
                            <input type="number" step="0.01" value="0" name="flat_delivery_cost" class="form-control" placeholder="{{ translate('Flat Delivery Cost') }}" required>
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
