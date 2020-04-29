<?php
namespace App\Billings;
Interface PaymentGatewayContract
{

    public function charge($amount);
    public function setDiscount($amount);
}
