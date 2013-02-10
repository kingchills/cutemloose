<?php
/**
 * Form
 *
 * @package CutemLoose
 * @subpackage Form
 */

/**
 * Class: Cutemloose_Form extends Bear_Form
 *
 * Description: Action helper to get user and acl details for forms.
 *
 * Details:
 *
 * @package CutemLoose
 * @author Drew Brown <dbrown@nerdery.com>
 * @version $
 */
class Cutemloose_Controller_Action_Helper_Form extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * @var Users_Model_DbTable_Users_Row
     */
    protected $_currentUser;

    /**
     * @var Zend_Acl
     */
    protected $_acl;

    /**
     * @param $acl
     * @return Cutemloose_Controller_Action_Helper_Form
     */
    public function setAcl($acl)
    {
        $this->_acl = $acl;

        return $this;
    }

    /**
     * @return Zend_Acl
     */
    public function getAcl()
    {
        return $this->_acl;
    }

    /**
     * @param $currentUser
     * @return Cutemloose_Controller_Action_Helper_Form
     */
    public function setCurrentUser($currentUser)
    {
        $this->_currentUser = $currentUser;

        return $this;
    }

    /**
     * @return Users_Model_DbTable_Users_Row
     */
    public function getCurrentUser()
    {
        return $this->_currentUser;
    }
}
