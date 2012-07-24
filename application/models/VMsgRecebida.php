<?php

/**
 * 
 * Classe responsável pela abstração da visão vmensagensrecebidas do banco de 
 * dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class VMsgRecebida extends Zend_Db_Table_Abstract
{
     protected $_name = 'vmensagensrecebidas';
     protected $_primary = 'destinatario';
}
