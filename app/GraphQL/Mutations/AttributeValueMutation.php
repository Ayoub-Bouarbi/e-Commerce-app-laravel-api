<?php

namespace App\GraphQL\Mutations;

use App\Models\AttributeValue;

class AttributeValueMutation
{
    public function create($_,array $args)
    {
        return AttributeValue::create($args);
    }
    public function update($_,array $args)
    {
        $attributeValue = AttributeValue::find($args['id']);

        if($attributeValue->update($args)){
            return $attributeValue;
        }
    }
    public function delete($_,array $args)
    {
        $attributeValue = AttributeValue::find($args['id']);

        if($attributeValue->delete($args['id'])){
            return $attributeValue;
        }
    }
}
