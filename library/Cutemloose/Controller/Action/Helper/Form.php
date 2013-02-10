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
 * Description:
 *
 * Details:
 *
 * @package CutemLoose
 * @author Drew Brown <dbrown@nerdery.com>
 * @version $
 */
class Cutemloose_Controller_Action_Helper_Form extends Zend_Controller_Action_Helper_Abstract
{

    protected $currentUser;

    protected $acl;

    public function setAcl($acl)
    {
        $this->acl = $acl;

        return $this;
    }

    /**
     * @return Zend_Acl
     */
    public function getAcl()
    {
        return $this->acl;
    }

    public function setCurrentUser($currentUser)
    {
        $this->currentUser = $currentUser;

        return $this;
    }

    /**
     * @return Users_Model_DbTable_Users_Row
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }



}
