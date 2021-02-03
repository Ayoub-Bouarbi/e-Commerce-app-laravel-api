<?php

namespace App\GraphQL\Mutations;

use App\Models\Attribute;

class AttributeMutation
{
    public function create($_,array $args)
    {
        return Attribute::create($args);
    }
    public function update($_,array $args)
    {
        $attribute = Attribute::find($args['id']);

        if($attribute->update($args)){
            return $attribute;
        }
    }
    public function delete($_,array $args)
    {
        $attribute = Attribute::find($args['id']);

        if($attribute->delete($args['id'])){
            return $attribute;
        }
    }
}
