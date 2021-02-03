<?php

namespace App\GraphQL\Mutations;

use App\Models\Product;

class ProductMutation
{

    public function create($_,array $args)
    {
        $collection = collect($args)->except('categoires_id');


        $product = Product::create($collection->all());

        if($product != null){

            $product->Categories()->sync($args['categories_id']);

            return $product;
        }
    }
    public function update($_,array $args)
    {
        $collection = collect($args)->except('categoires_id');

        $product = Product::find($args['id']);


        if($product->update($collection->all())){

            $product->Categories()->sync($args['categories_id']);

            return $product;
        }
    }
    public function delete($_,array $args)
    {
        $product = Product::find($args['id']);

        if($product->delete($args['id'])){
            return $product;
        }
    }
}
