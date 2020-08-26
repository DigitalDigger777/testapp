<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Email;

use Phalcon\Validation\Validator\PresenceOf;

class AuthForm extends Form {

    public function initialize()
    {
        $this->setEntity($this);

        $email_address = new Email("email");
        $email_address->addValidator(new PresenceOf(array(
            'message' => 'Email Address is required'
        )));
        $email_address->setAttribute('class','form-control');

        $password = new Password('password');
        $password->setAttribute('class','form-control');
        $password->addValidator(new PresenceOf(array(
            'message' => 'Password is required'
        )));

        $this->add($email_address);
        $this->add($password);
    }
}