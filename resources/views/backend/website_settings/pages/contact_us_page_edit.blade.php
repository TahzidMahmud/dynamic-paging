@extends('backend.layouts.app')
@section('content')
@php
	$all_products = \App\Models\Product::where('published',1)->get();
	$all_brands = \App\Models\Brand::all();
	$all_shops = filter_shops(\App\Models\Shop::query())->get();
	$level_0_categories = \App\Models\Category::get();
@endphp
<h6 class="fw-600">{{ translate('Contact Us Page Settings') }}</h6>
<div class="accordion" id="accordionExample">

	<!-- Gallery Section -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeBannerOne" aria-expanded="true" aria-controls="collapseHomeBannerOne">
			<h6 class="my-2">{{ translate('Contact Info Section') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeBannerOne" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf

					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('Icon & Information')}}</label>
						</div>
						<div class="col-lg-9">
							<div class="home-banner-1-target">
								<input type="hidden" name="types[]" value="info_section_icons">
								<input type="hidden" name="types[]" value="info_section_content">
								@if (get_setting('info_section_icons') != null)
								@foreach (json_decode(get_setting('info_section_icons'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="info_section_icons[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="info_section_content[]" value="{{ json_decode(get_setting('info_section_content'),true)[$key] }}" class="form-control">
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
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="info_section_icons[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="info_section_content[]" class="form-control">
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
	<!-- Cover Image Section -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeBannerTwo" aria-expanded="true" aria-controls="collapseHomeBannerTwo">
			<h6 class="my-2">{{ translate('Cover Image Section') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeBannerTwo" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf

					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('Cover Image')}}</label>
						</div>
						<div class="col-lg-9">
							<div class="home-banner-1-target">
								<input type="hidden" name="types[]" value="contact_us_cover_image">
								@if (get_setting('contact_us_cover_image') != null)
								@foreach (json_decode(get_setting('contact_us_cover_image'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="contact_us_cover_image[]" class="selected-files" value="{{ $value }}">
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
									data-content='<div class="row gutters-5">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="contact_us_cover_image[]" class="selected-files">
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

					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
