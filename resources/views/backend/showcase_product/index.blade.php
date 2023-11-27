@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-4">
                <h1 class="h3">{{ translate('All products') }}</h1>
            </div>
            <div class="col-md-8 text-md-right">
                @can('add_products')
                    <a href="{{ route('showcase-product.create') }}" class="btn btn-primary">
                        <span>{{ translate('Add New Product') }}</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Products') }}</h5>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type & Enter') }}">
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th class="w-40px">#</th>
                        <th class="col-xl-2">{{ translate('Name') }}</th>
                        <th data-breakpoints="md" width="20%">{{ translate('Categories') }}</th>
                        <th data-breakpoints="md">{{ translate('Brand') }}</th>
                        <th data-breakpoints="md">{{ translate('Published') }}</th>
                        <th data-breakpoints="md" class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 + ($products->currentPage() - 1) * $products->perPage() }}</td>
                            <td>
                                <a href="{{ route('product', $product->slug) }}" target="_blank"
                                    class="text-reset d-block">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="Image"
                                            class="size-60px size-xxl-80px mr-2"
                                            onerror="this.onerror=null;this.src='{{ static_asset('/assets/img/placeholder.jpg') }}';" />
                                        <span class="flex-grow-1 minw-0">
                                            <div class=" text-truncate-2 fs-12">
                                                {{ $product->name }}</div>
                                        </span>
                                    </div>
                                </a>
                            </td>
                            <td>
                                @foreach ($product->categories as $category)
                                    <span
                                        class="badge badge-inline badge-md bg-soft-dark mb-1">{{ $category->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if ($product->brand)
                                    <div class="h-50px w-100px d-flex align-items-center justify-content-center">
                                        <img src="{{ uploaded_asset($product->brand->logo) }}"
                                            alt="{{ translate('Brand') }}" class="mw-100 mh-100"
                                            onerror="this.onerror=null;this.src='{{ static_asset('/assets/img/placeholder.jpg') }}';" />
                                    </div>
                                @else
                                    <span>{{ translate('No brand') }}</span>
                                @endif
                            </td>

                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_published(this)" value="{{ $product->id }}" type="checkbox"
                                        @if ($product->published == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </td>

                            <td class="text-right">
                                @can('view_products')
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('showcase-product.show', $product->id) }}" title="{{ translate('View') }}">
                                        <i class="las la-eye"></i>
                                    </a>
                                @endcan
                                @can('edit_products')
                                    <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        href="{{ route('showcase-product.edit', ['id' => $product->id]) }}"
                                        title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                @endcan
                                @can('duplicate_products')
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="{{ route('showcase-product.duplicate', ['id' => $product->id]) }}"
                                        title="{{ translate('Duplicate') }}">
                                        <i class="las la-copy"></i>
                                    </a>
                                @endcan
                                @can('delete_products')
                                    <a href="{{ route('showcase-product.destroy', $product->id) }}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('showcase-product.destroy', $product->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $products->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('backend.inc.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_published(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('showcase-product-product.published') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Published products updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('product.featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Featured products updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
        function update_todays_deal(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('product.todays_deal') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Todays products updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
        function sort_products(el) {
            $('#sort_products').submit();
        }
    </script>
@endsection
