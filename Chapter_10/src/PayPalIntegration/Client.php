<?php
namespace PayPalIntegration;

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;

class Client
{
    /**
     * @var \PayPal\Auth\OAuthTokenCredential
     */
    private $auth;

    public function __construct()
    {
        $this->setAuth();
    }

    private function setAuth()
    {
        if (!$this->auth) {
            $configManager = \PPConfigManager::getInstance();

            $this->auth =  new OAuthTokenCredential(
                $configManager->get('acct1.ClientId'),
                $configManager->get('acct1.ClientSecret'));
        }
    }

    public function getAccessToken()
    {
        return $this->auth->getAccessToken();
    }

    /**
     * @param  CreditCard             $card
     * @param  float                  $value
     * @return string
     * @throws \PPConnectionException
     */
    public function makePayment(\PayPal\Api\CreditCard $card, $value)
    {
        $fi = new FundingInstrument();
        $fi->setCredit_card($card);

        $payer = new Payer();
        $payer->setPayment_method("credit_card");
        $payer->setFunding_instruments(array($fi));

        $amount = new Amount();
        $amount->setCurrency("USD");
        $amount->setTotal($value);

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription("This is the payment description.");

        $payment = new Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));

        $apiContext = new ApiContext($this->auth, 'Request' . time());

        $payment->create($apiContext);

        return $payment->getId();
    }

    /**
     * @param  string              $transactionId
     * @return \PayPal\Api\Payment
     */
    public function getTransaction($transactionId)
    {
        Payment::setCredential($this->auth);

        return Payment::get($transactionId);
    }
}
