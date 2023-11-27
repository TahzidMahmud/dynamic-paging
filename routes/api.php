<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RefundRequestController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\SubscribeController;
use App\Http\Controllers\Api\TranslationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\MessageController;

Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {

    Route::group(['prefix' => 'auth'], function () {

        Route::post('send-code', [AuthController::class,'send_code']);
        Route::post('login', [AuthController::class,'login']);
        Route::group(['middleware' => 'auth:api'], function () {
            Route::get('logout', [AuthController::class,'logout']);
            Route::get('user', [AuthController::class,'user']);
            Route::post('complete-registration', [AuthController::class,'complete_registration']);
        });


        // Route::post('login', [AuthController::class,'login']);
        // Route::post('signup', [AuthController::class,'signup']);
        // Route::post('verify', [AuthController::class,'verify']);
        // Route::post('resend-code', [AuthController::class,'resend_code']);

        // Route::post('password/create', [PasswordResetController::class,'create']);
        // Route::post('password/reset', [PasswordResetController::class,'reset']);

        // Route::group(['middleware' => 'auth:api'], function () {
        //     Route::get('logout', [AuthController::class,'logout']);
        //     Route::get('user', [AuthController::class,'user']);
        // });
    });

    Route::get('demo', [OfferController::class,'demo']);

    Route::post('contact-us', [ContactUsController::class,'store'])->name('data.store');
    Route::get('event/gallery_section', [EventController::class,'gallery_data'])->name('galler.data');
    Route::get('locale/{language_code}', [TranslationController::class,'index']);
    Route::get('setting/home/{section}', [SettingController::class,'home_setting']);
    Route::get('setting/about-us/{section}', [SettingController::class,'about_us_setting']);
    Route::get('setting/sister-concern/{section}', [SettingController::class,'sister_concern_setting']);
    Route::get('setting/event/{section}', [SettingController::class,'event_page_setting']);
    Route::get('setting/message-md-page/{section}', [SettingController::class,'message_md_page_setting']);
    Route::get('setting/key-management/{section}', [SettingController::class,'key_management_setting']);
    Route::get('setting/about-ejdl/{section}', [SettingController::class,'about_ejdl_setting']);
    Route::get('setting/contact-us/{section}', [SettingController::class,'contact_us_setting']);
    Route::get('setting/home/home_blogs', [SettingController::class,'home_blogs']);
    Route::get('setting/footer', [SettingController::class,'footer_setting']);
    Route::get('setting/header', [SettingController::class,'header_setting']);
    Route::post('subscribe', [SubscribeController::class,'subscribe']);

    Route::get('all-categories', [CategoryController::class,'index']);
    Route::get('categories/first-level', [CategoryController::class,'first_level_categories']);
    Route::get('categories/tree', [CategoryController::class,'categories_tree']);
    Route::get('all-brands', [BrandController::class,'index']);
    Route::get('all-offers', [OfferController::class,'index']);
    Route::get('offer/{slug}', [OfferController::class,'show']);
    Route::get('page/{slug}', [PageController::class,'show']);
    Route::get('offer/{slug}/filter', [OfferController::class,'filter_offer']);
    Route::get('parent-category/{slug}', [CategoryController::class,'child_categories']);
    Route::get('child-cat-products/{slug}', [CategoryController::class,'child_category_product']);
    Route::get('category-single-product/{slug}', [CategoryController::class,'category_product']);
    Route::get('autoMotiveProducts/{slug}', [CategoryController::class,'autoMotiveProducts']);
    Route::get('industrialProducts/{slug}', [CategoryController::class,'industrialProducts']);
    Route::get('greaseProducts/{slug}', [CategoryController::class,'greaseProducts']);


    Route::group(['prefix' => 'product'], function () {
        Route::get('/details/{product_slug}', [ProductController::class,'show']);
        Route::post('get-by-ids', [ProductController::class,'get_by_ids']);
        Route::get('search', [ProductController::class,'search']);
        Route::get('featured', [ProductController::class,'featured']);
        Route::get('popular', [ProductController::class,'popular']);
        Route::get('related/{product_id}', [ProductController::class,'related']);
        Route::get('bought-together/{product_id}', [ProductController::class,'bought_together']);
        Route::get('random/{limit}/{product_id?}', [ProductController::class,'random_products']);
        Route::get('latest/{limit}', [ProductController::class,'latest_products']);
        Route::get('reviews/{product_id}', [ReviewController::class,'index']);
    });

    Route::get('all-states', [AddressController::class,'get_all_states']);
    Route::get('states/{country_id}', [AddressController::class,'get_states_by_country_id']);
    Route::get('cities/{state_id}', [AddressController::class,'get_cities_by_state_id']);

    Route::post('carts', [CartController::class,'index']);
    Route::post('carts/add', [CartController::class,'add']);
    Route::post('carts/change-quantity', [CartController::class,'changeQuantity']);
    Route::post('carts/destroy', [CartController::class,'destroy']);
    Route::resource('messages', MessageController::class);


    Route::group(['middleware' => 'auth:api'], function () {

        Route::group(['prefix' => 'checkout'], function () {
            Route::post('get-shipping-cost', [OrderController::class,'get_shipping_cost']);
            Route::post('order/store', [OrderController::class,'store']);
            Route::post('coupon/apply', [CouponController::class,'apply']);
        });

        Route::post('query/store',[ConversationController::class,'store'])->name('query.store');

        Route::group(['prefix' => 'user'], function () {

            Route::get('dashboard', [UserController::class,'dashboard']);

            Route::get('chats', [ChatController::class,'index']);
            Route::post('chats/send', [ChatController::class,'send']);
            Route::get('chats/new-messages', [ChatController::class,'new_messages']);

            Route::get('info', [UserController::class,'info']);
            Route::post('info/update', [UserController::class,'updateInfo']);
            Route::post('password/update', [UserController::class,'updatePassword']);

            Route::get('coupons', [CouponController::class,'index']);

            Route::get('orders', [OrderController::class,'index']);
            Route::get('order/{order_code}', [OrderController::class,'show']);
            Route::get('order/cancel/{order_id}', [OrderController::class,'cancel']);
            Route::get('order/invoice-download/{order_code}', [OrderController::class,'invoice_download']);

            Route::get('review/check/{product_id}', [ReviewController::class,'check_review_status']);
            Route::post('review/submit', [ReviewController::class,'submit_review']);

            Route::apiResource('wishlists', WishlistController::class)->except(['update', 'show']);
            Route::apiResource('follow', FollowController::class)->except(['update', 'show']);

            Route::get('addresses', [AddressController::class,'addresses']);
            Route::post('address/create', [AddressController::class,'createShippingAddress']);
            Route::post('address/update', [AddressController::class,'updateShippingAddress']);
            Route::get('address/delete/{id}', [AddressController::class,'deleteShippingAddress']);
            Route::get('address/default-shipping/{id}', [AddressController::class,'defaultShippingAddress']);
            Route::get('address/default-billing/{id}', [AddressController::class,'defaultBillingAddress']);

            Route::post('wallet/recharge', [WalletController::class,'recharge']);
            Route::get('wallet/history', [WalletController::class,'walletRechargeHistory']);

            // Refund Addon
            Route::get('refund-requests', [RefundRequestController::class,'index']);
            Route::get('refund-request/create/{order_id}', [RefundRequestController ::class,'create']);
            Route::post('refund-request/store', [RefundRequestController ::class,'store']);
        });
    });

    // for blogs
    Route::get('all-blogs', [BlogController::class,'index']);
    Route::get('blog/{slug}', [BlogController::class,'show'])->name('blog.show');


    //for shops
    Route::post('shop/register', [ShopController::class,'shop_register']);
    Route::get('all-shops', [ShopController::class,'index']);
    Route::get('shop/{slug}', [ShopController::class,'show']);
    Route::get('shop/{slug}/home', [ShopController::class,'shop_home']);
    Route::get('shop/{slug}/coupons', [ShopController::class,'shop_coupons']);
    Route::get('shop/{slug}/products', [ShopController::class,'shop_products']);

});

Route::fallback(function () {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});
