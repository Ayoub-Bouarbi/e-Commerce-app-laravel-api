<?php

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\OrderItem;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Stripe;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class OrderMutation
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {

        $order = Order::create([
            'first_name' => $args['first_name'],
            'last_name' => $args['last_name'],
            'address' => $args['address'],
            'city' => $args['city'],
            'country' => $args['country'],
            'state' => $args['state'],
            'zip_code' => $args['zip_code'],
            'phone_number' => $args['phone_number'],
            'order_number' => "ORD-" . strtoupper(uniqid()),
            'user_id' => $args['user_id'],
        ]);

        if($order){
            $items = json_decode($args['items'],true);

            foreach ($items as $item) {
                $orderItem = OrderItem::create([
                    'product_id' => $item['id'],
                    'order_id' => $order->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $order->OrderItems()->save($orderItem);
            }

            try {
                $stripe = Stripe::make();


                $stripe->charges()->create([
                    'currency' => 'USD',
                    'amount'   => $args['amount'],
                    'source' => $args['token'],
                ]);
            } catch (CardErrorException $th) {
                throw $th;
            }
        }

        return $order;
    }
    public function delete($_, array $args)
    {
        $order = Order::find($args['id']);


        return $order->delete();
    }
}
