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
 * Users DB table
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Model_DbTable_UserDetails extends Zend_Db_Table
{
    /**
     * @var string
     */
    protected $_name = 'user_details';

    /**
     * @var string
     */
    protected $_rowClass = 'Users_Model_DbTable_UserDetails_Row';
    
    protected $_dependentTables = array();

}
