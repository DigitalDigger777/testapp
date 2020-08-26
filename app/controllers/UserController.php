<?php
declare(strict_types=1);


use Phalcon\Http\Request;
use Phalcon\Messages\Message;

class UserController extends \Phalcon\Mvc\Controller
{

    /**
     * @return Message
     */
    public function authAction()
    {
        $form = new AuthForm();
        $this->view->form = $form;

        $request = new Request();

        if ($request->isPost()) {
            if ($this->security->checkToken()) {

                if (!$form->isValid($this->request->getPost())) {

                    foreach($form->getMessages() as $message){
                        $this->flash->error($message->getMessage());
                    }

                } else {
                    $email = $request->get('email');
                    $password = $request->get('password');

                    $login = User::authenticate($email, $password);

                    if ($login) {

                        $user = User::findFirstByEmail($email);

                        $this->session->set('user', [
                            'name' => $user->name,
                            'email' => $user->email
                        ]);

                        $this->response->redirect('/');
                    } else {
                        $this->flash->error('Email or password is not correct');
                    }
                }

            }
        }

    }

    /**
     * @return array|\Phalcon\Http\ResponseInterface
     */
    public function registrationAction()
    {
        $form = new RegistrationForm();
        $this->view->form = $form;

        if ($this->request->isPost()) {
            $email = $this->request->get('email');
            $password = $this->request->get('password');
            $confirmPassword = $this->request->get('confirmPassword');

            if (!$form->isValid($this->request->getPost())) {
                foreach($form->getMessages() as $message){
                    $this->flash->error($message->getMessage());
                }
            } else {
                $user = User::findFirstByEmail($email);

                if (!$user) {

                    if ($password != $confirmPassword) {
                        $this->flash->error('Password and confirm password does not match');
                    } else {

                        $user = new User();
                        $user->name = $this->request->get('name', '');
                        $user->email = $email;
                        $user->password = $this->security->hash($password);


                        if ($user->save()) {
                            return $this->response->redirect('/user/auth');
                        } else {

                            $messages = $user->getMessages();

                            foreach ($messages as $message) {
                                $this->flash->error($message->getMessage());
                            }

                        }

                    }
                }
            }
        }
    }

    /**
     * @return \Phalcon\Http\ResponseInterface
     */
    public function logoutAction()
    {
        $this->session->destroy();

        return $this->response->redirect('/user/auth');
    }
}

