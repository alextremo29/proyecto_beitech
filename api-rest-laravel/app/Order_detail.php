<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    protected $table = "order_detail";
    protected $primaryKey = "order_detail_id";
    public $timestamps = false;
    protected $fillable = [
        'order_id','product_description','price', 'quantity'
    ];

    public function order(){
        return $this->belongsTo('App\Order', 'order_id','order_id');
    }

    public function product(){
        return $this->belongsTo('App\Product', 'product_id','product_id');
    }

}
