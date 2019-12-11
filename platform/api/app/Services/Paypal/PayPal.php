<?php


namespace DG\Dissertation\Api\Services\Paypal;


use PayPal\Api\Amount;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PayPal
{
    protected $apiContext;
    protected $currency = 'USD';
    protected $total = 0;

    public function __construct()
    {
        $payPalConfigs = config('api.paypal');
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $payPalConfigs['client_id'],
                $payPalConfigs['secret']
            )
        );
    }

    /**
     * @return Amount
     */
    protected function Amount(): Amount
    {
        $amount = new Amount();
        $amount->setCurrency($this->currency)
            ->setTotal($this->getTotal());
        return $amount;
    }

    /**
     * @param float $total
     * @return $this
     */
    public function setTotal(float $total) : self
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }
}
