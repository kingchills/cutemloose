<?php
/**
 * ManageController
 *
 * @package Cutemloose
 * @subpackage Dogs
 */

/**
 * Class: ManageController extends Zend_Controller_Action
 *
 * Description:
 *
 * Details:
 *
 * @package Cutemloose
 * @author Drew Brown <dbrown78@gmail.com>
 */
class ManageController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }

    public function listAction()
    {

    }

    protected function _getDogsMOdel()
    {
        return new Dogs_Model_DbTable_Dogs();
    }

}
