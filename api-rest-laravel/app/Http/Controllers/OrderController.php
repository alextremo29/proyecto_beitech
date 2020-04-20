<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Order;
use App\Order_detail;
use App\Product;

class OrderController extends Controller
{
    public function getOrdersByCustomer(Request $request)
    {
    	$params_array = [
            'customer_id' => $request['customer_id'],
            'init_date'   => $request['init_date'],
            'final_date'  => $request['final_date']
        ];

        if (!empty($params_array)) {
            $validate = \Validator::make($params_array,[
                'customer_id' => 'required|integer',
                'init_date'   => 'required',
                'final_date'  => 'required'
            ]);

            if ($validate->fails()) {
                $data = array(
                    'code'    => 405,
                    'status'  => 'bad request',
                    'message' => 'Data Invalid',
                    'errors'  => $validate->errors()
                );
            } else{
                $orders = Order::all()
                                ->load('costumer')
                                ->load('order_details')
                                ->where('customer_id',$params_array["customer_id"])
                                ->whereBetween('creation_date',[$params_array["init_date"],$params_array["final_date"]]);
                $data = array(
                    'code'   =>200,
                    'status' =>'success',
                    'orders' =>$orders
                );
            }
        }else{
            $data = array(
                'code'    => 400,
                'status'  => 'error',
                'message' =>"Data not found"
            );
        }
        return response()->json($data, $data["code"]);
    }
    public function store(Request $request)
    {
    	$params_array = [
            'customer_id'      => $request['customer_id'],
            'delivery_address' => $request['delivery_address'],
            'total'            => $request['total'],
            'order_detail'     => $request['order_detail']
        ];
        if (!empty($params_array)) {
    		$validate = \Validator::make($params_array,[
                'customer_id'      => 'required|integer',
                'delivery_address' => 'required',
                'total'            => 'required|numeric',
                'order_detail'     => 'required'
    		]);
    		if ($validate->fails()) {
    			$data = array(
                    'code'    => 405,
                    'status'  => 'error',
                    'message' => 'Data Invalid',
                    'errors'  => $validate->errors()
    			);
    		} else{
    			$order =new Order();
    			$order->customer_id = $params_array["customer_id"];
    			$order->creation_date = date('Y-m-d');
    			$order->delivery_address = $params_array["delivery_address"];
    			$order->total = $params_array["total"];

    			$order->save();
    			$order_detail = $this->storeOrderDetail($order->order_id,$params_array["order_detail"]);
    			$data = array(
                    'code'         => 200,
                    'status'       => 'success',
                    'order'        => $order,
                    'order_detail' => $order_detail
    			);
    		}
    	} else{
    		$data = array(
                'code'    => 400,
                'status'  => 'error',
                'message' =>"Data not found"
            );
    	}
    	return response()->json($data, $data["code"]);
    }
    public function storeOrderDetail($order_id,$request_order_detail)
    {
        $order_details = [];
        foreach ($request_order_detail as $value) {
            $product = Product::find($value["product_id"]);
        	$order_detail = new Order_detail();
            $order_detail->order_id = $order_id;
            $order_detail->product_id = $product->product_id;
            $order_detail->product_description = $product->product_description;
            $order_detail->price = $product->price;
            $order_detail->quantity = $value["quantity"];
            
            $order_detail->save();
        	$order_details[] = $order_detail;
        }
        return $order_details;
    }
}
