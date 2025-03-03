<?php

namespace App\Service;

use App\Models\DealProduct;
use App\Models\Product;

class DealService
{
    public function createDeal($request)
    {
        $all_data = $request->validated();

        $deal_data = [
            'name' => $request->deal_name,
            'product_code' => $request->product_code,
            'sale_price' => $request->deal_price,
            'stock' => 0,
            'stock_alert' => 0,
            'owner_id' => $request->owner_id,
            'variation' => '',
            'unit' => '',
            'is_deal' => $request->is_product_value,
            'is_always' => (boolean)$request->is_always,
            'start_time' => $request->start_time??null,
            'end_time' => $request->end_time??null,
            'status' => (boolean) $request->status,
        ];

        $deal_products_data = $all_data['productss'];
        unset($all_data['productss']);
        $selected_products = Product::whereIn('id', array_keys($deal_products_data))->get()->pluck(null, 'id');
        // dd($deal_products_data);
        $price = 0;
        $deal_products = [];
        foreach ($deal_products_data as $prodcut) {

            $fProduct = $selected_products[$prodcut['product_id']];

            $price += $fProduct->sale_price * $prodcut['quantity'];
            $deal_products[] = [
                'product_name' => $fProduct->name,
                'price' => $fProduct->price,
                'discount_price' => $fProduct->price,
                'quantity' => $prodcut['quantity'],
                'is_swappable' => isset($prodcut['is_swappable']) ? ($prodcut['is_swappable'] == 'on' ? true : false) : false,
                'owner_id' => $request->owner_id,
            ];
        }
        $deal_data['price'] = $price;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $path = $image->move('images', $filename, 'public');
            $deal_data['image'] = $path;

        }
  
      
        $product = Product::create($deal_data);

        $fdeal_products = array_map(function ($item) use ($product) {
            $item['product_id'] = $product->id;

            return $item;
        }, $deal_products);
        DealProduct::insert($fdeal_products);
        return $product;
    }
}
