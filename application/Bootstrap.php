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

        $mainNav = Cutemloose_Navigation::getMainNavContainer();

        Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($this->getResource('acl'));
        Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole($this->getResource('currentUser')->getRoleId());

        return $mainNav;
    }

    /**
     * Set up things our layout will need.
     *
     * @return Zend_Layout
     */
    protected function _initLayout()
    {
        $this->bootstrap('frontController')
             ->bootstrap('modules')
             ->bootstrap('currentUser')
             ->bootstrap('mainNav');

        $layout = Zend_Layout::startMvc(APPLICATION_PATH . '/layouts/scripts');

        $currentUser = Zend_Controller_Action_HelperBroker::getStaticHelper('currentUser')->getCurrentUser();

        $loggedIn = $currentUser->getRoleId() != Users_Model_DbTable_Users::ROLE_GUEST;

        $layout->assign('mainNav', $this->getResource('mainNav'));
        $layout->assign('currentUser', $currentUser);
        $layout->assign('loggedIn', $loggedIn);

        return $layout;
    }

    /**
     * Set up our base layer routes
     *
     * @return void
     */
    protected function _initRoutes()
    {
        $router = $this->bootstrap('frontcontroller')
                       ->getResource('frontcontroller')
                       ->getRouter();

        $router->addRoute(
            'home',
            new Zend_Controller_Router_Route(
                '/',
                array(
                    'controller' => 'index',
                    'action' => 'index'
                )
            )
        );

        $router->addRoute(
            'about',
            new Zend_Controller_Router_Route(
                '/about',
                array(
                    'controller' => 'index',
                    'action' => 'about'
                )
            )
        );

        $router->addRoute(
            'contact',
            new Zend_Controller_Router_Route(
                '/contact',
                array(
                    'controller' => 'index',
                    'action' => 'contact'
                )
            )
        );
    }


}

