@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3">{{ translate('Website Header') }}</h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-8 mx-auto">
		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Header Setting') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="border-bottom mb-3">
						<div class="form-group row">
		                    <label class="col-md-3 col-from-label">{{ translate('Topbar Banner') }}</label>
							<div class="col-md-8">
			                    <div class=" input-group " data-toggle="aizuploader" data-type="image">
			                        <div class="input-group-prepend">
			                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
			                        </div>
			                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
									<input type="hidden" name="types[]" value="topbar_banner">
			                        <input type="hidden" name="topbar_banner" class="selected-files" value="{{ get_setting('topbar_banner') }}">
			                    </div>
			                    <div class="file-preview"></div>
							</div>
		                </div>
		                <div class="form-group row">
							<label class="col-md-3 col-from-label">{{translate('Topbar Banner Link')}}</label>
							<div class="col-md-8">
								<div class="">
									<input type="hidden" name="types[]" value="topbar_banner_link">
									<input type="text" class="form-control" placeholder="" name="topbar_banner_link" value="{{ get_setting('topbar_banner_link') }}">
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{ translate('Play Store Link') }}</label>
							<div class="col-md-8">
								<input type="hidden" name="types[]" value="topbar_play_store_link">
								<input type="text" class="form-control" placeholder="" name="topbar_play_store_link" value="{{ get_setting('topbar_play_store_link') }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{ translate('App Store Link') }}</label>
							<div class="col-md-8">
								<input type="hidden" name="types[]" value="topbar_app_store_link">
								<input type="text" class="form-control" placeholder="" name="topbar_app_store_link" value="{{ get_setting('topbar_app_store_link') }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-from-label">{{ translate('Helpline number') }}</label>
							<div class="col-md-8">
								<input type="hidden" name="types[]" value="topbar_helpline_number">
								<input type="text" class="form-control" placeholder="+01 112 352 566" name="topbar_helpline_number" value="{{ get_setting('topbar_helpline_number') }}">
							</div>
						</div>
					</div>
					<div class="form-group row">
	                    <label class="col-md-3 col-from-label">{{ translate('Header Logo') }}</label>
						<div class="col-md-8">
		                    <div class=" input-group " data-toggle="aizuploader" data-type="image">
		                        <div class="input-group-prepend">
		                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
		                        </div>
		                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
								<input type="hidden" name="types[]" value="header_logo">
		                        <input type="hidden" name="header_logo" class="selected-files" value="{{ get_setting('header_logo') }}">
		                    </div>
		                    <div class="file-preview"></div>
						</div>
	                </div>
					<div class="">
						<label class="">{{translate('Header Nav Menu')}}</label>
						<div class="header-nav-menu">
							<input type="hidden" name="types[]" value="header_menu_labels">
							<input type="hidden" name="types[]" value="header_menu_links">
                            <input type="hidden" name="types[]" value="sub_menu_labels">
                            <input type="hidden" name="types[]" value="sub_menu_links">
							@if (get_setting('header_menu_labels') != null)
								@foreach (json_decode( get_setting('header_menu_labels'), true) as $key => $value)
									<div class="row gutters-5">
										<div class="col-4">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="{{translate('Label')}}" name="header_menu_labels[]" value="{{ $value }}">
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="" name="header_menu_links[]" value="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}">
											</div>
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>

                                    <div id="sub-menu-{{ $key }}" class="ml-4">
                                        <h6>Sub-menu</h6>

                                       @if(get_setting('sub_menu_labels')!=null)
                                       @foreach (json_decode( get_setting('sub_menu_labels'), true) as $k => $v)
                                            @if ($k==$value)

                                                    @foreach ($v as $ke =>$val )
                                                        <div class="row gutters-5">
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" placeholder="{{translate('Label')}}" value="{{ $val }}" name="sub_menu_labels[{{ $value }}][]">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" value="{{ json_decode( get_setting('sub_menu_links'), true)[$value][$ke] }}" placeholder="{{ translate('Link with') }} http:// {{ translate('or') }} https://" name="sub_menu_links[{{ $value }}][]">
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
                                            @endforeach
                                       @endif
                                    </div>


                                        <button class="btn btn-success btn-sm" type="button"  data-toggle="add-more"
                                        data-content='<div class="row gutters-5">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="{{translate('Label')}}" name="sub_menu_labels[{{ $value }}][]">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="" name="sub_menu_links[{{ $value }}][]">
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                                    <i class="las la-times"></i>
                                                </button>
                                            </div>

                                        </div>

                                        '
                                        data-target="#sub-menu-{{ $key }}">Add sub-menu</button><br><br>
								@endforeach
							@endif
						</div>
						<button
							type="button"
							class="btn btn-soft-secondary btn-sm"
							data-toggle="add-more"
							data-content='<div class="row gutters-5">
								<div class="col-4">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="{{translate('Label')}}" name="header_menu_labels[]">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="" name="header_menu_links[]">
									</div>
								</div>
								<div class="col-auto">
									<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
										<i class="las la-times"></i>
									</button>
								</div>
							</div>'
							data-target=".header-nav-menu">
							{{ translate('Add New') }}
						</button>
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
