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
    public function deleteAll($_,$args)
    {
        $productImages = ProductImage::where("product_id","=",$args['id'])->get();

        if($productImages != null){

            foreach ($productImages as $productImage) {
                if($productImage->image != null && !empty($productImage->image) && file_exists(storage_path('app/public/uploads/products/'.$productImage->image))){
                    unlink(storage_path('app/public/uploads/products/'.$productImage->image));
                }

                $productImage->delete();
            }

            return ['status' => 200];
        }

        return ['status' => 400];
    }
}
