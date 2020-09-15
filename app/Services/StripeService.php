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
    public function createCheckoutSession($shipping_id, $line_items)
    {
        
        
        $stripeApiKey = config('my-app.stripe-apiKey');
        \Stripe\Stripe::setApiKey($stripeApiKey);
        $domain = config('my-app.success_url');
        $session = \Stripe\Checkout\Session::create([
          'payment_method_types' => ['card'],
          'line_items' => $line_items,
          'mode' => 'payment',
          
          // 'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
          // 'success_url' => 'https://719b9230c63140f18ad17fc26e8124c1.vfs.cloud9.us-east-1.amazonaws.com' . '/creditComplete?session_id={CHECKOUT_SESSION_ID}',
          'success_url' => config('my-app.success_url') . '/creditComplete?session_id={CHECKOUT_SESSION_ID}',
          'cancel_url' => config('my-app.success_url') . '/shippings/' . $shipping_id . '/myOrderDetail',
          // 'cancel_url' => 'https://719b9230c63140f18ad17fc26e8124c1.vfs.cloud9.us-east-1.amazonaws.com' . '/shippings/' . $shipping_id . '/myOrderDetail',
        ]);
        return $session->id;
    }
    //webhock機能
    public function webhook()
    {
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        $stripeApiKey = config('my-app.stripe-apiKey');
        \Stripe\Stripe::setApiKey($stripeApiKey);
        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = 'whsec_Jie2g9nkAHg9yr32FazPmXzWKhyz8E60';
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        try {
          $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
          );
        } catch(\UnexpectedValueException $e) {
          // Invalid payload
          http_response_code(400);
          exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
          // Invalid signature
          http_response_code(400);
          exit();
        }
        // Handle the checkout.session.completed event
        if ($event->type == 'checkout.session.completed') {
          \Log::info('webhook point6');
          $session = $event->data->object;
          // Fulfill the purchase...
          $shipping = Shipping::where('stripeid', $session->id)->first();
          $shipping->shippingItems()->update(['money_transfer' => 2]);
        }
        http_response_code(200);
    }
    // セッションの取得
    public function retrieveSession($stripe_id){
      $stripeApiKey = config('my-app.stripe-apiKey');
      $stripe = new \Stripe\StripeClient($stripeApiKey);
      $stripe_session = $stripe->checkout->sessions->retrieve($stripe_id,[]);
      return $stripe_session->payment_status;
    }
}


?>