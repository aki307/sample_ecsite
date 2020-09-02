<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use StripeService;
use App\Shipping;
use App\ShippingItem;

class StripePolling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:polling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check the function session';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
                // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        $stripeApiKey = config('my-app.stripe-apiKey');
        \Stripe\Stripe::setApiKey($stripeApiKey);
        
        
        $events = \Stripe\Event::all([
          'type' => 'checkout.session.completed',
          'created' => [
            // Check for events created in the last 24 hours.
            'gte' => time() - 24 * 60 * 60,
          ],
        ]);
        
        
        foreach ($events->autoPagingIterator() as $event) {;
          $session = $event->data->object;
          
          $shipping = Shipping::where('stripeid', $session->id)->first();
          $shipping->shippingItems()->update(['money_transfer' => 2]);
          // $shipping_items = $shipping->shippingItems()->get();
          // $shipping_items->money_transfer = 2;
        }
                
    }
}
