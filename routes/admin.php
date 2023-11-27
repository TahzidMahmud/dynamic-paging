<?php

use App\Http\Controllers\AddonController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CouponActionLogController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerDataLogController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\HomePageEditLogController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferActionLogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderActionLogController;
use App\Http\Controllers\OrderProcessLogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReportActionLogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleActionLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffActionLogController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UserActionLogController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogCategoryController;


use App\Http\Controllers\ProductActionLogController;

use App\Addons\MultiVendor\Http\Controllers\MultiVendorController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ShowcaseProductController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('/update', [UpdateController::class, 'step0'])->name('update');
Route::get('/update/step1', [UpdateController::class, 'step1'])->name('update.step1');
Route::get('/update/step2', [UpdateController::class, 'step2'])->name('update.step2');
Route::get('/convert_for_update', [UpdateController::class, 'convertForRefund']);

Route::get('/refresh-csrf', function () {
    return csrf_token();
});
Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
Route::delete('/aiz-uploader/destroy/{id}', [AizUploadController::class, 'destroy']);
Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');


Route::get('/demo/cron_1', [DemoController::class, 'cron_1']);
Route::get('/demo/cron_2', [DemoController::class, 'cron_2']);
Route::get('/insert_trasnalation_keys', [DemoController::class, 'insert_trasnalation_keys']);
Route::get('/customer-products/admin', [SettingController::class, 'initSetting']);

Auth::routes(['register' => false]);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



Route::group(['prefix' => 'admin-panel', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/', [AdminController::class, 'admin_dashboard'])->name('admin.dashboard');

    Route::post('/language', [LanguageController::class, 'changeLanguage'])->name('language.change');

    Route::resource('categories', CategoryController::class);
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::get('/categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/featured', [CategoryController::class, 'updateFeatured'])->name('categories.featured');

    Route::resource('brands', BrandController::class);
    Route::get('/brands/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit');
    Route::get('/brands/destroy/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

    Route::resource('attributes', AttributeController::class)->except(['destroy']);
    Route::get('/attributes/edit/{id}', [AttributeController::class, 'edit'])->name('attributes.edit');

    Route::resource('attribute_values', AttributeValueController::class)->except(['destroy']);;
    Route::get('/attribute_values/edit/{id}', [AttributeValueController::class, 'edit'])->name('attribute_values.edit');




    // Product
    Route::resource('/product', ProductController::class);
    Route::resource('/showcase-product', ShowcaseProductController::class);
    Route::get('/showcase-product/{id}/edit', [ShowcaseProductController::class,'edit'])->name('showcase-product.edit');
    Route::post('/showcase-product/update/{id}', [ShowcaseProductController::class, 'update'])->name('showcase-product.update');
    Route::get('/showcase-product/destroy/{id}', [ShowcaseProductController::class,'destroy'])->name('showcase-product.destroy');
    Route::get('/showcase-product/duplicate/{id}', [ShowcaseProductController::class,'duplicate'])->name('showcase-product.duplicate');
    Route::post('/showcase-product-published', [ShowcaseProductController::class, 'updatePublished'])->name('showcase-product-product.published');

    Route::post('/products/ajax-search', [ProductController::class,'ajax_search'])->name('products.ajax_search');

    Route::group(['prefix' => 'product'], function () {
        Route::post('/ajax_search_cat', [ProductController::class, 'ajax_category_search'])->name('product.ajax_category_search');
        Route::post('/new-attribte', [ProductController::class, 'new_attribute'])->name('product.new_attribute');
        Route::post('/get-attribte-value', [ProductController::class, 'get_attribute_values'])->name('product.get_attribute_values');
        Route::post('/new-option', [ProductController::class, 'new_option'])->name('product.new_option');
        Route::post('/get-option-choices', [ProductController::class, 'get_option_choices'])->name('product.get_option_choices');

        Route::post('/sku-combination', [ProductController::class, 'sku_combination'])->name('product.sku_combination');


        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::get('/duplicate/{id}', [ProductController::class, 'duplicate'])->name('product.duplicate');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/published', [ProductController::class, 'updatePublished'])->name('product.published');
        Route::post('/featured', [ProductController::class, 'updateFeatured'])->name('product.featured');
        Route::post('/todays-deal', [ProductController::class, 'updateTodays_deal'])->name('product.todays_deal');

        Route::get('/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

        Route::post('/get_products_by_subcategory', [ProductController::class, 'get_products_by_subcategory'])->name('product.get_products_by_subcategory');
    });


    Route::resource('customers', CustomerController::class);
    Route::get('customers-query', [CustomerController::class, 'query'])->name('customers.query');
    Route::get('customers-query/destroy/{id}', [CustomerController::class, 'destroy_query'])->name('customers.query.destroy');
    Route::get('customers-query/show/{id}', [CustomerController::class, 'show_query'])->name('customers.query.show');
    Route::get('customers_ban/{customer}', [CustomerController::class, 'ban'])->name('customers.ban');
    Route::get('/customers/login/{id}', [CustomerController::class, 'login'])->name('customers.login');
    Route::get('/customers/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletters.index');
    Route::post('/newsletter/send', [NewsletterController::class, 'send'])->name('newsletters.send');
    Route::post('/newsletter/test/smtp', [NewsletterController::class, 'testEmail'])->name('test.smtp');

    Route::resource('profile', ProfileController::class);

    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/shop-settings/update', [SettingController::class, 'shop_update'])->name('shop_settings.update');
    Route::post('/settings/update/activation', [SettingController::class, 'updateActivationSettings'])->name('settings.update.activation');
    Route::get('/general-setting', [SettingController::class, 'general_setting'])->name('general_setting.index');
    Route::get('/otp-settings', [SettingController::class, 'otp_settings'])->name('settings.otp');
    Route::get('/payment-method', [SettingController::class, 'payment_method'])->name('payment_method.index');
    Route::get('/file_system', [SettingController::class, 'file_system'])->name('file_system.index');
    Route::get('/social-login', [SettingController::class, 'social_login'])->name('social_login.index');
    Route::get('/smtp-settings', [SettingController::class, 'smtp_settings'])->name('smtp_settings.index');
    Route::post('/env_key_update', [SettingController::class, 'env_key_update'])->name('env_key_update.update');
    Route::post('/payment_method_update', [SettingController::class, 'payment_method_update'])->name('payment_method.update');

    Route::get('/third-party-settings', [SettingController::class, 'third_party_settings'])->name('third_party_settings.index');
    Route::post('/google_analytics', [SettingController::class, 'google_analytics_update'])->name('google_analytics.update');
    Route::post('/google_recaptcha', [SettingController::class, 'google_recaptcha_update'])->name('google_recaptcha.update');
    Route::post('/facebook_chat', [SettingController::class, 'facebook_chat_update'])->name('facebook_chat.update');
    Route::post('/facebook_pixel', [SettingController::class, 'facebook_pixel_update'])->name('facebook_pixel.update');

    // Currency
    Route::get('/currency', [CurrencyController::class, 'index'])->name('currency.index');
    Route::post('/currency/update', [CurrencyController::class, 'updateCurrency'])->name('currency.update');
    Route::post('/your-currency/update', [CurrencyController::class, 'updateYourCurrency'])->name('your_currency.update');
    Route::get('/currency/create', [CurrencyController::class, 'create'])->name('currency.create');
    Route::post('/currency/store', [CurrencyController::class, 'store'])->name('currency.store');
    Route::post('/currency/currency_edit', [CurrencyController::class, 'edit'])->name('currency.edit');
    Route::post('/currency/update_status', [CurrencyController::class, 'update_status'])->name('currency.update_status');

    // Language
    Route::resource('/languages', LanguageController::class);
    Route::post('/languages/save_default_language', [LanguageController::class, 'save_default_language'])->name('languages.save_default_language');
    Route::post('/languages/update_status', [LanguageController::class, 'update_status'])->name('languages.update_status');
    Route::post('/languages/update_rtl_status', [LanguageController::class, 'update_rtl_status'])->name('languages.update_rtl_status');
    Route::post('/languages/update_language_status', [LanguageController::class, 'update_language_status'])->name('languages.update_language_status');
    Route::get('/languages/destroy/{id}', [LanguageController::class, 'destroy'])->name('languages.destroy');
    Route::post('/languages/key_value_store', [LanguageController::class, 'key_value_store'])->name('languages.key_value_store');

    // website setting
    Route::group(['prefix' => 'website', 'middleware' => ['permission:website_setup']], function () {

        Route::view('/header', 'backend.website_settings.header')->name('website.header');
        Route::view('/footer', 'backend.website_settings.footer')->name('website.footer');
        Route::view('/banners', 'backend.website_settings.banners')->name('website.banners');
        Route::view('/pages', 'backend.website_settings.pages.index')->name('website.pages');
        Route::view('/appearance', 'backend.website_settings.appearance')->name('website.appearance');
        Route::resource('custom-pages', PageController::class);
        Route::get('/custom-pages/edit/{id}', [PageController::class, 'edit'])->name('custom-pages.edit');
        Route::get('/custom-pages/destroy/{id}', [PageController::class, 'destroy'])->name('custom-pages.destroy');
    });

    Route::resource('roles', RoleController::class);
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::get('/roles/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');


    Route::resource('staffs', StaffController::class);
    Route::get('/staffs/destroy/{id}', [StaffController::class, 'destroy'])->name('staffs.destroy');

    // Offers
    Route::resource('offers', OfferController::class);
    Route::get('/offers/destroy/{id}', [OfferController::class, 'destroy'])->name('offers.destroy');
    Route::post('/offers/update_status', [OfferController::class, 'update_status'])->name('offers.update_status');
    Route::post('/offers/product_discount', [OfferController::class, 'product_discount'])->name('offers.product_discount');
    Route::post('/offers/product_discount_edit', [OfferController::class, 'product_discount_edit'])->name('offers.product_discount_edit');

    //Subscribers
    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');

    // Orders
    Route::resource('orders', OrderController::class);
    Route::get('pos/orders', [OrderController::class,'pos_orders'])->name('orders.pos');

    Route::post('/order/notes', [OrderController::class, 'get_notes'])->name('order.notes');


    Route::post('/orders/update_order', [OrderController::class, 'order_update'])->name('orders.order_update');
    Route::post('/orders/update_delivery_status', [OrderController::class, 'update_delivery_status'])->name('orders.update_delivery_status');
    Route::post('/orders/update_payment_status', [OrderController::class, 'update_payment_status'])->name('orders.update_payment_status');
    Route::get('/orders/destroy/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/invoice/{order_id}', [InvoiceController::class, 'invoice_download'])->name('orders.invoice.download');
    Route::get('/orders/print/{order_id}', [InvoiceController::class, 'invoice_print'])->name('orders.invoice.print');
    Route::post('/orders/add-tracking-information', [OrderController::class, 'add_tracking_information'])->name('orders.add_tracking_information');

    //Coupons
    Route::resource('coupon', CouponController::class);
    Route::post('/coupon/get_form', [CouponController::class, 'get_coupon_form'])->name('coupon.get_coupon_form');
    Route::post('/coupon/get_form_edit', [CouponController::class, 'get_coupon_form_edit'])->name('coupon.get_coupon_form_edit');
    Route::get('/coupon/destroy/{id}', [CouponController::class, 'destroy'])->name('coupon.destroy');
    //Blog Section
    Route::resource('blog-category', BlogCategoryController::class);
    Route::get('/blog-category/destroy/{id}', [BlogCategoryController::class,'destroy'])->name('blog-category.destroy');
    Route::resource('blog', BlogController::class);
    Route::get('/blog/destroy/{id}', [BlogController::class,'destroy'])->name('blog.destroy');
    Route::post('/blog/change-status', [BlogController::class,'change_status'])->name('blog.change-status');
    Route::post('/blog/change-featured', [BlogController::class,'change_featured'])->name('blog.change-featured');
    Route::post('/blog/change-home-featured', [BlogController::class,'change_home_featured'])->name('blog.change-home-featured');


    //Event Section
    Route::resource('event', EventController::class);
    Route::get('/event/destroy/{id}', [EventController::class,'destroy'])->name('event.destroy');
    Route::post('/event/change-featured', [EventController::class,'change_featured'])->name('event.change-featured');
    Route::get('/event-video', [EventController::class,'event_video'])->name('event.video');
    Route::post('/event-video/store', [EventController::class,'video_store'])->name('event.video-store');






    //Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/published', [ReviewController::class, 'updatePublished'])->name('reviews.published');

    Route::any('/uploaded-files/file-info', [AizUploadController::class, 'file_info'])->name('uploaded-files.info');
    Route::resource('/uploaded-files', AizUploadController::class);
    Route::get('/uploaded-files/destroy/{id}', [AizUploadController::class, 'destroy'])->name('uploaded-files.destroy');


    Route::resource('addons', AddonController::class);
    Route::post('/addons/activation', [AddonController::class, 'activation'])->name('addons.activation');

    //Shipping Configuration
    Route::get('/shipping_configuration', [SettingController::class, 'shipping_configuration'])->name('shipping_configuration.index');
    Route::post('/shipping_configuration/update', [SettingController::class, 'shipping_configuration_update'])->name('shipping_configuration.update');

    Route::resource('countries', CountryController::class);
    Route::post('/countries/status', [CountryController::class, 'updateStatus'])->name('countries.status');

    Route::resource('states', StateController::class);
    Route::post('/states/status', [StateController::class, 'updateStatus'])->name('states.status');

    Route::resource('cities', CityController::class);
    Route::get('/cities/edit/{id}', [CityController::class, 'edit'])->name('cities.edit');
    Route::get('/cities/destroy/{id}', [CityController::class, 'destroy'])->name('cities.destroy');
    Route::post('/cities/status', [CityController::class, 'updateStatus'])->name('cities.status');

    Route::resource('zones', ZoneController::class);
    Route::get('/zones/destroy/{id}', [ZoneController::class, 'destroy'])->name('zones.destroy');


    Route::view('/system/update', 'backend.system.update')->middleware('permission:system_update')->name('system_update');
    Route::view('/system/server-status', 'backend.system.server_status')->middleware('permission:server_status')->name('server_status');

    // tax
    Route::resource('taxes', TaxController::class);
    Route::post('/tax/status_update', [TaxController::class, 'updateStatus'])->name('tax.status_update');
    Route::get('/taxes/destroy/{id}', [TaxController::class, 'destroy'])->name('taxes.destroy');

    //chats
    Route::resource('chats', ChatController::class);
    Route::post('/refresh/chats', [ChatController::class, 'refresh'])->name('chats.refresh');
    Route::post('/chat-reply', [ChatController::class, 'reply'])->name('chats.reply');

    Route::get('/update/step1', [UpdateController::class, 'step1']);

    //Activity Logs

    Route::get('/product-action-log', [ProductActionLogController::class, 'index'])->name('productlog.index');
    Route::resource('customer_data_logs', CustomerDataLogController::class);
    Route::resource('user_action_logs', UserActionLogController::class);
    Route::get('/staff-action-log', [StaffActionLogController::class ,'index'])->name('staff_action_logs.index');
    Route::resource('role_action_logs', RoleActionLogController::class);
    Route::resource('coupon_action_logs',CouponActionLogController::class);
    Route::resource('offer_action_logs', OfferActionLogController::class);
    Route::get('/order-action-log', [OrderActionLogController::class, 'index'])->name('order_action_logs.index');
    Route::get('/order-process-log', [OrderProcessLogController::class,'index'])->name('order_process_logs.index');
    Route::get('/report-action-log', [ReportActionLogController::class,'index'])->name('report_action_logs.index');
    Route::get('/home-page-edit-log', [HomePageEditLogController::class,'index'])->name('home_page_edit_logs.index');



    //Reports
    Route::get('/stock_report', [ReportController::class, 'stock_report'])->name('stock_report.index');
    Route::get('/best_selling_product_report', [ReportController::class, 'best_selling_product_report'])->name('best_selling_product_report.index');
    Route::get('/sale_report', [ReportController::class, 'sale_report'])->name('sale_report.index');
    Route::get('/sale_stat_report/print', [ReportController::class, 'sale_report_print'])->name('sale_report.print');

    //offer sales

    Route::get('/offer_sales', [ReportController::class, 'offer_wise_sell'])->name('offer_sales.index');
    Route::get('/offer_sales/{id}', [ReportController::class, 'offer_sale'])->name('offer_sales.show');


    //conversation of seller customer
    Route::resource('conversations', ConversationController::class);
    Route::get('conversations', [ConversationController::class,'admin_index'])->name('conversations.admin_index');
    Route::get('conversations/{id}/show', [ConversationController::class, 'admin_show'])->name('conversations.admin_show');






});

Route::get('/addons/multivendor', [MultiVendorController::class, 'helloFromMultiVendor']);
