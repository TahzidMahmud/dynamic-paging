<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AllCategoryCollection;
use App\Http\Resources\BlogCollection;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\HomeCategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SettingsCollection;
use App\Http\Resources\ShopCollection;
use App\Models\AppSettings;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Cache;

class SettingController extends Controller
{
    public function index()
    {
        // return new SettingsCollection(AppSettings::all());
    }
    public function home_setting($section)
    {
        switch ($section) {
            case 'sliders':
                $data = Cache::remember('sliders', 86400, function () {
                    return [
                        'one' => get_setting('home_slider_1_images')
                                    ? banner_array_generate(get_setting('home_slider_1_images'),get_setting('home_slider_1_links'))
                                    : [],
                        'three' => get_setting('home_slider_3_images')
                                    ? banner_array_generate(get_setting('home_slider_3_images'),get_setting('home_slider_3_links'))
                                    : [],
                        'four' => get_setting('home_slider_4_images')
                                    ? banner_array_generate(get_setting('home_slider_4_images'),get_setting('home_slider_4_links'))
                                    : [],
                        ];
                });
                break;

            case 'features_box':
                $data = Cache::remember('features_box', 86400, function () {
                    return dynamic_array_generate([
                        'images' => get_setting('home_features_icons'),
                        'titles' => get_setting('home_features_titles'),
                        'subtitles' => get_setting('home_features_subtitles'),
                    ]);
                });
                break;
            case 'about_us':

                $data = Cache::remember('about_us', 86400, function () {
                    return [
                        'title' => get_setting('about_us_title'),
                        'subtitle' => get_setting('about_us_description'),
                        'more_link'=> get_setting('about_read_more'),
                        'about_log'=> api_assets(get_setting('about_logo')),
                        'about_image'=> api_assets_array(json_decode(get_setting('home_features_icons'), true)),
                    ];
                });
                break;
            case  'home_auto_motive_oil':
                $data = Cache::remember('auto_motive_oil', 86400, function () {
                    $ids=json_decode(get_setting('home_automotive_oil_categories'), true);
                    $parent_category = Category::where('id', '126')->first(['id', 'name', 'slug','big_banner','image']);
                    $parent['id'] = $parent_category->id;
                    $parent['name'] = $parent_category->name;
                    $parent['slug'] = $parent_category->slug;
                    $parent['big_banner'] = api_asset($parent_category->big_banner);
                    $parent['image'] = api_asset($parent_category->image);
                    $child_categories=Category::whereIn('id',$ids)->get(['id','name','slug']);
                    $chils_cat_products=[];
                    foreach ($ids as $id){
                        $products=new ProductCollection(Category::find($id)->products()->latest()->take(8)->get());
                        if($products->count()>0){
                            array_push($chils_cat_products,$products);
                        }
                    }
                    return [
                        'parent_category' => $parent,
                        'child_categories' => $child_categories,
                        'chils_cat_products'=>$chils_cat_products,
                    ];
                });
                break;
                case  'home_industrial_oil_categories':
                    $data = Cache::remember('home_industrial_oil_categories', 86400, function () {
                        $ids=json_decode(get_setting('home_industrial_oil_categories'), true);
                        $parent_category = Category::where('id', '127')->first(['id', 'name', 'slug','big_banner','image']);
                        $parent['id'] = $parent_category->id;
                        $parent['name'] = $parent_category->name;
                        $parent['slug'] = $parent_category->slug;
                        $parent['big_banner'] = api_asset($parent_category->big_banner);
                        $parent['image'] = api_asset($parent_category->image);
                        $child_categories=Category::whereIn('id',$ids)->orderBy('id','desc')->get(['id','name','slug']);
                        $chils_cat_products=[];
                        foreach ($ids as $id){
                            $products=new ProductCollection(Category::find($id)->products()->latest()->take(8)->get());
                            if($products->count()>0){
                                array_push($chils_cat_products,$products);
                            }
                        }
                        return [
                            'parent_category' => $parent,
                            'child_categories' => $child_categories,
                            'chils_cat_products'=>$chils_cat_products,
                        ];
                    });
                    break;
                    case  'home_greases_categories':
                        $data = Cache::remember('home_greases_categories', 86400, function () {
                            $ids=json_decode(get_setting('home_greases_categories'), true);
                            $parent_category = Category::where('id', '128')->first(['id', 'name', 'slug','big_banner','image']);
                            $parent['id'] = $parent_category->id;
                            $parent['name'] = $parent_category->name;
                            $parent['slug'] = $parent_category->slug;
                            $parent['big_banner'] = api_asset($parent_category->big_banner);
                            $parent['image'] = api_asset($parent_category->image);
                            $child_categories=Category::whereIn('id',$ids)->get(['id','name','slug']);
                            $chils_cat_products=[];
                            foreach ($ids as $id){
                                $products=new ProductCollection(Category::find($id)->products()->latest()->take(8)->get());
                                if($products->count()>0){
                                    array_push($chils_cat_products,$products);
                                }
                            }
                            return [
                                'parent_category' => $parent,
                                'child_categories' => $child_categories,
                                'chils_cat_products'=>$chils_cat_products,

                            ];
                        });
                        break;
            case 'brand_section_two':
                $data = Cache::remember('brand_section_two', 86400, function () {
                    return [
                        'title' => get_setting('home_brand_section_2_title'),
                        'subtitle' => get_setting('home_brand_section_2_subtitle'),
                        'brands_image'=> api_asset(get_setting('brands_image')),
                    ];
                    return [
                        'title' => get_setting('home_brand_section_1_title'),
                        'brands' => new BrandCollection($brand_section_1_brands)
                    ];
                });
                break;

            case 'popular_categories':
                $data = Cache::remember('popular_categories', 86400, function () {
                    return get_setting('home_popular_categories')
                            ? new CategoryCollection(Category::whereIn('id', json_decode(get_setting('home_popular_categories')))->get())
                            : [];
                });
                break;

            case 'product_section_one':
                $data = Cache::remember('product_section_one', 86400, function () {
                    $product_section_1_products = get_setting('home_product_section_1_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_1_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_1_title'),
                        'products' => new ProductCollection($product_section_1_products)
                    ];
                });
                break;

            case 'product_section_two':
                $data = Cache::remember('product_section_two', 86400, function () {
                    $product_section_2_products = get_setting('home_product_section_2_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_2_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_2_title'),
                        'products' => new ProductCollection($product_section_2_products)
                    ];
                });
                break;

            case 'product_section_three':
                $data = Cache::remember('product_section_three', 86400, function () {
                    $product_section_3_products = get_setting('home_product_section_3_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_3_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_3_title'),
                        'banner' => [
                            'img' => api_asset(get_setting('home_product_section_3_banner_img')),
                            'link' => get_setting('home_product_section_3_banner_link')
                        ],
                        'products' => new ProductCollection($product_section_3_products)
                    ];
                });
                break;

            case 'product_section_four':
                $data = Cache::remember('product_section_four', 86400, function () {
                    $product_section_4_products = get_setting('home_product_section_4_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_4_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_4_title'),
                        'products' => new ProductCollection($product_section_4_products)
                    ];
                });
                break;

            case 'product_section_five':
                $data = Cache::remember('product_section_five', 86400, function () {
                    $product_section_5_products = get_setting('home_product_section_5_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_5_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_5_title'),
                        'products' => new ProductCollection($product_section_5_products)
                    ];
                });
                break;

            case 'product_section_six':
                $data = Cache::remember('product_section_six', 86400, function () {
                    $product_section_6_products = get_setting('home_product_section_6_products')
                        ? filter_products(Product::whereIn('id', json_decode(get_setting('home_product_section_6_products'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_product_section_6_title'),
                        'banner' => [
                            'img' => api_asset(get_setting('home_product_section_6_banner_img')),
                            'link' => get_setting('home_product_section_6_banner_link')
                        ],
                        'products' => new ProductCollection($product_section_6_products)
                    ];
                });
                break;

            case 'brand_section_one':
                $data = Cache::remember('brand_section_one', 86400, function () {
                    $brand_section_1_brands = get_setting('home_brand_section_1_brands')
                        ? Brand::whereIn('id', json_decode(get_setting('home_brand_section_1_brands')))->get()
                        : [];
                    return [
                        'title' => get_setting('home_brand_section_1_title'),
                        'brands' => new BrandCollection($brand_section_1_brands)
                    ];
                });
                break;


            case 'banner_section_one':
                $data = get_setting('home_banner_1_images')
                            ? banner_array_generate(get_setting('home_banner_1_images'),get_setting('home_banner_1_links'))
                            : [];
                break;

            case 'banner_section_two':
                $data = get_setting('home_banner_2_images')
                            ? banner_array_generate(get_setting('home_banner_2_images'),get_setting('home_banner_2_links'))
                            : [];
                break;

            case 'banner_section_three':
                $data = get_setting('home_banner_3_images')
                            ? banner_array_generate(get_setting('home_banner_3_images'),get_setting('home_banner_3_links'))
                            : [];
                break;

            case 'banner_section_four':
                $data = get_setting('home_banner_4_images')
                            ? banner_array_generate(get_setting('home_banner_4_images'),get_setting('home_banner_4_links'))
                            : [];
                break;

            case 'home_about_text':
                $data = get_setting('home_about_us');
                break;

            case 'shop_section_one':
                $data = Cache::remember('shop_section_one', 86400, function () {
                    $shop_section_1_shops = get_setting('home_shop_section_1_shops')
                        ? filter_shops(Shop::withCount(['products','reviews'])->whereIn('id', json_decode(get_setting('home_shop_section_1_shops'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_shop_section_1_title'),
                        'shops' => new ShopCollection($shop_section_1_shops, true)
                    ];
                });
                break;

            case 'shop_banner_section_one':
                $data = get_setting('home_shop_banner_1_images')
                            ? banner_array_generate(get_setting('home_shop_banner_1_images'),get_setting('home_shop_banner_1_links'))
                            : [];
                break;

            case 'shop_section_two':
                $data = Cache::remember('shop_section_two', 86400, function () {
                    $shop_section_2_shops = get_setting('home_shop_section_2_shops')
                        ? filter_shops(Shop::withCount(['products','reviews'])->whereIn('id', json_decode(get_setting('home_shop_section_2_shops'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_shop_section_2_title'),
                        'shops' => new ShopCollection($shop_section_2_shops, true)
                    ];
                });
                break;

            case 'shop_banner_section_two':
                $data = get_setting('home_shop_banner_2_images')
                            ? banner_array_generate(get_setting('home_shop_banner_2_images'),get_setting('home_shop_banner_2_links'))
                            : [];
                break;

            case 'shop_section_three':
                $data = Cache::remember('shop_section_three', 86400, function () {
                    $shop_section_3_shops = get_setting('home_shop_section_3_shops')
                        ? filter_shops(Shop::withCount(['products','reviews'])->whereIn('id', json_decode(get_setting('home_shop_section_3_shops'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_shop_section_3_title'),
                        'shops' => new ShopCollection($shop_section_3_shops, true)
                    ];
                });
                break;
            case 'shop_section_four':
                $data = Cache::remember('shop_section_four', 86400, function () {
                    $shop_section_4_shops = get_setting('home_shop_section_4_shops')
                        ? filter_shops(Shop::withCount(['products','reviews'])->whereIn('id', json_decode(get_setting('home_shop_section_4_shops'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_shop_section_4_title'),
                        'shops' => new ShopCollection($shop_section_4_shops, true)
                    ];
                });
                break;
            case 'shop_section_five':
                $data = Cache::remember('shop_section_five', 86400, function () {
                    $shop_section_5_shops = get_setting('home_shop_section_5_shops')
                        ? filter_shops(Shop::withCount(['products','reviews'])->whereIn('id', json_decode(get_setting('home_shop_section_5_shops'))))->get()
                        : [];
                    return [
                        'title' => get_setting('home_shop_section_5_title'),
                        'shops' => new ShopCollection($shop_section_5_shops, true)
                    ];
                });
                break;
            case 'shop_banner_section_three':
                $data = get_setting('home_shop_banner_3_images')
                            ? banner_array_generate(get_setting('home_shop_banner_3_images'),get_setting('home_shop_banner_3_links'))
                            : [];
                break;


            case 'categories_section':
                $home_categories = get_setting('home_categories_section')
                    ? Category::with([])->find(json_decode(get_setting('home_categories_section')))
                    : [];
                $data = new HomeCategoryCollection($home_categories, true);
                break;

            case 'home_blogs':
                $home_blogs = Blog::where('home_featured', 1)->take(4)->get();

                $data = new BlogCollection($home_blogs, true);
                break;

            case 'home_reviews':
                $home_reviews_images = json_decode(get_setting('home_reviews_images') ?? '[]');
                $home_reviews_names = json_decode(get_setting('home_reviews_names') ?? '[]');
                $home_reviews_designations = json_decode(get_setting('home_reviews_designations') ?? '[]');
                $home_reviews_comments = json_decode(get_setting('home_reviews_comments') ?? '[]');
                $review_collection = [];
                foreach($home_reviews_images as $key => $value){
                    $temp = [];
                    $temp['image'] = api_asset($value);
                    $temp['name'] = $home_reviews_names[$key];
                    $temp['designation'] = $home_reviews_designations[$key];
                    $temp['comment'] = $home_reviews_comments[$key];
                    array_push($review_collection,$temp);
                }
                $data = $review_collection;
                break;

            default:
                $data = null;

        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function header_setting()
    {
        return Cache::remember('header_setting', 86400, function () {
            return response()->json([
                'header_logo' => api_asset(get_setting('header_logo')),
                'helpline' => get_setting('topbar_helpline_number'),
                'header_menu' => get_setting('header_menu_labels') !== null
                            ? header_menu_array_combine(json_decode(get_setting('header_menu_labels')),json_decode(get_setting('header_menu_links')))
                            : [],
                'social_link' => get_setting('footer_social_link')
                            ? json_decode(get_setting('footer_social_link'), true)
                            : ['facebook' => null,'twitter' => null,'instagram' => null,'youtube' => null,'linkedin' => null],
            ]);
        });
    }
    public function footer_setting()
    {
        return Cache::remember('footer_setting', 86400, function () {
            return response()->json([
                'footer_logo' => api_asset(get_setting('footer_logo')),
                'footer_about_text' => get_setting('footer_about_text'),
                'footer_link_one' => [
                    'title' => get_setting('footer_link_one_title'),
                    'menu' => get_setting('footer_link_one_labels') !== null
                                ? array_combine(json_decode(get_setting('footer_link_one_labels')),json_decode(get_setting('footer_link_one_links')))
                                : []
                ],
                'contact_info' => [
                    'contact_address' => get_setting('contact_address'),
                    'contact_email' => get_setting('contact_email'),
                    'contact_phone' => get_setting('contact_phone'),
                    'open_time' => get_setting('open_time'),
                ],
                'footer_payment_images' => api_assets(get_setting('footer_payment_images')),
                'copyright_text' => get_setting('frontend_copyright_text'),
                'social_link' => get_setting('footer_social_link')
                                        ? json_decode(get_setting('footer_social_link'), true)
                                        : ['facebook' => null,'twitter' => null,'instagram' => null,'youtube' => null,'linkedin' => null],
            ]);
        });
    }
    public function about_us_setting($section)
    {
        switch ($section) {
            case 'main_section':
                $data = get_setting('main_section_images')
                            ? about_us_sections_generate(get_setting('main_section_images'),get_setting('main_section_titles'),get_setting('main_section_content'))
                            : [];
                break;

            case 'story_section':
                $data = get_setting('story_section_images')
                            ? about_us_sections_generate(get_setting('story_section_images'),get_setting('story_section_titles'),get_setting('story_section_content'))
                            : [];
                break;

            case 'team_section':
                $data = get_setting('team_section_images')
                            ? about_us_sections_generate(get_setting('team_section_images'),get_setting('team_section_titles'),get_setting('team_section_content'))
                            : [];
                break;



            case 'gallery_section':
                $data = get_setting('gallery_section_images')
                            ? banner_array_generate(get_setting('gallery_section_images'),get_setting('gallery_section_links'))
                            : [];
                break;


            default:
                $data = null;

        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function contact_us_setting($section)
    {
        switch ($section) {
            case 'contact_us':
                $info_section_icons = json_decode(get_setting('info_section_icons') ?? '[]');
                $info_section_content = json_decode(get_setting('info_section_content') ?? '[]');
                $content_collection = [];
                foreach($info_section_icons as $key => $value){
                    $temp = [];
                    $temp['icons'] = api_asset($value);
                    $temp['content'] = $info_section_content[$key];
                    array_push($content_collection,$temp);
                }
                $data = $content_collection;
                break;

            case 'cover_image':
                $cover_image = json_decode(get_setting('contact_us_cover_image') ?? '[]');
                $content_collection['cover_image'] = api_asset($cover_image[0]);
                $data = $content_collection;
                break;

            default:
                $data = null;

        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function sister_concern_setting($section)
    {
        // dd($section);
        switch ($section) {
            case 'sc_banner_section':
                $banner_image = json_decode(get_setting('sc_banner_section_images') ?? '[]');
                $content_collection['banner_image'] = api_asset($banner_image[0]);
                $data = $content_collection;
                break;

            case 'company_section':
                $data = get_setting('company_section_images')
                            ? sister_concern_company_sections_generate(get_setting('company_section_images'),get_setting('company_section_names'),get_setting('company_section_links'))
                            : [];
                break;

            default:
                $data = null;

        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function event_page_setting($section)
    {
        // dd($section);setting/gallery/banner_section
        switch ($section) {
            case 'banner_section':
                $banner_image = json_decode(get_setting('gallery_page_main_images') ?? '[]');
                $content_collection['banner_image'] = api_asset($banner_image[0]);
                $data = $content_collection;
                break;
            case 'gallery_section':
                $data = get_setting('gallery_page_gallery_images')
                            ? banner_array_generate(get_setting('gallery_page_gallery_images'),get_setting('gallery_section_links'))
                            : [];
                break;
            case 'video_section':
                $data = get_setting('event_page_videos_titles')
                            ? event_page_video_sections_generate(get_setting('event_page_videos_titles'),get_setting('event_page_videos_links'))
                            : [];
                break;
            // case 'company_section':
            //     $data = get_setting('company_section_images')
            //                 ? sister_concern_company_sections_generate(get_setting('company_section_images'),get_setting('company_section_names'),get_setting('company_section_links'))
            //                 : [];
            //     break;

            default:
                $data = null;

        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function message_md_page_setting($section)
    {
        switch ($section) {
            case 'banner_section':
                $banner_image = json_decode(get_setting('md_message_banner_section_images') ?? '[]');
                $content_collection['banner_image'] = api_asset($banner_image[0]);
                $data = $content_collection;
                break;
            case 'message_section':
                $md_message_section_md_images = json_decode(get_setting('md_message_section_md_images') ?? '[]');
                $md_message_section_md_message = json_decode(get_setting('md_message_section_md_message') ?? '[]');
                $content_collection = [];

                foreach($md_message_section_md_images as $key => $value){
                    $temp = [];
                    $temp['image'] = api_asset($value);
                    $temp['message'] = $md_message_section_md_message[$key];
                    array_push($content_collection,$temp);
                }
                $data = $content_collection;

            break;

            default:
            $data = null;

        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function key_management_setting($section)
    {
        // dd($section);
        switch ($section) {
            case 'mv_banner_section':
                    $banner_image = json_decode(get_setting('mission_vission_banner_section_images') ?? '[]');
                    $content_collection['banner_image'] = api_asset($banner_image[0]);
                    $data = $content_collection;
                break;

            case 'mv_management_section':
                $data = get_setting('mv_management_section_images')
                            ? mv_management_sections_generate(get_setting('mv_management_section_images'),get_setting('mv_management_section_names'),get_setting('mv_management_section_designations'),get_setting('mv_management_section_descriptions'))
                            : [];
                break;

            default:
                $data = null;

        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function about_ejdl_setting($section)
    {
        // dd($section);
        switch ($section) {
            case 'ejdl_banner_section':
                    $banner_image = json_decode(get_setting('mission_vission_banner_section_images') ?? '[]');
                    $content_collection['banner_image'] = api_asset($banner_image[0]);
                    $data = $content_collection;
                break;

            case 'ejdl_card_section':
                $data = get_setting('mv_card_section_images')
                            ? mv_card_sections_generate(get_setting('mv_card_section_images'),get_setting('mv_card_section_titles'),get_setting('mv_card_section_descriptions'))
                            : [];
                break;
            case 'ejdl_description_section':
                $data = json_decode(get_setting('about_ejdl_section_descriptions'))[0];
                break;

            default:
                $data = null;

        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
