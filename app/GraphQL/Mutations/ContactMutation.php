<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Mail;

class ContactMutation
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        try {
            Mail::send('mail.contact',['args' => $args], function($message) use ($args)
            {
                $message->from($args['email']);
                $message->to('saquib.rizwan@cloudways.com')->subject($args['subject']);
            });

            return ['status' => 200,'message' => 'Message Sent Successfully'];
        } catch (\Throwable $th) {
            throw $th;
        }
            // return ['status' => 200,'message' => 'Message Sent Successfully'];
    }
}
