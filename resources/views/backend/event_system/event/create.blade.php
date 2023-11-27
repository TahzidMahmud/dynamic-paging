@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Event Information')}}</h5>
            </div>
            <div class="card-body">
                <form id="add_form" class="form-horizontal" action="{{ route('event.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            {{translate('Event Name')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input type="text" placeholder="{{translate('Event Name')}}" id="name" name="name" class="form-control" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">
                            {{translate('Banner')}}
                            {{-- <small>(1300x650)</small> --}}
                        </label>
                        <div class="col-md-9">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse')}}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="banner" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            {{translate('Short Description')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <textarea name="description" rows="5" class="form-control" required=""></textarea>
                        </div>
                    </div>
                    <div class="accordion" id="accordionExample">
                        <div class="card border-bottom">
                            <div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeBannerOne" aria-expanded="true" aria-controls="collapseHomeBannerOne">
                                <h6 class="my-2">{{ translate('Gallery Section') }}</h6>
                                <i class="las la-angle-down opacity-60 fs-20"></i>
                            </div>
                            <div id="collapseHomeBannerOne" class="collapse" data-parent="#accordionExample">
                                <div class="card-body">

                                        <div class="form-group row gutters-10">
                                            <div class="col-lg-3">
                                                <label class="from-label d-block">{{translate('Event Images')}}</label>
                                                <small>{{ translate('Recommended size').' 1200x450' }}</small>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="home-banner-1-target">
                                                    <input type="hidden" name="types[]" value="images">

                                                        <div class="row">
                                                            <div class="col-lg">
                                                                <div class="form-group">
                                                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                                                        </div>
                                                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                                                        <input type="hidden" name="images[]" class="selected-files" value="">
                                                                    </div>
                                                                    <div class="file-preview box sm"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                                                    <i class="las la-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="text-right">
                                                    <button
                                                        type="button"
                                                        class="btn btn-soft-secondary btn-sm"
                                                        data-toggle="add-more"
                                                        data-content='<div class="row gutters-5">
                                                            <div class="col-lg">
                                                                <div class="form-group">
                                                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                                                        </div>
                                                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                                                        <input type="hidden" name="images[]" class="selected-files">
                                                                    </div>
                                                                    <div class="file-preview box sm"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                                                    <i class="las la-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>'
                                                        data-target=".home-banner-1-target">
                                                        {{ translate('Add New') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">
                            {{translate('Save')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
    function makeSlug(val) {
        let str = val;
        let output = str.replace(/\s+/g, '-').toLowerCase();
        $('#slug').val(output);
    }
</script>
@endsection
