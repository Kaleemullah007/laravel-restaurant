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

    public function updateDeal($request, $deal)
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
            'start_time' => $request->start_time ?? null,
            'end_time' => $request->end_time ?? null,
            'status' => (boolean) $request->status,
        ];

        $deal_products_data = $all_data['productss'];
        unset($all_data['productss']);
        $selected_products = Product::whereIn('id', array_keys($deal_products_data))->get()->pluck(null, 'id');
        
        $price = 0;
        
        
        // Get existing deal products
        $existing_deal_products = DealProduct::where('product_id', $deal->id)
            ->pluck('id', 'product_id')
            ->toArray();
        dd($existing_deal_products,$deal_products_data);
        $deal_products_to_update = [];
        $deal_products_to_create = [];
        
        foreach ($deal_products_data as $product_id => $product) {
            $fProduct = $selected_products[$product['product_id']];
            $price += $fProduct->sale_price * $product['quantity'];
            
            $product_data = [
                'product_name' => $fProduct->name,
                'price' => $fProduct->price,
                'discount_price' => $fProduct->price,
                'quantity' => $product['quantity'],
                'is_swappable' => isset($product['is_swappable']) ? ($product['is_swappable'] == 'on' ? true : false) : false,
                'owner_id' => $request->owner_id,
            ];

            // Check if product already exists in deal
            if (isset($existing_deal_products[$product['product_id']])) {
                // Product exists, update it
                $deal_products_to_update[$existing_deal_products[$product['product_id']]] = $product_data;
                // Remove from existing products array to track which ones should be deleted
                unset($existing_deal_products[$product['product_id']]);
            } else {
                // Product doesn't exist, create it
                $product_data['product_id'] = $deal->id;
                $deal_products_to_create[] = $product_data;
            }
        }

        $deal_data['price'] = $price;


        // dd($deal_products_data,$deal_data,$price);
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($deal->image && file_exists(public_path($deal->image))) {
                unlink(public_path($deal->image));
            }
            
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $path = $image->move('images', $filename, 'public');
            $deal_data['image'] = $path;
        }

        // Update the deal
      
        $deal->update($deal_data);

        // Update existing products
        foreach ($deal_products_to_update as $deal_product_id => $product_data) {
            DealProduct::where('id', $deal_product_id)->update($product_data);
        }

        // Create new products
        if (!empty($deal_products_to_create)) {
            DealProduct::insert($deal_products_to_create);
        }
        dd($existing_deal_products);
        // Delete products that are no longer in the deal
        if (!empty($existing_deal_products)) {
            dd($existing_deal_products);
            DealProduct::whereIn('id', array_values($existing_deal_products))->delete();
        }

        return $deal;
    }
}
