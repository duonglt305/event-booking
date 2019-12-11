<?php


namespace DG\Dissertation\Api\Services\Paypal;


use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class CreatePayment extends PayPal
{
    private $itemList = [];
    private $returnUrl;
    private $cancelUrl;

    public function create()
    {
        $payment = $this->Payment();
        $payment->create($this->apiContext);
        return $payment->getApprovalLink();
    }

    /**
     * @param array $items
     * @return $this
     */
    public function addItems(array $items): self
    {
        foreach ($items as $item) {
            if ($item instanceof Item) {
                $this->addItem($item);
            }
        }
        return $this;
    }

    /**
     * @param Item $item
     * @return $this
     */
    public function addItem(Item $item): self
    {
        $item->setCurrency($this->currency);
        $this->itemList[] = $item;
        $this->total += $item->price * $item->quantity;
        return $this;
    }

    /**
     * @param $returnUrl
     * @return $this
     */
    public function setReturnUrl($returnUrl): self
    {
        $this->returnUrl = $returnUrl;
        return $this;
    }

    public function setCancelUrl($cancelUrl): self
    {
        $this->cancelUrl = $cancelUrl;
        return $this;
    }

    /**
     * @return Payer
     */
    protected function Payer(): Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        return $payer;
    }

    /**
     * @return RedirectUrls
     */
    protected function RedirectUrls(): RedirectUrls
    {
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($this->returnUrl)
            ->setCancelUrl($this->cancelUrl);
        return $redirectUrls;
    }

    /**
     * @return Payment
     */
    protected function Payment(): Payment
    {
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($this->Payer())
            ->setRedirectUrls($this->RedirectUrls())
            ->setTransactions([$this->Transaction()]);
        return $payment;
    }

    /**
     * @return ItemList
     */
    protected function ItemList(): ItemList
    {
        $itemList = new ItemList();
        $itemList->setItems($this->itemList);
        return $itemList;
    }


    /**
     * @return Transaction
     */
    protected function Transaction(): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->Amount())
            ->setItemList($this->ItemList())
            ->setInvoiceNumber(uniqid());
        return $transaction;
    }
}
