<?php

namespace App\Validator;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;

class MessageValidator extends InputFilter
{
    public function __construct()
    {
        $input = new Input('userId');
        $input->setRequired(true);
        $input->getValidatorChain()
            ->attach(new \Zend\I18n\Validator\IsInt())
            ->attach(new Validator\NotEmpty());
        $this->add($input);

        $input = new Input('currencyFrom');
        $input->setRequired(true);
        $input->getValidatorChain()
            ->attach(new Validator\NotEmpty());
        $this->add($input);

        $input = new Input('currencyTo');
        $input->setRequired(true);
        $input->getValidatorChain()
            ->attach(new Validator\NotEmpty());
        $this->add($input);

        $input = new Input('amountSell');
        $input->setRequired(true);
        $input->getValidatorChain()
            ->attach(new \Zend\I18n\Validator\IsFloat())
            ->attach(new Validator\NotEmpty());
        $this->add($input);

        $input = new Input('amountBuy');
        $input->setRequired(true);
        $input->getValidatorChain()
            ->attach(new \Zend\I18n\Validator\IsFloat())
            ->attach(new Validator\NotEmpty());
        $this->add($input);

        $input = new Input('rate');
        $input->setRequired(true);
        $input->getValidatorChain()
            ->attach(new \Zend\I18n\Validator\IsFloat())
            ->attach(new Validator\NotEmpty());
        $this->add($input);

        $input = new Input('timePlaced');
        $input->setRequired(true);
        $input->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\Date(['format' => 'd-M-y H:i:s']));
        $this->add($input);

        $input = new Input('originatingCountry');
        $input->setRequired(true);
        $input->getValidatorChain()
            ->attach(new Validator\NotEmpty());
        $this->add($input);
    }
}
