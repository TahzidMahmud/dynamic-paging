@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">{{translate('All Events')}}</h1>
        </div>
        <div class="col text-right">
            <a href="{{ route('event.create') }}" class="btn btn-circle btn-info">
                <span>{{translate('Add New Event')}}</span>
            </a>
        </div>
    </div>
</div>
<br>

<div class="card">
    <form class="" id="sort_blogs" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('All Events') }}</h5>
            </div>

            <div class="col-md-2">
                <div class="form-group mb-0">
                    <input type="text" class="form-control form-control-sm" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type & Enter') }}">
                </div>
            </div>
        </div>
    </form>
        <div class="card-body">
            <table class="table mb-0 aiz-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{translate('Name')}}</th>
                        <th data-breakpoints="lg">{{translate('Banner')}}</th>
                        <th data-breakpoints="lg">{{translate('Description')}}</th>
                        <th data-breakpoints="lg">{{translate('Featured')}}</th>
                        <th class="text-right">{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $key => $event)
                    <tr>
                        <td>
                            {{ ($key+1) + ($events->currentPage() - 1) * $events->perPage() }}
                        </td>
                        <td>
                            {{ $event->name }}
                        </td>
                        <td>
                            <img src="{{ uploaded_asset($event->banner) }}" alt="{{ translate('Banner') }}"
                                    class="h-50px"
                                    onerror="this.onerror=null;this.src='{{ static_asset('/assets/img/placeholder.jpg') }}';">
                        </td>
                        <td>
                            {{ $event->description }}
                        </td>

                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="change_featured(this)" value="{{ $event->id }}" <?php if($event->featured == 1) echo "checked";?>>
                                <span></span>
                            </label>
                        </td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('event.edit', [ 'event'=>$event, 'lang'=> env('DEFAULT_LANGUAGE')]) }}" title="{{ translate('Edit') }}">
                                <i class="las la-pen"></i>
                            </a>

                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('event.destroy', $event->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $events->links() }}
            </div>
        </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')

    <script type="text/javascript">

        function change_featured(el){
            var featured = 0;
            if(el.checked){
                var featured = 1;
            }
            $.post('{{ route('event.change-featured') }}', {_token:'{{ csrf_token() }}', id:el.value, featured:featured}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Change event featured successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

    </script>

@endsection
