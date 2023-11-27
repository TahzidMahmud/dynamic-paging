@extends('backend.layouts.app')
@section('content')
@php
	$all_products = \App\Models\Product::where('published',1)->get();
	$all_brands = \App\Models\Brand::all();
	$all_shops = filter_shops(\App\Models\Shop::query())->get();
	$level_0_categories = \App\Models\Category::get();
@endphp
<h6 class="fw-600">{{ translate('About Us Page Settings') }}</h6>
<div class="accordion" id="accordionExample">


	<!-- Main Section -->
	<div class="card border-bottom">
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#collapseMainSectionBox" aria-expanded="false" aria-controls="collapseMainSectionBox">
			<h6 class="my-2">{{ translate('Main Section') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseMainSectionBox" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row gutters-10 border-bottom pb-4 mb-4">
						<div class="col-lg-2">
							<label class="from-label d-block">{{translate('Banner, title, Content')}}</label>
						</div>
						<div class="col-lg-10">
							<div class="main-section-target">
								<input type="hidden" name="types[]" value="main_section_images">
								<input type="hidden" name="types[]" value="main_section_titles">
								<input type="hidden" name="types[]" value="main_section_content">
								@if (get_setting('main_section_images') != null)
									@foreach (json_decode(get_setting('main_section_images'), true) as $key => $value)
										<div class="row gutters-5 mb-3">
											<div class="col-lg-3">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose Image') }}</div>
														<input type="hidden" name="main_section_images[]" class="selected-files" value="{{ $value }}">
													</div>
													<div class="file-preview box sm"></div>
												</div>
											</div>
											<div class="col-lg-4">
												<input type="text" placeholder="{{ translate('Title') }}" name="main_section_titles[]" class="form-control" value="{{ json_decode(get_setting('main_section_titles'),true)[$key] }}">
											</div>
											<div class="col-lg-4">
												<textarea placeholder="{{ translate('Content') }}" name="main_section_content[]" class="form-control">{{ json_decode(get_setting('main_section_content'),true)[$key] }}</textarea>
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
													<input type="hidden" name="main_section_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg-4">
											<input type="text" placeholder="{{ translate('Name') }}" name="main_section_titles[]" class="form-control">
										</div>
										<div class="col-lg-4">
											<textarea placeholder="{{ translate('Content') }}" name="main_section_content[]" class="form-control"></textarea>
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
	<!-- Story Section -->
	{{-- <div class="card border-bottom">
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#collapseStorySectionBox" aria-expanded="false" aria-controls="collapseStorySectionBox">
			<h6 class="my-2">{{ translate('Story Section') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseStorySectionBox" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row gutters-10 border-bottom pb-4 mb-4">
						<div class="col-lg-2">
							<label class="from-label d-block">{{translate('Banner, title, Content')}}</label>
						</div>
						<div class="col-lg-10">
							<div class="story-section-target">
								<input type="hidden" name="types[]" value="story_section_images">
								<input type="hidden" name="types[]" value="story_section_titles">
								<input type="hidden" name="types[]" value="story_section_content">
								@if (get_setting('story_section_images') != null)
									@foreach (json_decode(get_setting('story_section_images'), true) as $key => $value)
										<div class="row gutters-5 mb-3">
											<div class="col-lg-3">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose Image') }}</div>
														<input type="hidden" name="story_section_images[]" class="selected-files" value="{{ $value }}">
													</div>
													<div class="file-preview box sm"></div>
												</div>
											</div>
											<div class="col-lg-4">
												<input type="text" placeholder="{{ translate('Title') }}" name="story_section_titles[]" class="form-control" value="{{ json_decode(get_setting('story_section_titles'),true)[$key] }}">
											</div>
											<div class="col-lg-4">
												<textarea placeholder="{{ translate('Content') }}" name="story_section_content[]" class="form-control">{{ json_decode(get_setting('story_section_content'),true)[$key] }}</textarea>
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
													<input type="hidden" name="story_section_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg-4">
											<input type="text" placeholder="{{ translate('Name') }}" name="story_section_titles[]" class="form-control">
										</div>
										<div class="col-lg-4">
											<textarea placeholder="{{ translate('Content') }}" name="story_section_content[]" class="form-control"></textarea>
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".story-section-target">
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
	</div> --}}

    <!--About Us-->
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
	<!-- Team Section -->
	<div class="card border-bottom">
		<div class="card-header c-pointer" data-toggle="collapse" data-target="#collapseTeamSectionBox" aria-expanded="false" aria-controls="collapseTeamSectionBox">
			<h6 class="my-2">{{ translate('Team Section') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseTeamSectionBox" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row gutters-10 border-bottom pb-4 mb-4">
						<div class="col-lg-2">
							<label class="from-label d-block">{{translate('Banner, title, Content')}}</label>
						</div>
						<div class="col-lg-10">
							<div class="story-section-target">
								<input type="hidden" name="types[]" value="team_section_images">
								<input type="hidden" name="types[]" value="team_section_titles">
								<input type="hidden" name="types[]" value="team_section_content">
								@if (get_setting('team_section_images') != null)
									@foreach (json_decode(get_setting('team_section_images'), true) as $key => $value)
										<div class="row gutters-5 mb-3">
											<div class="col-lg-3">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose Image') }}</div>
														<input type="hidden" name="team_section_images[]" class="selected-files" value="{{ $value }}">
													</div>
													<div class="file-preview box sm"></div>
												</div>
											</div>
											<div class="col-lg-4">
												<input type="text" placeholder="{{ translate('Title') }}" name="team_section_titles[]" class="form-control" value="{{ json_decode(get_setting('team_section_titles'),true)[$key] }}">
											</div>
											<div class="col-lg-4">
												<textarea placeholder="{{ translate('Content') }}" name="team_section_content[]" class="form-control">{{ json_decode(get_setting('team_section_content'),true)[$key] }}</textarea>
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
													<input type="hidden" name="team_section_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg-4">
											<input type="text" placeholder="{{ translate('Name') }}" name="team_section_titles[]" class="form-control">
										</div>
										<div class="col-lg-4">
											<textarea placeholder="{{ translate('Content') }}" name="team_section_content[]" class="form-control"></textarea>
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>'
									data-target=".story-section-target">
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


	<!-- Gallery Section -->
	<div class="card border-bottom">
		<div class="card-header collapsed c-pointer" data-toggle="collapse" data-target="#collapseHomeBannerOne" aria-expanded="true" aria-controls="collapseHomeBannerOne">
			<h6 class="my-2">{{ translate('Gallery Section') }}</h6>
			<i class="las la-angle-down opacity-60 fs-20"></i>
		</div>
		<div id="collapseHomeBannerOne" class="collapse" data-parent="#accordionExample">
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
                    <!-- Please add this hidden input for every new section added to the home page edit and value should be title of the section-->
                    <input type="hidden" name="game_section" value="Gallery Section">

					<div class="form-group row gutters-10">
						<div class="col-lg-3">
							<label class="from-label d-block">{{translate('Banner image & link')}}</label>
							{{-- <small>{{ translate('Recommended size').' 1300x145' }}</small> --}}
						</div>
						<div class="col-lg-9">
							<div class="home-banner-1-target">
								<input type="hidden" name="types[]" value="gallery_section_images">
								<input type="hidden" name="types[]" value="gallery_section_links">
								@if (get_setting('gallery_section_images') != null)
								@foreach (json_decode(get_setting('gallery_section_images'), true) as $key => $value)
									<div class="row">
										<div class="col-lg-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="gallery_section_images[]" class="selected-files" value="{{ $value }}">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="gallery_section_links[]" value="{{ json_decode(get_setting('gallery_section_links'),true)[$key] }}" class="form-control">
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
													<input type="hidden" name="gallery_section_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm"></div>
											</div>
										</div>
										<div class="col-lg">
											<input type="text" placeholder="" name="gallery_section_links[]" class="form-control">
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
