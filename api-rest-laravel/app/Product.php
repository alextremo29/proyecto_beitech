<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = "product_id";
    protected $fillable = [
        'name','product_description', 'price'
    ];

    public function customers()
    {
        return $this->belongsToMany('App\Customer','customer_product','customer_id','product_id');
    }
    public function order_details()
    {
    	return $this->hasMany('App\Order_detail', 'product_id', 'product_id');
    }
}
