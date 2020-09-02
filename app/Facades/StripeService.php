<?php
    
namespace App\Facades;
    
use Illuminate\Support\Facades\Facade;

class StripeService extends Facade
{
    protected static function getFacadeAccessor(){
        return 'StripeService';
    }
}
?>