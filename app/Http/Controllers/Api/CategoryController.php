<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AllCategoryCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryProductCollection;
use App\Http\Resources\ProductSingleCollection;
use App\Http\Resources\ShowcaseCategoryProductCollection;
use App\Http\Resources\ShowcaseProductCollection;
use App\Http\Resources\ShowcaseProductSingleCollection;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShowcaseProduct;

class CategoryController extends Controller
{

    public function index()
    {
        return new AllCategoryCollection(Category::with('categories')->where('level',0)->orderBy('order_level', 'desc')->get());
    }

    public function featured()
    {
        return new CategoryCollection(Category::where('featured', 1)->get());
    }

    public function categories_tree()
    {
        return new CategoryCollection(Category::with(['categories.categories'])->where('level', 0)->get(), true);
    }

    public function child_categories($slug)
    {
        $category = Category::with(['categories.categories'])->where('level', 0)->where('slug', $slug)->get();
        return new CategoryCollection($category, true);
        // dd($category);
    }
    public function child_category_product($slug)
    {
        $category = Category::with(['showcase_products'])->where('slug', $slug)->get();
        // dd($category);
        return new ShowcaseCategoryProductCollection($category, true);

    }
    public function autoMotiveProducts($name)
    {
        $Products = Category::with(['products'])->where('name', 'like', '%'.$name.'%')->get();
        // dd($Products);
        return new CategoryProductCollection($Products, true);

    }
    public function industrialProducts($name)
    {
        $Products = Category::with(['products'])->where('name', 'like', '%'.$name.'%')->get();
        // dd($Products);
        return new CategoryProductCollection($Products, true);

    }
    public function greaseProducts($name)
    {
        $Products = Category::with(['products'])->where('name', 'like', '%'.$name.'%')->get();
        // dd($Products);
        return new CategoryProductCollection($Products, true);

    }
    public function category_product($slug)
    {
        $product = filter_products(ShowcaseProduct::query())
            ->where('slug', $slug)
            ->with(['brand','shop'])
            ->first();

        if ($product) {
            return new ShowcaseProductSingleCollection($product);
        } else {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => translate('Product not found')
            ]);
        }

    }
}
