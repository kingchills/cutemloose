<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /**
     * Set up our form Helper
     *
     * @return Cutemloose_Controller_Action_Helper_Form
     */
    public function _initFormHelper()
    {
        $this->bootstrap('frontController')
             ->bootstrap('modules')
             ->bootstrap('auth')
             ->bootstrap('acl');
        /** @var $formHelper Cutemloose_Controller_Action_Helper_Form */
        $formHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('form');
        $formHelper->setAcl($this->getResource('acl'));
        $formHelper->setCurrentUser($this->getResource('currentUser'));

        return $formHelper;
    }


}

