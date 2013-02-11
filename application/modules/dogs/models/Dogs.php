<?php
/**
 * Dogs
 *
 * @package Cutemloose
 * @subpackage Dogs
 */

/**
 * Class: Dogs_Model_DbTable_Dogs extend Zend_DbTable_Abstract
 *
 * Description:
 *
 * Details:
 *
 * @package Cutemloose
 * @author Drew Brown <dbrown78@gmail.com>
 */
class Dogs_Model_DbTable_Dogs extends Zend_Db_Table
{
    protected $_name = 'dogs';

    protected $_rowClass = 'Dogs_Model_DbTable_Dogs_Row';

    protected $_dependentTables = array();
}
