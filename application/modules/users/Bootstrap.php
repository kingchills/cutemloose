<?php
/**
 * Bear Users Module
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 */

/**
 * Users module bootstrap
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Bootstrap extends Zend_Application_Module_Bootstrap
{

    /**
     * Initialize the action helpers
     * 
     * @return void
     */
    protected function _initActionHelpers()
    {
        $this->getApplication()->bootstrap('frontController');

        Zend_Controller_Action_HelperBroker::addPath(
            dirname(__FILE__) . "/controllers/actionhelpers/",
            "Users_Controller_ActionHelper_"
        );
    }
        
    /**
     * Initialize auth action helpers
     *
     * @return void
     */
    protected function _initAuthHelpers()
    {
        $this->bootstrap('auth')
             ->bootstrap('acl');
        
        Zend_Controller_Action_HelperBroker::getStaticHelper("assertAuthHasIdentity")
                                           ->setAuth($this->getResource("auth"));
                                           
        Zend_Controller_Action_HelperBroker::getStaticHelper("assertIsAllowed")
                                           ->setAcl($this->getResource("acl"));
                                           
        
    }

    /**
     * Initialize the Login Action Helper
     *
     * @return void
     */
    protected function _initLoginHelper()
    {
        $this->bootstrap('authAdapter')
             ->bootstrap('auth');

        $this->getApplication()
             ->bootstrap('frontController');
                     
        $loginRoute = array(
            'module'     => 'users',
            'controller' => 'account',
            'action'     => 'login',
        );
    
        Zend_Controller_Action_HelperBroker::getStaticHelper("login")
                                           ->setFormActionUrlOptions($loginRoute)
                                           ->setAuth($this->getResource("auth"))
                                           ->setAuthAdapter($this->getResource("authAdapter"));
    }
    
    /**
     * Initialize the ACL
     * 
     * @return Zend_Acl
     */
    protected function _initAcl()
    {
        if (in_array('acl', $this->getApplication()->getClassResourceNames())) {
            // attempt to retrieve ACL from main application bootstrap
            $acl = $this->getApplication()
                        ->bootstrap('acl')
                        ->getResource('acl');
        } else {
            // main application bootstrap does not have an ACL resource, so create one
            $acl = new Zend_Acl();
            $this->_setResourceToApplication('acl', $acl);
        }

        /**
         * Roles
         */
        $adminRole = new Zend_Acl_Role(Users_Model_DbTable_Users::ROLE_ADMIN);
        $userRole  = new Zend_Acl_Role(Users_Model_DbTable_Users::ROLE_USER);
        $guestRole = new Zend_Acl_Role(Users_Model_DbTable_Users::ROLE_GUEST);
        
        $acl->addRole($guestRole)
            ->addRole($userRole)
            ->addRole($adminRole, $userRole);

        /**
         * Resources
         */
        $userResource  = new Zend_Acl_Resource(Users_Model_DbTable_Users::RESOURCE_USER);
        $adminResource = new Zend_Acl_Resource(Users_Model_DbTable_Users::RESOURCE_ADMIN);
        $dogResource   = new Zend_Acl_Resource("dog");
        $eventResource = new Zend_Acl_Resource("event");
        $clubResource  = new Zend_Acl_Resource("club");
        
        $acl->addResource($userResource);
        $acl->addResource($adminResource);
        /**
         * Permissions
         */
        
        // admin can manage all users
        $acl->allow($adminRole, $userResource)
            ->allow($adminRole, $adminResource);
            
        return $acl;
    }
    
    /**
     * Initialize the auth object
     *
     * @return Zend_Auth
     */
    protected function _initAuth()
    {
        $auth = Zend_Auth::getInstance();
        
        $this->_setResourceToApplication('auth', $auth);
        
        return $auth;
    }

    /**
     * Initialize the auth adapter object
     *
     * @return Zend_Auth_Adapter_Interface
     */
    protected function _initAuthAdapter()
    {
        $this->bootstrap('userDbTable');

        $dbAdapter = $this->getApplication()
                          ->bootstrap('db')
                          ->getResource('db');

        if (Bear_Crypt_Blowfish::isSupported()) {
            $authAdapter = new Bear_Auth_Adapter_BlowfishDbTable(
                $dbAdapter,
                $this->getResource('userDbTable'),
                'email',
                'password'
            );
        } else {
            $authAdapter = new Zend_Auth_Adapter_DbTable(
                $dbAdapter,
                $this->getResource('userDbTable')->info(Zend_Db_Table::NAME),
                'email',
                'password',
                'MD5(CONCAT(salt,?))'
            );
        }

        $this->_setResourceToApplication('authAdapter', $authAdapter);

        return $authAdapter;
    }

    /**
     * Initialize user DB table
     *
     * @return Users_Model_DbTable_Users
     */
    protected function _initUserDbTable()
    {
        $this->getApplication()->bootstrap('db');

        return new Users_Model_DbTable_Users();
    }

    /**
     * Fetch the current user from the database
     *
     * @return Users_Model_DbTable_Users_Row
     */
    protected function _initCurrentUser()
    {
        $this->bootstrap('frontController')
             ->bootstrap('auth');

        $identity = $this->getResource('auth')->getIdentity();

        if (! $identity) {
            /** @var $currentUser Users_Model_DbTable_Users_Row */
            $currentUser = $this->getResource('userDbTable')->createRow();
            $currentUser->role = Users_Model_DbTable_Users::ROLE_GUEST;
            $currentUser->firstName = 'Guest';
            $currentUser->setReadOnly(true);
        } else {
            $currentUser = $this->getResource('userDbTable')
                ->findByEmail($identity);
        }

        /** @var $currentUserHelper Bear_Controller_Action_Helper_CurrentUser */
        $currentUserHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('currentUser');
        $currentUserHelper->setCurrentUser($currentUser);

        $this->_setResourceToApplication('currentuser', $currentUser);

        return $currentUser;
    }

    /**
     * Add an application resource to the main application bootstrap, so it is accessible throughout
     * the application as a first-order resource
     *
     * @param string $resourceName
     * @param mixed $resource
     * @return Users_Bootstrap
     */
    protected function _setResourceToApplication($resourceName, $resource)
    {

        $resourceName = strtolower($resourceName);

        $application = $this->getApplication();
        $application->_markRun($resourceName);
        $application->getContainer()->{$resourceName} = $resource;

        return $this;
    }

    /**
     * Setup routes
     */
    protected function _initRoutes()
    {
        $router = $this->getApplication()
            ->bootstrap('frontcontroller')
            ->getResource('frontcontroller')
            ->getRouter();

        $router->addRoute(
            'login',
            new Zend_Controller_Router_Route(
                '/login',
                array(
                    'module'     => 'users',
                    'controller' => 'account',
                    'action'     => 'login'
                )
            )
        );

        $router->addRoute(
            'logout',
            new Zend_Controller_Router_Route(
                '/logout',
                array(
                    'module'     => 'users',
                    'controller' => 'account',
                    'action'     => 'logout'
                )
            )
        );

        $router->addRoute(
            'register',
            new Zend_Controller_Router_Route(
                '/register',
                array(
                    'module'     => 'users',
                    'controller' => 'account',
                    'action'     => 'register'
                )
            )
        );

        $router->addRoute(
            'edit-user',
            new Zend_Controller_Router_Route(
                'user/:id',
                array(
                    'module'     => 'users',
                    'controller' => 'manage',
                    'action'     => 'edit',
                    'id'         => ''
                )
            )
        );

        $router->addRoute(
            'user-list',
            new Zend_Controller_Router_Route(
                'users',
                array(
                    'module'     => 'users',
                    'controller' => 'manage',
                    'action'     => 'list',
                )
            )
        );

        $router->addRoute(
            'add-user',
            new Zend_Controller_Router_Route(
                'user/new',
                array(
                    'module'     => 'users',
                    'controller' => 'manage',
                    'action'     => 'add',
                )
            )
        );

        $router->addRoute(
            'delete-user',
            new Zend_Controller_Router_Route(
                'user/remove/:id',
                array(
                    'module'     => 'users',
                    'controller' => 'manage',
                    'action'     => 'delete',
                    'id'         => '',
                )
            )
        );
    }

}