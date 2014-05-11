<?php
namespace PayPalIntegrationTest;

use PayPal\Api\CreditCard;
Use PayPalIntegration\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PayPalIntegration\Client
     */
    private $client;
    const PAYMENT_TOTAL = 99;

    public function setUp()
    {
        $this->client = new Client();
    }

    public function testGetAuthentication()
    {
        $token = $this->client->getAccessToken();
        $this->assertNotNull($token);
    }

    public function testMakePayment()
    {
        $card = new CreditCard();
        $card->setType("visa");
        $card->setNumber("4417119669820331");
        $card->setExpire_month("01");
        $card->setExpire_year("2016");
        $card->setCvv2("012");
        $card->setFirst_name("Peter");
        $card->setLast_name("Smith");

        $transactionId = $this->client->makePayment($card, self::PAYMENT_TOTAL);
        $this->assertNotNull($transactionId);

        return $transactionId;
    }

    /**
     * @depends testMakePayment
     */
    public function testGetTransaction($transactionId)
    {
        $payment = $this->client->getTransaction($transactionId);
        $this->assertNotNull($payment);

        $transactions = $payment->getTransactions();
        $this->assertCount(1, $transactions);
        $this->assertEquals(self::PAYMENT_TOTAL, $transactions[0]->getAmount()->getTotal());
    }
}
