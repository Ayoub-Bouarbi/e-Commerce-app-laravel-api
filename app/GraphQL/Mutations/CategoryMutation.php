<?php

namespace App\GraphQL\Mutations;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryMutation
{
    public function create($_,array $args)
    {
        return Category::create($args);
    }
    public function update($_,array $args)
    {
        $category = Category::find($args['id']);

        if($category->update($args)){
            return $category;
        }
    }
    public function delete($_,array $args)
    {
        $category = Category::find($args['id']);

        if($category->delete($args['id'])){
            return $category;
        }
    }
}
