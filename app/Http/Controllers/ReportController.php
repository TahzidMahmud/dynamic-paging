<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ReportActionLog;
use App\Models\Product;
use App\Models\User;
use App\Models\Search;
use App\Models\Order;
use App\Models\FlashDeal;
use App\Models\OfferSale;
use App\Models\Offer;
use Auth;
use Excel;
use DB;

use App\Exports\StocksExport;
use App\Exports\BestSellingProductsExport;
use App\Exports\OrdersExport;

use App\Exports\OfferSummarySalesExport;
use App\Exports\OfferDetailSalesExport;


class ReportController extends Controller

{

    public function sale_report(Request $request)
    {
        $date = $request->date;
        $net = 0;
        $profit = 0;
        $items = 0;
        $num_orders = 0;
        $tax = 0;
        $shipping = 0;
        $coupon = 0;
        $orders = Order::query();

        if ($date != null) {
            $orders = $orders->where('delivery_status','delivered')->where('payment_status','paid')->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }

        foreach ($orders->where('delivery_status','delivered')->where('payment_status','paid')->get()  as $key => $order) {
            $net += $order->grand_total;
            $num_orders += 1;
            $coupon += $order->coupon_discount;
            if($order->orderDetails != null){
                $items += $order->orderDetails->count();
                $shipping += $order->shipping_cost;
                $tax += $order->orderDetails->sum('tax');
                $profit += $order->orderDetails->sum('profit');
            }
        }
        if($request->button == 'export'){
            if ($date != null) {
                $orders = $orders->where('delivery_status','delivered')->where('payment_status','paid')->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }
            ReportActionLog::create([
                "user_id"=>auth()->user()->id,
                "action_log"=>"Sales Report",
                "action"=>"Download"
            ]);

            return Excel::download(new OrdersExport($orders->where('delivery_status','delivered')->where('payment_status','paid')->latest()->get()), 'orders.xlsx');
        }

        ReportActionLog::create([
            "user_id"=>auth()->user()->id,
            "action_log"=>"Sales Report",
            "action"=>"View"
        ]);
        $orders=$orders->where('delivery_status','delivered')->where('payment_status','paid')->latest()->get();
        return view('backend.reports.sale_report', compact('date', 'net', 'profit', 'items', 'num_orders', 'tax', 'shipping', 'coupon','orders'));
    }

    public function sale_report_print(Request $request){
        $date = $request->date;
        $orders = Order::query();
        if ($date != null) {
            $orders = $orders->where('delivery_status','delivered')->where('payment_status','paid')->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])))->get();
        }else{
            $orders=$orders->where('delivery_status','delivered')->where('payment_status','paid')->latest()->get();
        }

        ReportActionLog::create([
            "user_id"=>auth()->user()->id,
            "action_log"=>"Sales Report",
            "action"=>"Print"
        ]);
        return view('backend.reports.sales_stat_print', compact('orders'));
    }

    public function stock_report(Request $request)
    {

        $products=Product::orderBy('name', 'asc');
        if (\request('category'))
            {
                $product_ids=\App\Models\ProductCategory::where('category_id',\request('category'))->get()->pluck('product_id')->toArray();
                $products = $products->whereIn('id',$product_ids);

            }

         if(\request('export') == 'export'){

            ReportActionLog::create([
                "user_id"=>auth()->user()->id,
                "action_log"=>"Stock Report",
                "action"=>"Download"
            ]);
             return Excel::download(new StocksExport($products->get()), 'product_stocks.xlsx');
         }

        ReportActionLog::create([
            "user_id"=>auth()->user()->id,
            "action_log"=>"Stock Report",
            "action"=>"View"
        ]);
        $products=$products->paginate(15,['*'],'page', $request['page']);
        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('backend.reports.stock_report', compact('products', 'categories'));
    }

    public function best_selling_product_report(Request $request)
    {

        $products=Product::where('num_of_sale', '>', 0)->orderBy('num_of_sale', 'desc');
        if (\request('category'))
            {
                $product_ids=\App\Models\ProductCategory::where('category_id',\request('category'))->get()->pluck('product_id')->toArray();
                $products = $products->whereIn('id',$product_ids);

            }

         if(\request('export') == 'export'){

            ReportActionLog::create([
                "user_id"=>auth()->user()->id,
                "action_log"=>"Best Selling Product Report",
                "action"=>"Download"
            ]);

             return Excel::download(new BestSellingProductsExport($products->get()), 'best_selling_products_report.xlsx');
         }
        ReportActionLog::create([
            "user_id"=>auth()->user()->id,
            "action_log"=>"Best Selling Product Report",
            "action"=>"View"
        ]);
        $products=$products->paginate(15,['*'],'page', $request['page']);
        // dd($products);
        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('backend.reports.best_selling_products_report', compact('products', 'categories'));
    }

    public function offer_wise_sell(Request $request)
    {
        $offer_id=null;

        $offers = Offer::get(['id','title','start_date','end_date','status'])->toArray();
        $query_stat="SELECT `offer_id`, SUM(`qty_sold` * `price`) as total_sales,SUM(`qty_sold`) as total_products_sold ,`profit` FROM `offer_sales`";
        $query_stat.=" GROUP BY(`offer_id`)";
        if($request->has('offer_id') && $request->offer_id != null){
            $query_stat.="  HAVING `offer_id`=".$request->offer_id;
            $offer_id=$request->offer_id;
        }
        $sales=DB::select($query_stat);
        $sales_array=[];
        foreach ($sales as $sale) {
           $temp=[];
            $temp['offer_id']=$sale->offer_id;
            $temp['total_sales']=$sale->total_sales;
            $temp['total_products_sold']=$sale->total_products_sold;
            $temp['total_profit']=$sale->profit;
            $temp2=array_filter($offers, function($offer) use ($sale) {

                return $offer['id'] == $sale->offer_id;
            });

            $temp['offer_title']=array_values($temp2)[0]['title'];
            $temp['start_date']=array_values($temp2)[0]['start_date'];
            $temp['end_date']=array_values($temp2)[0]['end_date'];
            $temp['status']=array_values($temp2)[0]['status'];

            array_push($sales_array,$temp);
        }
        if($request->button == 'export'){
            ReportActionLog::create([
                "user_id"=>auth()->user()->id,
                "action_log"=>"Offer Wise Sales Summary Report",
                "action"=>"Download"
            ]);
            return Excel::download(new OfferSummarySalesExport($sales_array), 'offer_wise_sales_summary.xlsx');

        }else{
            ReportActionLog::create([
                "user_id"=>auth()->user()->id,
                "action_log"=>"Offer Wise Sales Summary Report",
                "action"=>"View"
            ]);
        }
        return view('backend.reports.offer_wise_sales_report', compact('sales_array','offers','offer_id'));
    }
    public function offer_sale(Request $request,$id)
    {
        $offer=Offer::find($id);
        $data=OfferSale::where('offer_id',$id)->get();
        if($request->button == 'export'){
            ReportActionLog::create([
                "user_id"=>auth()->user()->id,
                "action_log"=>"Offer Details Sales  Report",
                "action"=>"Download"
            ]);
            return Excel::download(new OfferDetailSalesExport($data), 'offer_detail_sales.xlsx');

        }else{
            ReportActionLog::create([
                "user_id"=>auth()->user()->id,
                "action_log"=>"OOffer Details Sales  Report",
                "action"=>"View"
            ]);
        }
        return view('backend.reports.offer_sales', compact('data','offer'));
    }

}
