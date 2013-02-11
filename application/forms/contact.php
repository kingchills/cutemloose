<?php
/**
 * contact
 *
 * @package cutemloose
 * @subpackage index
 */

/**
 * Class: Application_Form_Contact extends Bear_Form
 *
 * Description:
 *
 * Details:
 *
 * @package cutemloose
 * @author Drew Brown <dbrown78@gmail.com>
 */
class Application_Form_Contact extends Bear_Form
{

    public function init()
    {
        $this->addElement(
            $this->createElement('text', 'name')
                 ->setLabel('Name')
                 ->setRequired(true)
        );

        $this->addElement(
            $this->createElement('text', 'email')
                 ->setLabel('Email')
                 ->setRequired(true)
        );

        $this->addElement(
            $this->createElement('textarea', 'details')
                 ->setLabel('Your Message')
                 ->setRequired(true)
        );

        $this->addElement(
            $this->createElement('submit', 'send')
                 ->setLabel('Send')
        );
    }

}
