@extends('backend.layouts.app')
@section('content')
@php
	$all_products = \App\Models\Product::where('published',1)->get();
	$all_brands = \App\Models\Brand::all();
	$all_shops = filter_shops(\App\Models\Shop::query())->get();
	$level_0_categories = \App\Models\Category::get();
@endphp
<h6 class="fw-600">{{ translate('Key Management Page Settings') }}</h6>
<div class="accordion" id="accordionExample">


	<!-- Main Section -->
	<div class="card border-bottom">
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#collapseMainSectionBox" aria-expanded="false" aria-controls="collapseMainSectionBox">
			<h6 class="my-2">{{ translate('Main Banner') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseMainSectionBox" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row gutters-10 border-bottom pb-4 mb-4">
						<div class="col-lg-2">
							<label class="from-label d-block">{{translate('Banner')}}</label>
						</div>
						<div class="col-lg-10">
							<div class="main-section-target">
								<input type="hidden" name="types[]" value="mission_vission_banner_section_images">
								@if (get_setting('mission_vission_banner_section_images') != null)
									@foreach (json_decode(get_setting('mission_vission_banner_section_images'), true) as $key => $value)
										<div class="row gutters-5 mb-3">
											<div class="col-lg-3">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose Image') }}</div>
														<input type="hidden" name="mission_vission_banner_section_images[]" class="selected-files" value="{{ $value }}">
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
									@endforeach
								@endif
							</div>
							<div class="text-right">
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5 mb-3">
										<div class="col-lg-3">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose Image') }}</div>
													<input type="hidden" name="mission_vission_banner_section_images[]" class="selected-files">
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
									data-target=".main-section-target">
									{{ translate('Add New') }}
								</button>
							</div>
						</div>
					</div>

					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>


	<!-- Management Section -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseinfosection" aria-expanded="true" aria-controls="collapseinfosection">
			<h6 class="my-2">{{ translate('Management Section') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseinfosection" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="game_section" value="Management Section">

					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('image, name, designation & description')}}</label>
							{{-- <small>{{ translate('Recommended size').' 1300x145' }}</small> --}}
						</div>
						<div class="col-lg-9">
							<div class="home-banner-1-target">
								<input type="hidden" name="types[]" value="mv_management_section_images">
								<input type="hidden" name="types[]" value="mv_management_section_names">
								<input type="hidden" name="types[]" value="mv_management_section_designations">
								<input type="hidden" name="types[]" value="mv_management_section_titles">
								<input type="hidden" name="types[]" value="mv_management_section_descriptions">
								@if (get_setting('mv_management_section_images') != null)
								@foreach (json_decode(get_setting('mv_management_section_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="mv_management_section_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="Name" name="mv_management_section_names[]" value="{{ json_decode(get_setting('mv_management_section_names'),true)[$key] }}" class="form-control">
										</div>
										<div class="col-lg">
											<input type="text" placeholder="Designation" name="mv_management_section_designations[]" value="{{ json_decode(get_setting('mv_management_section_designations'),true)[$key] }}" class="form-control">
										</div>
										<div class="col-lg">
											<input type="text" placeholder="Description" name="mv_management_section_descriptions[]" value="{{ json_decode(get_setting('mv_management_section_descriptions'),true)[$key] }}" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								@endforeach
								@endif
							</div>
							<div class="text-right">
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='<div class="row gutters-5">
										<div class="col-lg-3">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="mv_management_section_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="Name" name="mv_management_section_names[]" class="form-control">
										</div>
										<div class="col-lg">
											<input type="text" placeholder="Designation" name="mv_management_section_designations[]" class="form-control">
										</div>
										<div class="col-lg">
											<input type="text" placeholder="Description" name="mv_management_section_descriptions[]" class="form-control">
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
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
