<?php

namespace App\Http\Controllers;
use App\Customer;
use App\Order;
use App\Order_detail;
use App\Product;

use Illuminate\Http\Request;

class PruebasController extends Controller
{
    public function testOrm()
    {
        $customers = Customer::where('customer_id',1)->get();
    	$customers = Customer::all();
        foreach ($customers as $customer){
            echo "<h1>".$customer->name."</h1>";
            
            //productos habilitados a cada cliente
            foreach ($customer->products as $product) {
                echo "<h2>".$product->name."</h2<br>";
            }
            // foreach ($customer->customer_products as $product) {
            // 	echo "<h2>".$product->products->name."</h2<br>";
            // }
            // echo "<hr>";
            // // ordenes de los clientes
            // foreach ($customer->orders as $order) {
            // 	echo "<h3>".$order->total."</h3>";
            // 	foreach ($order->order_details as $order_detail) {
            // 		echo "<h4>".$order_detail->quantity."</h4>";
            // 	}
            // }
        }
    	die();
    }
}
