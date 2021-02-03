<?php

namespace App\GraphQL\Mutations;

use App\Models\ProductAttribute;

class ProductAttributeMutation
{
    public function create($_,array $args)
    {
        return ProductAttribute::create($args);
    }

    public function delete($_,array $args)
    {
        $productAttribute = ProductAttribute::find($args['id']);


        if ($productAttribute->delete()) {
            return $productAttribute;
        }
    }
}
