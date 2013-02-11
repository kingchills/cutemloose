<?php
/**
 * Routes
 *
 * @package Cutemloose
 * @subpackage Routes
 */

/**
 * Class: Cutemloose_Navigation
 *
 * Description:
 *
 * Details:
 *
 * @package Cutemloose
 * @author Drew Brown <dbrown78@gmail.com>
 */
class Cutemloose_Navigation
{

    /**
     * Create our main nav set up.
     *
     * @return Zend_Navigation
     */
    public static function getMainNavContainer()
    {
        /** @var $currentUserHelper Bear_Controller_Action_Helper_CurrentUser */
        $currentUserHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('currentUser');
        $currentUser = $currentUserHelper->getCurrentUser();

        $container = new Zend_Navigation(
            array(
                array(
                    'label'      => 'Home',
                    'route'      => 'home',
                ),
                array(
                    'label'      => 'My Profile',
                    'module'     => 'users',
                    'controller' => 'manage',
                    'action'     => 'edit',
                    'route'      => 'edit-user',
                    'visible'    => $currentUser->getRoleId() != Users_Model_DbTable_Users::ROLE_GUEST,
                    'params'     => array(
                        'id'     => $currentUser->id,
                    )
                ),
                array(
                    'label'      => 'Administration',
                    'uri'        => '/#',
                    'resource'   => Users_Model_DbTable_Users::RESOURCE_ADMIN,
                    'pages'      => array(
                        array(
                            'label'      => 'User Management',
                            'module'     => 'users',
                            'controller' => 'manage',
                            'action'     => 'list',
                            'route'      => 'user-list',
                            'resource'   => Users_Model_DbTable_Users::RESOURCE_USER,
                        )
                    )
                ),
            )
        );

        return $container;
    }

}
