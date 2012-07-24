<?php

/**
 * 
 * Classe responsável pela abstração da visão vmensagensenviadas do banco de 
 * dados.
 * 
 * @package DarthSCM
 * @subpackage models
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class VMsgEnviada extends Zend_Db_Table_Abstract
{
     protected $_name = 'vmensagensenviadas';
     protected $_primary = 'idremetente';
}