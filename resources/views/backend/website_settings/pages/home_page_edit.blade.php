@extends('backend.layouts.app')
@section('content')
@php
	$all_products = \App\Models\Product::where('published',1)->get();
	$all_brands = \App\Models\Brand::all();
	$all_shops = filter_shops(\App\Models\Shop::query())->get();
	$level_0_categories = \App\Models\Category::get();
@endphp
<h6 class="fw-600">{{ translate('Home Page Settings') }}</h6>
<div class="accordion" id="accordionExample">
	<!-- Home Slider -->
	<div class="card border-bottom">
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#collapseHomeSlider" aria-expanded="false" aria-controls="collapseHomeSlider">
			<h6 class="my-2">{{ translate('Home Page Main Sliders') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeSlider" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf

                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="Home Page Main Sliders">

					<div class="form-group row gutters-10 border-bottom pb-4 mb-4">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('1st Sliders image & link')}}</label>
							<small>{{ translate('Recommended size').' 640x310' }}</small>
						</div>
						<div class="col-lg-9">
							<div class="home-slider-1-target">
								<input type="hidden" name="types[]" value="home_slider_1_images">
								<input type="hidden" name="types[]" value="home_slider_1_links">
								@if (get_setting('home_slider_1_images') != null)
								@foreach (json_decode(get_setting('home_slider_1_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_slider_1_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_1_links[]" value="{{ json_decode(get_setting('home_slider_1_links'),true)[$key] }}" class="form-control">
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
													<input type="hidden" name="home_slider_1_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_1_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-slider-1-target">
									{{ translate('Add New') }}
								</button>
							</div>
						</div>
					</div>
					<div class="form-group row gutters-10 border-bottom pb-4 mb-4">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('2nd Sliders image & link')}}</label>
							<small>{{ translate('Recommended size').' 310x145' }}</small>
						</div>
						<div class="col-lg-9">
							<div class="home-slider-3-target">
								<input type="hidden" name="types[]" value="home_slider_3_images">
								<input type="hidden" name="types[]" value="home_slider_3_links">
								@if (get_setting('home_slider_3_images') != null)
								@foreach (json_decode(get_setting('home_slider_3_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_slider_3_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_3_links[]" value="{{ json_decode(get_setting('home_slider_3_links'),true)[$key] }}" class="form-control">
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
													<input type="hidden" name="home_slider_3_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_3_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-slider-3-target">
									{{ translate('Add New') }}
								</button>
							</div>
						</div>
					</div>
					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('3rd Sliders image & link')}}</label>
							<small>{{ translate('Recommended size').' 310x145' }}</small>
						</div>
						<div class="col-lg-9">
							<div class="home-slider-4-target">
								<input type="hidden" name="types[]" value="home_slider_4_images">
								<input type="hidden" name="types[]" value="home_slider_4_links">
								@if (get_setting('home_slider_4_images') != null)
								@foreach (json_decode(get_setting('home_slider_4_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_slider_4_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_4_links[]" value="{{ json_decode(get_setting('home_slider_4_links'),true)[$key] }}" class="form-control">
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
													<input type="hidden" name="home_slider_4_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_slider_4_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-slider-4-target">
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

	<!-- slider below features box -->
	<div class="card border-bottom">
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#collapseHomeFeaturesBox" aria-expanded="false" aria-controls="collapseHomeFeaturesBox">
			<h6 class="my-2">{{ translate('About Us') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeFeaturesBox" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf

                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="About Us">

					<div class="form-group row gutters-10 border-bottom pb-4 mb-4">
                        <div class="col-lg-6">
                            <input type="hidden" name="types[]" value="about_us_title">
                            <input type="hidden" name="types[]" value="about_us_description">
                            <input type="hidden" name="types[]" value="about_read_more">
                            <label class="col-form-label">{{ translate('About Us Title') }}</label>
                            <input type="text" class="form-control" name="about_us_title" value="{{ get_setting('about_us_title') }}">
                            <label>{{ translate('About Us Description') }}</label>
                            <textarea class="form-control" name="about_us_description" rows="5">{{ get_setting('about_us_description') }}</textarea>
                            <label class="col-form-label">{{ translate('Read More Link') }}</label>
                            <input type="text" class="form-control" placeholder="http:// or https://" name="about_read_more" value="{{ get_setting('about_read_more') }}">
                            <label class="col-form-label">{{ translate('About Us Logo') }}</label>
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="about_logo">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="about_logo" class="selected-files" value="{{ get_setting('about_logo') }}">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>
                        </div>
						<div class="col-lg-6">
							<label class="from-label d-block">{{translate('Side Images')}}(Max 3 & in order)</label>
							<div class="home-features-target">
								<input type="hidden" name="types[]" value="home_features_icons">

								@if (get_setting('home_features_icons') != null)
								@foreach (json_decode(get_setting('home_features_icons'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-4">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_features_icons[]" class="selected-files" value="{{ $value }}">
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
										<div class="col">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_features_icons[]" class="selected-files">
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
									data-target=".home-features-target">
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

	<!-- Popular categories -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapsePopularCategories" aria-expanded="true" aria-controls="collapsePopularCategories">
			<h6 class="my-2">{{ translate('Popular categories') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapsePopularCategories" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf

                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="Popular categories">

					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select categories')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_popular_categories">
							<select name="home_popular_categories[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_popular_categories') }}" data-container="body">
								@foreach (\App\Models\Category::where('level',0)->get() as $key => $category)
									<option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
									@foreach ($category->childrenCategories as $childCategory)
										@include('backend.inc.child_category', ['child_category' => $childCategory])
									@endforeach
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

    <!-- Automotive Oil categories -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseAutomotiveOilCategories" aria-expanded="true" aria-controls="collapseAutomotiveOilCategories">
			<h6 class="my-2">{{ translate('Automotive Oil categories') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseAutomotiveOilCategories" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf

                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="Automotive Oil categories">

					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select categories')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_automotive_oil_categories">
							<select name="home_automotive_oil_categories[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_automotive_oil_categories') }}" data-container="body">
								@foreach (\App\Models\Category::where('parent_id','126')->get() as $key => $category)
									<option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
									@foreach ($category->childrenCategories as $childCategory)
										@include('backend.inc.child_category', ['child_category' => $childCategory])
									@endforeach
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
     <!--Industrial Oil categories -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseIndustrialOilCategories" aria-expanded="true" aria-controls="collapseIndustrialOilCategories">
			<h6 class="my-2">{{ translate('Industrial Oil categories') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseIndustrialOilCategories" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf

                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="Industrial Oil categories">

					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select categories')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_industrial_oil_categories">
							<select name="home_industrial_oil_categories[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_industrial_oil_categories') }}" data-container="body">
								@foreach (\App\Models\Category::where('parent_id','127')->get() as $key => $category)
									<option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
									@foreach ($category->childrenCategories as $childCategory)
										@include('backend.inc.child_category', ['child_category' => $childCategory])
									@endforeach
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
     <!--Greases categories -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseGreasesCategories" aria-expanded="true" aria-controls="collapseGreasesCategories">
			<h6 class="my-2">{{ translate('Greases categories') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseGreasesCategories" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf

                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="Greases categories">

					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select categories')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_greases_categories">
							<select name="home_greases_categories[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_greases_categories') }}" data-container="body">
								@foreach (\App\Models\Category::where('parent_id','128')->get() as $key => $category)
									<option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
									@foreach ($category->childrenCategories as $childCategory)
										@include('backend.inc.child_category', ['child_category' => $childCategory])
									@endforeach
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Home banner section 1 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeBannerOne" aria-expanded="true" aria-controls="collapseHomeBannerOne">
			<h6 class="my-2">{{ translate('Home banner section 1') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeBannerOne" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="Home banner section 1">

					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('Banner image & link')}}</label>
							{{-- <small>{{ translate('Recommended size').' 1300x145' }}</small> --}}
						</div>
						<div class="col-lg-9">
							<div class="home-banner-1-target">
								<input type="hidden" name="types[]" value="home_banner_1_images">
								<input type="hidden" name="types[]" value="home_banner_1_links">
								@if (get_setting('home_banner_1_images') != null)
								@foreach (json_decode(get_setting('home_banner_1_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_banner_1_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_1_links[]" value="{{ json_decode(get_setting('home_banner_1_links'),true)[$key] }}" class="form-control">
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
													<input type="hidden" name="home_banner_1_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_1_links[]" class="form-control">
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

	<!-- Product section 1 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseProductSectionOne" aria-expanded="true" aria-controls="collapseProductSectionOne">
			<h6 class="my-2">{{ translate('Product section 1') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseProductSectionOne" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="Product section 1">

					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_1_title">
							<input type="text" placeholder="" name="home_product_section_1_title" value="{{ get_setting('home_product_section_1_title') }}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select product')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_product_section_1_products">
							<select name="home_product_section_1_products[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_product_section_1_products') }}" data-container="body">
								@foreach ($all_products as $key => $product)
									<option value="{{ $product->id }}">{{ $product->getTranslation('name') }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- brand section 1 --}}
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseBrandSectionOne" aria-expanded="true" aria-controls="collapseBrandSectionOne">
			<h6 class="my-2">{{ translate('Brand section 1') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseBrandSectionOne" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf

                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="Brand section 1">

					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_brand_section_1_title">
							<input type="text" placeholder="" name="home_brand_section_1_title" value="{{ get_setting('home_brand_section_1_title') }}" class="form-control">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select brand')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_brand_section_1_brands">
							<select name="home_brand_section_1_brands[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_brand_section_1_brands') }}" data-container="body">
								@foreach ($all_brands as $key => $brand)
									<option value="{{ $brand->id }}">{{ $brand->getTranslation('name') }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
    {{-- brand section 2 --}}
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseBrandSectionTwo" aria-expanded="true" aria-controls="collapseBrandSectionTwo">
			<h6 class="my-2">{{ translate('Brand section 2') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseBrandSectionTwo" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf

                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="Brand section 2">

					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Section title')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_brand_section_2_title">
							<input type="text" placeholder="" name="home_brand_section_2_title" value="{{ get_setting('home_brand_section_2_title') }}" class="form-control">
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Section subtitle')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_brand_section_2_subtitle">
                            <textarea class="form-control" name="home_brand_section_2_subtitle" rows="5">{{ get_setting('home_brand_section_2_subtitle') }}
                            </textarea>
						</div>
					</div>
                    <div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Brands Image')}}</label>
						<div class="col-md-9">
                            <input type="hidden" name="types[]" value="brands_image">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="brands_image" class="selected-files" value="{{ get_setting('brands_image') }}">
                            </div>
                            <div class="file-preview box sm"></div>
						</div>
					</div>


					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Home banner section 2 -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeBannerTwo" aria-expanded="true" aria-controls="collapseHomeBannerTwo">
			<h6 class="my-2">{{ translate('Home banner section 2') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeBannerTwo" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="Home banner section 2">

					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('Banner image & link')}}</label>
							{{-- <small>{{ translate('Recommended size').' 640x145' }}</small> --}}
						</div>
						<div class="col-lg-9">
							<div class="home-banner-2-target">
								<input type="hidden" name="types[]" value="home_banner_2_images">
								<input type="hidden" name="types[]" value="home_banner_2_links">
								@if (get_setting('home_banner_2_images') != null)
								@foreach (json_decode(get_setting('home_banner_2_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="home_banner_2_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_2_links[]" value="{{ json_decode(get_setting('home_banner_2_links'),true)[$key] }}" class="form-control">
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
													<input type="hidden" name="home_banner_2_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="home_banner_2_links[]" class="form-control">
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-banner-2-target">
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

	{{-- home categories section --}}
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeCategories" aria-expanded="true" aria-controls="collapseHomeCategories">
			<h6 class="my-2">{{ translate('Home Categories') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeCategories" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="home_page_edit" value="Home Categories">

					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Select category')}}</label>
						<div class="col-md-9">
							<input type="hidden" name="types[]" value="home_categories_section">
							<select name="home_categories_section[]" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" data-selected="{{ get_setting('home_categories_section') }}" data-container="body">
								@foreach ($level_0_categories as $key => $category)
									<option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- reviews -->
	<div class="card border-bottom">
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#collapseHomeReviewsBox" aria-expanded="false" aria-controls="collapseHomeReviewsBox">
			<h6 class="my-2">{{ translate('Reviews') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeReviewsBox" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row gutters-10 border-bottom pb-4 mb-4">
						<div class="col-lg-2">
							<label class="from-label d-block">{{translate('Icons, title, sub titles')}}</label>
						</div>
						<div class="col-lg-10">
							<div class="home-reviews-target">
								<input type="hidden" name="types[]" value="home_reviews_images">
								<input type="hidden" name="types[]" value="home_reviews_names">
								<input type="hidden" name="types[]" value="home_reviews_designations">
								<input type="hidden" name="types[]" value="home_reviews_comments">
								@if (get_setting('home_reviews_images') != null)
									@foreach (json_decode(get_setting('home_reviews_images'), true) as $key => $value)
										<div class="row gutters-5 mb-3">
											<div class="col-lg-2">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose Image') }}</div>
														<input type="hidden" name="home_reviews_images[]" class="selected-files" value="{{ $value }}">
													</div>
													<div class="file-preview box sm"></div>
												</div>
											</div>
											<div class="col-lg-2">
												<input type="text" placeholder="{{ translate('Name') }}" name="home_reviews_names[]" class="form-control" value="{{ json_decode(get_setting('home_reviews_names'),true)[$key] }}">
											</div>
											<div class="col-lg-3">
												<input type="text" placeholder="{{ translate('Designations') }}" name="home_reviews_designations[]" class="form-control" value="{{ json_decode(get_setting('home_reviews_designations'),true)[$key] }}">
											</div>
											<div class="col-lg">
												<textarea placeholder="{{ translate('Comment') }}" name="home_reviews_comments[]" class="form-control">{{ json_decode(get_setting('home_reviews_comments'),true)[$key] }}</textarea>
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
										<div class="col-lg-2">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose Image') }}</div>
													<input type="hidden" name="home_reviews_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg-2">
											<input type="text" placeholder="{{ translate('Name') }}" name="home_reviews_names[]" class="form-control">
										</div>
										<div class="col-lg-3">
											<input type="text" placeholder="{{ translate('Designations') }}" name="home_reviews_designations[]" class="form-control">
										</div>
										<div class="col-lg">
											<textarea placeholder="{{ translate('Comment') }}" name="home_reviews_comments[]" class="form-control"></textarea>
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".home-reviews-target">
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
