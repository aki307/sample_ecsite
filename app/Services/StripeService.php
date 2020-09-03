<?php

namespace App\Services;
use App\Shipping;

class StripeService
{   
    //Product登録
    public function createProduct($item)
    {
        $stripeApiKey = config('my-app.stripe-apiKey');
        \Stripe\Stripe::setApiKey($stripeApiKey);
        
        
        
        \Stripe\Product::create([
        'id' => 'ec-item-' . $item->id,
        'name' => $item->item_name,
        'type' => 'good',
        'images' => [$item->image_url],
        'description' => $item->description,
        ]);
    }
    //チェックアウトセッションの作成
    public function createCheckoutSession($line_items)
    {
        
        
        $stripeApiKey = config('my-app.stripe-apiKey');
        \Stripe\Stripe::setApiKey($stripeApiKey);
        $domain = config('my-app.success_url');
        $session = \Stripe\Checkout\Session::create([
          'payment_method_types' => ['card'],
          'line_items' => $line_items,
          'mode' => 'payment',
          
          'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
          'cancel_url' => 'https://example.com/cancel',
        ]);
        return $session->id;
    }
    //webhock機能
    public function webhook()
    {
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Log::info('webhook point2');
        print('point2');
        $stripeApiKey = config('my-app.stripe-apiKey');
        \Stripe\Stripe::setApiKey($stripeApiKey);
        \Log::info('webhook point3');
        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = 'whsec_2tIV0Y7yFErtzyvYtEl444jKMmCD2q1r';
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        \Log::info('webhook point4');
        try {
          $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
          );
          \Log::info('webhook point5');
          print_r('webhook point5');
        } catch(\UnexpectedValueException $e) {
          // Invalid payload
          http_response_code(400);
          \Log::info('webhook error1');
          print_r('webhook error1');
          exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
          // Invalid signature
          http_response_code(400);
          \Log::info('webhook error2');
          print_r('webhook error2');
          exit();
        }
        // Handle the checkout.session.completed event
        if ($event->type == 'checkout.session.completed') {
          \Log::info('webhook point6');
          $session = $event->data->object;
          // Fulfill the purchase...
          $shipping = Shipping::where('stripeid', $session->id)->first();
          $shipping->shippingItems()->update(['money_transfer' => 2]);
          \Log::info('webhook point7');
        }
        http_response_code(200);
        \Log::info('webhook point8');
    }
}


?>