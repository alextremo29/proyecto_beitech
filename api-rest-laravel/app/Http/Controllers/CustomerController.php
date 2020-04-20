<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Customer;

class CustomerController extends Controller
{
    public function index()
    {
    	$customers = Customer::select('customer_id','name')->get();
    	return response()->json([
    		'code'=> 200,
    		'status' => 'success',
    		'customers' => $customers
    	]);
    }
    public function getProductsByCustomer($id)
    {
        $products = Customer::all()->load('products')->where('customer_id',$id);
        
        foreach ($products as $product) {
            return response()->json([
        		'code' => 200,
        		'status' => 'success',
        		'products' =>$product["products"]
        	]);
        }
        
    }

}
