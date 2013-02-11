<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function contactAction()
    {
        $form = new Application_Form_Contact();

        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if ($form->isValid($post)) {
                $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
                $contactInfo = $config->getOption('contactInfo');
                // Do the e-mail
                $mailer = new Zend_Mail();
                $mailer->setSubject('Email from Cut Em Loose ');
                $mailer->setFrom($form->email->getValue(), $form->name->getValue());
                $mailer->setBodyText($form->details->getValue());
                $mailer->addTo($contactInfo['email'], $contactInfo['name']);

                $mailer->send();

                $this->_helper
                     ->flashMessenger
                     ->setNamespace('success')
                     ->addMessage("Thank you for contacting us, we will get back to you soon!");

                $this->_helper
                     ->redirector
                     ->gotoRoute(array(), 'home');
            }
        }


        $this->view->form = $form;
    }

    public function aboutAction()
    {

    }

}

