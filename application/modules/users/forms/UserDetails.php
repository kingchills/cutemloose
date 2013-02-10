<?php
/**
 * UserDetails
 *
 * @package Cutemloose
 * @subpackage User Forms
 */

/**
 * Class: Users_Form_UserDetails extends Bear_Form
 *
 * Description:
 *
 * Details:
 *
 * @package Cutemloose
 * @author Drew Brown <dbrown78@gmail.com>
 */
class Users_Form_UserDetails extends Bear_Form_SubForm
{
    /**
     * @var Users_Model_DbTable_Users
     */
    protected $_user;

    public function init()
    {
        $this->addElement(
            $this->createElement('text', 'address')
                 ->setLabel('Address')
                 ->setOrder(6)
        );

        $this->addElement(
            $this->createElement('text', 'address_cont')
                 ->setOrder(7)
        );

        $this->addElement(
            $this->createElement('text', 'city')
                 ->setLabel('City')
                 ->setOrder(8)
        );

        $this->addElement(
            $this->createElement('usState', 'state')
                 ->setLabel('State')
                 ->setReturnAbbreviatedStateValues(true)
                 ->setOrder(9)
        );

        $this->addElement(
            $this->createElement('text', 'zip')
                 ->setLabel('Zip Code')
                 ->setOrder(10)
        );

        $this->addElement(
            $this->createElement('phoneNumber', 'phone')
                 ->setLabel('Phone')
                 ->setOrder(11)
        );


    }

    /**
     * @param $user
     * @return Users_Form_UserDetails
     */
    public function setUser($user)
    {
        $this->_user = $user;

        return $this;
    }

    /**
     * @return Users_Model_DbTable_Users
     */
    public function getUser()
    {
        return $this->_user;
    }
}
