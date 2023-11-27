<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Order;
use App\Models\CustomerDataLog;
use App\Models\Customer;
use App\Models\Wallet;
use App\Models\Review;
use App\Models\Address;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
    public function customer_data_log()
    {
        return $this->hasMany(CustomerDataLog::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class)->orderBy('created_at', 'desc');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function followed_shops()
    {
        return $this->belongsToMany(Shop::class, 'shop_followers', 'user_id', 'shop_id');
    }
}
