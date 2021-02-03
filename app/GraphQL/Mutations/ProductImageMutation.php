<?php

namespace App\GraphQL\Mutations;

use App\Models\ProductImage;

class ProductImageMutation
{
    public function upload($_,array $args)
    {
        foreach ($args['images'] as $image) {

            $img = $image->hashname();

            $image->storePublicly('public/uploads/products');

            ProductImage::create(["image" => $img,"product_id" => $args['product_id']]);
        }

        return ['status' => 200];
    }
    public function delete($_,$args)
    {
        $productImage = ProductImage::find($args['id']);

        if($productImage->image != null && !empty($productImage->image) && file_exists(storage_path('app/public/uploads/products/'.$productImage->image))){
            unlink(storage_path('app/public/uploads/products/'.$productImage->image));
        }

        if($productImage->delete()){
            return $productImage;
        }
    }
}
