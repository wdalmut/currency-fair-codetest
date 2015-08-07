<?php
namespace App\Model;

class Message
{
    private $id;
    private $userId;
    private $currencyFrom;
    private $currencyTo;
    private $amountSell;
    private $amountBuy;
    private $rate;
    private $timePlaced;
    private $originatingCountry;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setCurrencyFrom($currecyFrom)
    {
        $this->currencyFrom = $currecyFrom;
    }

    public function getCurrencyFrom()
    {
        return $this->currencyFrom;
    }

    public function setCurrecyTo($currencyTo)
    {
        $this->currencyTo = $currecyTo;
    }

    public function getCurrectTo()
    {
        return $this->currencyTo;
    }

    public function setAmountSell($sell)
    {
        $this->amountSell = $sell;
    }

    public function getAmountSell()
    {
        return $this->amountSell;
    }

    public function getAmountBuy()
    {
        return $this->amountBuy;
    }

    public function setAmountBuy($buy)
    {
        $this->amountBuy = $buy;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setTimePlaced(\DateTime $time)
    {
        $this->timePlaced = $time;
    }

    public function getTimePlaced()
    {
        return $this->timePlaced;
    }

    public function setOriginatingCountry($country)
    {
        $this->originatingCountry = $country;
    }

    public function getOriginatingCountry()
    {
        return $this->originatingCountry;
    }
}
