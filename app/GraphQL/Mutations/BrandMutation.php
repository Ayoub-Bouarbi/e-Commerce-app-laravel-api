<?php

namespace App\GraphQL\Mutations;

use App\Models\Brand;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BrandMutation
{
    public function create($_,array $args)
    {
        $collection = collect($args)->except("logo");

        $brand = null;

        if($args["logo"] != null && $args["logo"] instanceof UploadedFile){

            $logo = $args['logo']->hashname();

            $data = $collection->merge(compact('logo'));

            $brand = Brand::create($data->all());

            $args['logo']->storePublicly('public/uploads/brands');
        }else{
            $brand = Brand::create($collection->all());
        }

        return $brand;
    }
    public function update($_,array $args)
    {
        $collection = collect($args)->except('logo');

        $brand = Brand::find($args['id']);

        if($args["logo"] != null && $args["logo"] instanceof UploadedFile){

            if($brand->logo != null && !empty($brand->logo) && file_exists(storage_path('app/public/uploads/brands/'.$brand->logo))){
                unlink(storage_path('app/public/uploads/brands/'.$brand->logo));
            }

            $logo = $args['logo']->hashname();

            $data = $collection->merge(compact('logo'));

            if($brand->update($data->all())){
                $args['logo']->storePublicly('public/uploads/brands');

                return $brand;
            }

        }else{
            if($brand->update($collection->all())){

                return $brand;
            }
        }

        return null;

    }
    public function delete($_,array $args)
    {
        $brand = Brand::find($args['id']);

        if($brand->logo != null || !empty($brand->logo) && file_exists(storage_path('app/public/uploads/brands/'.$brand->logo))){
            unlink(storage_path('app/public/uploads/brands/'.$brand->logo));
        }

        if($brand->delete($args['id'])){
            return $brand;
        }
    }

    public function deleteImage($_,array $args)
    {
        $brand = Brand::find($args['id']);

        if($brand->logo != null && !empty($brand->logo) && file_exists(storage_path('app/public/uploads/brands/'.$brand->logo))){
            unlink(storage_path('app/public/uploads/brands/'.$brand->logo));
        }

        $brand->logo = null;

        if($brand->update()){
            return $brand;
        }
    }
}
