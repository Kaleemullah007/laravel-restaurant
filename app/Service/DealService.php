<?php

namespace App\Service;

use App\Models\DealProduct;
use App\Models\Product;

class DealService
{
    public function createDeal($request)
    {
        $all_data = $request->validated();
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
                'deal_id' => 0,
                'owner_id' => $request->owner_id,
            ];

        }
        $all_data['price'] = $price;
        if ($request->hasFile('image')) {
            // et the file with extension
            $image = $request->file('image');

            // Generate a unique file name
            $filename = time().'.'.$image->getClientOriginalExtension();

            // Store the image in the 'public/images' directory
            $path = $image->move('images', $filename, 'public');

            // Optionally, save the image path to the database
            // Example: You can save the path $path in your database
            $all_data['image'] = $path;

        }
        $deal_data = $all_data;

        $product = Product::create($deal_data);

        $fdeal_products = array_map(function ($item) use ($product) {
            $item['deal_id'] = $product->id;

            return $item;
        }, $deal_products);
        DealProduct::insert($fdeal_products);
        $request->session()->flash('success', 'Deal created successfully.');

        return $product;
    }
}
