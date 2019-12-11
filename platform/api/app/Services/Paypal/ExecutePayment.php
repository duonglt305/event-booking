<?php


namespace DG\Dissertation\Api\Services\Paypal;


use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class ExecutePayment extends PayPal
{
    /**
     * @return Payment
     */
    public function execute()
    {
        $payment = $this->getThePayment();
        $payment->execute($this->PaymentExecution(), $this->apiContext);
        return $this->getThePayment();
    }

    /**
     * @return PaymentExecution
     */
    protected function PaymentExecution(): PaymentExecution
    {
        $payerId = request()->get('payer_id');
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId)
            ->addTransaction($this->Transaction());
        return $execution;
    }

    /**
     * @return Payment
     */
    protected function getThePayment(): Payment
    {
        $paymentId = request()->get('payment_id');
        $payment = Payment::get($paymentId, $this->apiContext);
        return $payment;
    }

    protected function Transaction(): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->Amount());
        return $transaction;
    }
}
