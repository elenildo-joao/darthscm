<?php

/**
 * 
 * Classe responsável pela abstração da visão vtarefausuario do banco de 
 * dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class VTarefaUsuario extends Zend_Db_Table_Abstract
{
     protected $_name = 'vtarefausuario';
     protected $_primary = array('idtarefa', 'idprojeto');
}