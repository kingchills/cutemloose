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

    /**
     * Create our navigation container
     *
     * @return Zend_Navigation
     */
    protected function _initMainNav()
    {
        $this->bootstrap('currentUser')
             ->bootstrap('acl');

        return Cutemloose_Navigation::getMainNavContainer();
    }

    /**
     * Set up things our layout will need.
     *
     * @return Zend_Layout
     */
    protected function _initLayout()
    {
        $this->bootstrap('mainNav');

        $layout = Zend_Layout::startMvc(APPLICATION_PATH . '/layouts/scripts');

        $layout->assign('mainNav', $this->getResource('mainNav'));

        return $layout;
    }


}

