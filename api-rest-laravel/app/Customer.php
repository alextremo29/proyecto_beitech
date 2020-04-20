<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = "customer_id";
    protected $fillable = [
        'name','email'
    ];

    
    public function products()
    {
        return $this->belongsToMany('App\Product','customer_product','product_id','customer_id');
    }
    public function orders()
    {
    	return $this->hasMany('App\Order', 'customer_id', 'customer_id');
    }
}
