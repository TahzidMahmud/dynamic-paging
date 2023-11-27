@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="text-left mt-2">
                        <h6 class="separator mb-4 text-left"><span
                                class="bg-white pr-3">{{ translate('Questioner Information') }}</span></h6>
                        <p class="text-muted">
                            <strong>{{ translate('Name') }} :</strong>
                            <span class="ml-2">{{ $query->name }}</span>
                        </p>
                        <p class="text-muted"><strong>{{ translate('Email') }} :</strong>
                            <span class="ml-2">
                                {{ $query->email }}
                            </span>
                        </p>
                        <p class="text-muted"><strong>{{ translate('Phone') }} :</strong>
                            <span class="ml-2">
                                {{ $query->phone }}
                            </span>
                        </p>
                        <p class="text-muted"><strong>{{ translate('Date') }} :</strong>
                            <span class="ml-2">
                                {{ $query->created_at }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    {{ translate('Query') }}
                </div>
                <div class="card-body">
                    <p>{{ $query->comment }}</p>
                </div>
            </div>
        </div>
    </div>
        <div class="card">
            <div class="card-header">
                {{ translate('More Queries of this customer') }}
            </div>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Name') }}</th>
                            <th data-breakpoints="lg">{{ translate('Email Address') }}</th>
                            <th data-breakpoints="lg">{{ translate('Phone') }}</th>
                            <th data-breakpoints="lg">{{ translate('Query') }}</th>
                            <th class="text-right" data-breakpoints="lg">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer_queries as $key => $query)
                            <tr>
                                <td>{{ $key + 1 + ($customer_queries->currentPage() - 1) * $customer_queries->perPage() }}</td>
                                <td>{{ $query->name }}</td>
                                <td>{{ $query->email }}</td>
                                <td>{{ $query->phone }}</td>
                                <td>{{ $query->comment }}</td>
                                <td class="text-right">
                                    @can('view_queries')
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="{{ route('customers.query.show', $query->id) }}" title="{{ translate('View') }}">
                                            <i class="las la-eye"></i>
                                        </a>
                                    @endcan
                                    @can('delete_queries')
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('customers.query.destroy', $query->id) }}"
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
                    {{ $customer_queries->appends(request()->input())->links() }}
                </div>
            </div>
    </div>
@endsection
