<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductTranslation;
use App\Models\ShopBrand;
use App\Models\ShowcaseProduct;
use App\Utility\CategoryUtility;
use Illuminate\Http\Request;
use Str;

class ShowcaseProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $col_name = null;
        $query = null;
        $sort_search = null;
        $products = ShowcaseProduct::orderBy('created_at', 'desc')->where('shop_id', auth()->user()->shop_id);
        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }

        $products = $products->paginate(15);

        return view('backend.showcase_product.index', compact('products', 'col_name', 'query', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::withCount(['childrenCategories'])->where('level', 0)->get();
        return view('backend.showcase_product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $product                    = new ShowcaseProduct;
        $product->name              = $request->name;
        $product->shop_id           = auth()->user()->shop_id;
        $product->brand_id          = $request->brand_id;
        $product->photos            = $request->photos;
        $product->thumbnail_img     = $request->thumbnail_img;
        $product->technical_sheet   = $request->technical_sheet;
        $product->safty_sheet       = $request->safty_sheet;
        $product->description       = $request->description;
        $product->published         = $request->button == 'publish' ? 1 : 0 ;

        // SEO meta
        $product->meta_title        = (!is_null($request->meta_title)) ? $request->meta_title : $product->name;
        $product->meta_description  = (!is_null($request->meta_description)) ? $request->meta_description : strip_tags($product->description);
        $product->meta_image        = (!is_null($request->meta_image)) ? $request->meta_image : $product->thumbnail_img;
        $product->slug              = Str::slug($request->name, '-') . '-' . strtolower(Str::random(6));

        // tag
        $tags                       = array();
        if ($request->tags != null) {
            foreach (json_decode($request->tags) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags              = implode(',', $tags);

        $product->save();

        // Product Translations
        $product_translation = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $product->id]);
        $product_translation->name = $request->name;
        $product_translation->description = $request->description;
        $product_translation->save();

        // category
        $product->categories()->sync($request->category_ids);

        // shop category ids
        $shop_category_ids = [];
        foreach ($request->category_ids ?? [] as $id) {
            $shop_category_ids[] = CategoryUtility::get_grand_parent_id($id);
        }
        $shop_category_ids =  array_merge(array_filter($shop_category_ids), $product->shop->shop_categories->pluck('category_id')->toArray());
        $product->shop->categories()->sync($shop_category_ids);

        // shop brand
        if ($request->brand_id) {
            ShopBrand::updateOrCreate([
                'shop_id' => $product->shop_id,
                'brand_id' => $request->brand_id,
            ]);
        }

        $product->save();

        flash(translate('Showcase Product has been inserted successfully'))->success();
        return redirect()->route('showcase-product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShowcaseProduct  $showcaseProduct
     * @return \Illuminate\Http\Response
     */
    public function show(ShowcaseProduct $showcaseProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShowcaseProduct  $showcaseProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $product = ShowcaseProduct::findOrFail($id);
        if ($product->shop_id != auth()->user()->shop_id) {
            abort(403);
        }

        $lang = $request->lang;
        $categories = Category::where('level', 0)->get();
        return view('backend.showcase_product.edit', compact('product', 'categories', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShowcaseProduct  $showcaseProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $product                    = ShowcaseProduct::findOrFail($id);
        $oldProduct                 = clone $product;

        if ($product->shop_id != auth()->user()->shop_id) {
            abort(403);
        }

        $product->name          = $request->name;
        $product->description   = $request->description;

        $product->brand_id          = $request->brand_id;
        $product->photos            = $request->photos;
        $product->thumbnail_img     = $request->thumbnail_img;
        $product->published         = $request->status;



        // SEO meta
        $product->meta_title        = (!is_null($request->meta_title)) ? $request->meta_title : $product->name;
        $product->meta_description  = (!is_null($request->meta_description)) ? $request->meta_description : strip_tags($product->description);
        $product->meta_image        = (!is_null($request->meta_image)) ? $request->meta_image : $product->thumbnail_img;
        $product->slug              = (!is_null($request->slug)) ? Str::slug($request->slug, '-') : Str::slug($request->name, '-') . '-' . strtolower(Str::random(5));


        // tag
        $tags                       = array();
        if ($request->tags != null) {
            foreach (json_decode($request->tags) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags              = implode(',', $tags);

        // category
        $product->categories()->sync($request->category_ids);

        // shop category ids
        $shop_category_ids = [];
        foreach ($request->category_ids ?? [] as $id) {
            $shop_category_ids[] = CategoryUtility::get_grand_parent_id($id);
        }
        $shop_category_ids =  array_merge(array_filter($shop_category_ids), $product->shop->shop_categories->pluck('category_id')->toArray());
        $product->shop->categories()->sync($shop_category_ids);

        // shop brand
        if ($request->brand_id) {
            ShopBrand::updateOrCreate([
                'shop_id' => $product->shop_id,
                'brand_id' => $request->brand_id,
            ]);
        }


        $product->save();

        flash(translate('Showcase Product has been updated successfully'))->success();
        return redirect()->route('showcase-product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShowcaseProduct  $showcaseProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = ShowcaseProduct::findOrFail($id);


        if (ShowcaseProduct::destroy($id)) {
            flash(translate('Showcase Product has been deleted successfully'))->success();
            return redirect()->route('showcase-product.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function updatePublished(Request $request)
    {
        $product = ShowcaseProduct::findOrFail($request->id);
        $product->published = $request->status;
        $product->save();

        cache_clear();

        return 1;
    }
}
