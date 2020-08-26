<?php
declare(strict_types=1);

class IndexController extends ControllerBase
{

    /**
     * @return bool
     */
    public function indexAction()
    {
        if(!$this->session->has('user')) {
            return $this->response->redirect('/user/auth');
        }

        $this->view->user = $this->session->get('user');
    }

}

