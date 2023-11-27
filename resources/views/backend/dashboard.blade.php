@extends('backend.layouts.app')

@section('content')
    {{-- @if (env('MAIL_USERNAME') == null && env('MAIL_PASSWORD') == null)
        <div class="">
            <div class="alert alert-danger d-flex align-items-center">
                {{ translate('Please Configure SMTP Setting to work all email sending functionality') }},
                <a class="alert-link ml-2" href="{{ route('smtp_settings.index') }}">{{ translate('Configure Now') }}</a>
            </div>
        </div>
    @endif --}}

    @can('show_dashboard')

        <div class="row">
            <div class="col-xl-3 col-md-6 ">
                <a href="{{ route('product.create') }}">
                    <div class="shadow-xl rounded-lg pt-5 px-4 mb-5 d-flex justify-content-center align-items-center"
                        style="background-color: #FFFFFF;border-radius: 10px;">
                        <div class="pb-5 d-flex flex-column align-items-center justify-content-around">
                            <img src="{{ static_asset("assets/img/plus.svg") }}" alt="">
                            <div class="fw-500 opacity-60 my-2 fs-16">{{ translate('Add New Product') }}</div>
                            <div class="h2 fw-700">{{ \App\Models\Product::query()->count() }}</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('pos.index') }}">
                    <div class="shadow-xl rounded-lg pt-5 px-4 mb-5 d-flex justify-content-center align-items-center"
                    style="background-color: #D52B1E;color:#ffff;border-radius: 10px;">
                    <div class="pb-5 d-flex flex-column align-items-center justify-content-around">
                        <img src="{{ static_asset("assets/img/list_alt.svg") }}" alt="">
                        <div class="fw-500 opacity-100 fs-16 my-2">{{ translate('POS') }}</div>
                        <div class="h2 fw-700">{{ format_price(\App\Models\Order::where('type','POS')->sum('grand_total')) }}</div>
                    </div>
                </div></a>

            </div>
            <div class="col-xl-3 col-md-6">
                <a href="{{  route('orders.index') }}">
                    <div class="shadow-xl rounded-lg pt-5 px-4 mb-5 d-flex justify-content-center align-items-center"
                        style="background-color: #21EA89;color:#ffff;border-radius: 10px;">
                        <div class="pb-5 d-flex flex-column align-items-center justify-content-around">
                            <svg width="41" height="40" viewBox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.33374 6.66699C7.89169 6.66699 7.46775 6.8426 7.15517 7.15517C6.84259 7.46775 6.66699 7.89169 6.66699 8.33374V20.001H15.0007C15.4428 20.001 15.8667 20.1766 16.1793 20.4892C16.4919 20.8017 16.6675 21.2257 16.6675 21.6677V21.8344C16.6675 23.5845 18.0842 25.0012 19.8343 25.0012H20.1676C21.0075 25.0012 21.813 24.6676 22.4069 24.0737C23.0008 23.4798 23.3345 22.6743 23.3345 21.8344V21.6677C23.3345 21.2257 23.5101 20.8017 23.8226 20.4892C24.1352 20.1766 24.5592 20.001 25.0012 20.001H33.3349V8.33374C33.3349 7.89169 33.1593 7.46775 32.8468 7.15517C32.5342 6.8426 32.1103 6.66699 31.6682 6.66699H8.33374ZM33.3349 23.3345H26.4946C26.1563 24.7582 25.3478 26.0262 24.1997 26.9336C23.0516 27.841 21.631 28.3346 20.1676 28.3347H19.8343C18.3709 28.3346 16.9504 27.841 15.8023 26.9336C14.6541 26.0262 13.8456 24.7582 13.5073 23.3345H6.66699V31.6682C6.66699 32.1103 6.84259 32.5342 7.15517 32.8468C7.46775 33.1594 7.89169 33.335 8.33374 33.335H31.6682C32.1103 33.335 32.5342 33.1594 32.8468 32.8468C33.1593 32.5342 33.3349 32.1103 33.3349 31.6682V23.3345ZM3.3335 8.33374C3.3335 7.00759 3.86031 5.73576 4.79803 4.79803C5.73576 3.86031 7.00759 3.3335 8.33374 3.3335H31.6682C32.9943 3.3335 34.2662 3.86031 35.2039 4.79803C36.1416 5.73576 36.6684 7.00759 36.6684 8.33374V31.6682C36.6684 32.9944 36.1416 34.2662 35.2039 35.2039C34.2662 36.1416 32.9943 36.6685 31.6682 36.6685H8.33374C7.00759 36.6685 5.73576 36.1416 4.79803 35.2039C3.86031 34.2662 3.3335 32.9944 3.3335 31.6682V8.33374Z" fill="white"/>
                                </svg>

                            <div class="fw-500 opacity-100 fs-16 my-2">{{ translate('New Orders !') }}</div>
                            <div class="h2 fw-700">{{ \App\Models\Order::where('delivery_status','order_placed')->count() }}</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-md-6">
                <a href="{{ route('sale_report.index') }}">
                    <div class="shadow-xl rounded-lg pt-5 px-4 mb-5 d-flex justify-content-center align-items-center pb-1"
                        style="background-color: #EABD3B;color:#ffff;border-radius: 10px;">
                        <div class="pb-5 d-flex flex-column align-items-center justify-content-around">
                            <img src="{{ static_asset("assets/img/vector.svg") }}" alt="">
                            <div class="fw-500 opacity-100 my-2 fs-16">{{ translate('Sales Report') }}</div>
                            <div class="h2 fw-700">{{ format_price(\App\Models\Order::where('delivery_status', '!=', 'cancelled')->sum('grand_total'), true) }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-md-6 ">
                <a href="{{ route('product.create') }}">
                    <div class="shadow-xl rounded-lg py-5 px-4 mb-5"
                        style="background-color: #FFFFFF;border-radius: 10px;">
                            <div class="h5 fw-700 text-left text-dark">Total Order</div>
                            <div class="row d-flex align-items-center px-3">
                                <div class="col-6 d-flex justify-content-start align-items-center">
                                    <img src="{{ static_asset('assets/img/1stcardbar.svg') }}" alt="">
                                </div>
                                <div class="col-6 d-flex justify-content-end align-items-center">
                                    <div class="h3 fw-700 text-left " style="color: #20D854;">{{ \App\Models\CombinedOrder::query()->count() }}</div>
                                </div>

                            </div>

                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 ">
                <a href="{{ route('product.create') }}">
                    <div class="shadow-xl rounded-lg py-5 px-4 mb-5"
                        style="background-color: #FFFFFF;border-radius: 10px;">
                            <div class="h5 fw-700 text-left text-dark">Total Sales</div>
                            <div class="row d-flex align-items-center px-3">
                                <div class="col-6 d-flex justify-content-start align-items-center">
                                    <img src="{{ static_asset('assets/img/2ndcardbar.svg') }}" alt="">
                                </div>
                                <div class="col-6 d-flex justify-content-end align-items-center">
                                    <div class="h3 fw-700 text-left " style="color: #9747FF;">{{ format_price(\App\Models\CombinedOrder::query()->sum('grand_total'))}}</div>
                                </div>

                            </div>

                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 ">
                <a href="{{ route('product.create') }}">
                    <div class="shadow-xl rounded-lg py-5 px-4 mb-5"
                        style="background-color: #FFFFFF;border-radius: 10px;">
                            <div class="h5 fw-700 text-left text-dark">Total Profit</div>
                            <div class="row d-flex align-items-center px-3">
                                <div class="col-6 d-flex justify-content-start align-items-center">
                                    <img src="{{ static_asset('assets/img/dollar.svg') }}" alt="">
                                </div>
                                <div class="col-6 d-flex justify-content-end align-items-center">
                                    <div class="h3 fw-700 text-left " style="color: #469BEA;">{{ format_price(\App\Models\OrderDetail::query()->sum('profit')) }}</div>
                                </div>

                            </div>

                    </div>
                </a>
            </div>
        </div>
        {{-- 2nd card row  --}}
        <div class="row">
            <div class="col-xl-4 col-md-6 ">
                <a href="{{ route('product.create') }}">
                    <div class="shadow-xl rounded-lg py-5 px-4 mb-5"
                        style="background-color: #FFFFFF;border-radius: 10px;">
                            <div class="h5 fw-700 text-left text-dark">Total Customers</div>
                            <div class="row d-flex align-items-center px-3">
                                <div class="col-6 d-flex justify-content-start align-items-center">
                                    <img src="{{ static_asset('assets/img/user.svg') }}" alt="">
                                </div>
                                <div class="col-6 d-flex justify-content-end align-items-center">
                                    <div class="h3 fw-700 text-left " style="color: #FF5B5B;">{{ \App\Models\User::where('user_type','customer')->count() }}</div>
                                </div>
                            </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 ">
                <a href="{{ route('product.create') }}">
                    <div class="shadow-xl rounded-lg py-5 px-4 mb-5"
                        style="background-color: #FFFFFF;border-radius: 10px;">
                            <div class="h5 fw-700 text-left text-dark">Total Products</div>
                            <div class="row d-flex align-items-center px-3">
                                <div class="col-6 d-flex justify-content-start align-items-center">
                                    <img src="{{ static_asset('assets/img/box.svg') }}" alt="">
                                </div>
                                <div class="col-6 d-flex justify-content-end align-items-center">
                                    <div class="h3 fw-700 text-left " style="color: #EABD3B;">{{ \App\Models\Product::query()->count()}}</div>
                                </div>

                            </div>

                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 ">
                <a href="{{ route('product.create') }}">
                    <div class="shadow-xl rounded-lg py-5 px-4 mb-5"
                        style="background-color: #FFFFFF;border-radius: 10px;">
                            <div class="h5 fw-700 text-left text-dark">Total Sales</div>
                            <div class="row d-flex align-items-center px-3">
                                <div class="col-6 d-flex justify-content-start align-items-center">
                                    <img src="{{ static_asset('assets/img/last.svg') }}" alt="">
                                </div>
                                <div class="col-6 d-flex justify-content-end align-items-center">
                                    <div class="h3 fw-700 text-left " style="color: #1BD3A7;">{{ format_price(\App\Models\CombinedOrder::whereDate('created_at', date('Y-m-d'))->sum('grand_total')) }}</div>
                                </div>

                            </div>

                    </div>
                </a>
            </div>
        </div>
        {{-- greph row  --}}
        <div class="row mb-3">
            <div class="col-lg-12 col-12 px-4">
                <div class="border rounded-lg p-4 mb-4 ">
                    <div class="fs-16 fw-700 mb-4">{{ translate('Sales stat') }}</div>
                    <canvas id="graph-2" class="w-100" height="300"></canvas>
                </div>
            </div>

        </div>

        <div class="col-12">
            <div class="card" style="border-radius: .9rem;">
              <div class="row pt-4 px-4">
                <div class="col-6">
                    <div class="text-left">
                        <h4><strong>Recent Orders</strong></h4>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <a  href="javascript:void(0)" onclick="print_invoice('{{ route('sale_report.print') }}')" class="btn btn-icon btn-circle btn-lg my-2 mx-2"><img src="{{ static_asset('assets/img/print.svg') }}" alt=""></a>
                       </div>
                </div>
              </div>
               <div class="card-body " >
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-violate">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Order Code</th>
                                <th scope="col">Product</th>
                                <th scope="col">Variant</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Tax</th>
                                <th scope="col">Shipping</th>
                                <th scope="col">Profit</th>

                            </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\Order::query()->latest()->take(15)->get() as $key=>$order)
                                    @foreach ($order->orderDetails as $orderDetail)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                                <td class="text-violate">{{ $order->combined_order->code }}</td>
                                                <td>
                                                    @if ($orderDetail->product != null)
                                                        {{ $orderDetail->product->name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $name = '';
                                                        if(isset($orderDetail->variation['code'])){

                                                            $code_array = array_filter(explode('/', $orderDetail->variation->code));
                                                            $lstKey = array_key_last($code_array);

                                                            foreach ($code_array as $j => $comb) {
                                                                $comb = explode(':', $comb);

                                                                $option_name = \App\Models\Attribute::find($comb[0])->getTranslation('name');
                                                                $choice_name = \App\Models\AttributeValue::find($comb[1])->getTranslation('name');

                                                                $name .= $option_name . ': ' . $choice_name;

                                                                if ($lstKey != $j) {
                                                                    $name .= ' / ';
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                        {{ $name }}

                                                </td>
                                                <td>{{ $orderDetail->quantity }}</td>
                                                <td>{{ $orderDetail->price }}</td>
                                                <td>{{ $orderDetail->tax }}</td>
                                                <td>{{ $order->shipping_cost }}</td>

                                                @if( $orderDetail->profit==null)
                                                    <td>0</td>
                                                @else
                                                    <td>{{ $orderDetail->profit }}</td>
                                                @endif
                                            </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
               </div>
            </div>
        </div>


    @endcan

@endsection

@section('script')
<script type="text/javascript">
    function print_invoice(url){
         var h = $(window).height();
         var w = $(window).width();
         window.open( url, '_blank', 'height='+h+',width='+w+',scrollbars=yes,status=no' );
     }
 </script>
    <script>
        let draw = Chart.controllers.line.prototype.draw;
        Chart.controllers.line = Chart.controllers.line.extend({
            draw: function() {
                draw.apply(this, arguments);
                let ctx = this.chart.chart.ctx;
                let _stroke = ctx.stroke;
                ctx.stroke = function() {
                    ctx.save();
                    ctx.shadowColor = 'rgb(0, 0, 0, .16)';
                    ctx.shadowBlur = 3;
                    ctx.shadowOffsetX = 0;
                    ctx.shadowOffsetY = 3;
                    _stroke.apply(this, arguments)
                    ctx.restore();
                }
            }
        });

        AIZ.plugins.chart('#graph-1', {
            type: 'line',
            data: {
                labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
                datasets: [{
                    data: [
                        {{ $cached_graph_data['sales_number_per_month'][1] }},
                        {{ $cached_graph_data['sales_number_per_month'][2] }},
                        {{ $cached_graph_data['sales_number_per_month'][3] }},
                        {{ $cached_graph_data['sales_number_per_month'][4] }},
                        {{ $cached_graph_data['sales_number_per_month'][5] }},
                        {{ $cached_graph_data['sales_number_per_month'][6] }},
                        {{ $cached_graph_data['sales_number_per_month'][7] }},
                        {{ $cached_graph_data['sales_number_per_month'][8] }},
                        {{ $cached_graph_data['sales_number_per_month'][9] }},
                        {{ $cached_graph_data['sales_number_per_month'][10] }},
                        {{ $cached_graph_data['sales_number_per_month'][11] }},
                        {{ $cached_graph_data['sales_number_per_month'][12] }}
                    ],
                    fill: false,
                    borderColor: "rgb(221, 65, 36)",
                    borderWidth: 4,
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        display: false,
                        ticks: {
                            min: 0,
                            max: 150,
                        },
                    }],
                    xAxes: [{
                        display: false,
                    }],
                    ticks: {
                        min: 0
                    },
                },
            }
        })

        AIZ.plugins.chart('#graph-2', {
            type: 'bar',
            data: {
                labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
                datasets: [{
                    label: '{{ translate('Sales ($)') }}',
                    data: [
                        {{ $cached_graph_data['sales_amount_per_month'][1] }},
                        {{ $cached_graph_data['sales_amount_per_month'][2] }},
                        {{ $cached_graph_data['sales_amount_per_month'][3] }},
                        {{ $cached_graph_data['sales_amount_per_month'][4] }},
                        {{ $cached_graph_data['sales_amount_per_month'][5] }},
                        {{ $cached_graph_data['sales_amount_per_month'][6] }},
                        {{ $cached_graph_data['sales_amount_per_month'][7] }},
                        {{ $cached_graph_data['sales_amount_per_month'][8] }},
                        {{ $cached_graph_data['sales_amount_per_month'][9] }},
                        {{ $cached_graph_data['sales_amount_per_month'][10] }},
                        {{ $cached_graph_data['sales_amount_per_month'][11] }},
                        {{ $cached_graph_data['sales_amount_per_month'][12] }}
                    ],
                    backgroundColor: '#469BEA',
                    borderColor: '#469BEA',
                    borderWidth: 10,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: '#fff',
                            zeroLineColor: '#f2f3f8'
                        },
                        ticks: {
                            fontColor: "#8b8b8b",
                            fontFamily: 'Roboto',
                            fontSize: 10,
                            beginAtZero: true
                        },
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#fff'
                        },
                        ticks: {
                            fontColor: "#8b8b8b",
                            fontFamily: 'Roboto',
                            fontSize: 10
                        },
                        barThickness: 50,
                        barPercentage: .5,
                        categoryPercentage: .5,
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
        AIZ.plugins.chart('#graph-3', {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($root_categories as $key => $category)
                        '{{ $category->getTranslation('name') }}',
                    @endforeach
                ],
                datasets: [{
                    label: '{{ translate('Sales ($)') }}',
                    data: [
                        {{ $cached_graph_data['sales_amount_string'] }}
                    ],
                    backgroundColor: '#91A8D0',
                    borderColor: '#91A8D0',
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: '#fff',
                            zeroLineColor: '#f2f3f8'
                        },
                        ticks: {
                            fontColor: "#8b8b8b",
                            fontFamily: 'Roboto',
                            fontSize: 10,
                            beginAtZero: true
                        },
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#fff'
                        },
                        ticks: {
                            fontColor: "#8b8b8b",
                            fontFamily: 'Roboto',
                            fontSize: 10
                        },
                        barThickness: 20,
                        barPercentage: .5,
                        categoryPercentage: .5,
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>
@endsection
