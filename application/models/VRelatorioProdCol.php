<?php

/**
 * 
 * Classe responsável pela abstração da visão vrelatorioprodcol do banco de 
 * dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class VRelatorioProdCol extends Zend_Db_Table_Abstract
{
     protected $_name = 'vrelatorioprodcol';
     protected $_primary = array('idusuario', 'idprojeto');
     
}