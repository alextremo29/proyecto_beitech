<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "order";
    protected $primaryKey = "order_id";
    protected $fillable = [
        'customer_id','creation_date','total'
    ];
    public $timestamps = false;

    public function costumer(){
        return $this->belongsTo('App\Customer', 'customer_id','customer_id');
    }
    public function order_details()
    {
    	return $this->hasMany('App\Order_detail','order_id','order_id');
    }
}
