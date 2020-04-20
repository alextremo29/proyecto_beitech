<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Product;



class ProductController extends Controller
{
    
    public function getOrdersByCustomer()
    {
    	return response()->json([
    		'code' => 200,
    		'status' => 'success',
    		'products' =>"demo" 
    	]);
    }
}
