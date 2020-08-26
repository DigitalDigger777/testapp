<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Email;

use Phalcon\Validation\Validator\PresenceOf;

class RegistrationForm extends Form {

    public function initialize()
    {
        $this->setEntity($this);
        $name = new Text("name");
        $name->setAttribute('class','form-control');

        $email = new Email("email");
        $email->addValidator(new PresenceOf(array(
            'message' => 'Email Address is required'
        )));
        $email->setAttribute('class','form-control');

        $password = new Password('password');
        $password->setAttribute('class','form-control');
        $password->addValidator(new PresenceOf(array(
            'message' => 'Password is required'
        )));

        $confirmPassword = new Password('confirmPassword');
        $confirmPassword->setAttribute('class','form-control');
        $confirmPassword->addValidator(new PresenceOf(array(
            'message' => 'Confirm password is required'
        )));

        $this->add($name);
        $this->add($email);
        $this->add($password);
        $this->add($confirmPassword);
    }
}