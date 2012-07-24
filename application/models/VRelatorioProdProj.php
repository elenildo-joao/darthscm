<?php

/**
 * 
 * Classe responsável pela abstração da visão vrelatorioprodproj do banco de 
 * dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class VRelatorioProdProj extends Zend_Db_Table_Abstract
{
     protected $_name = 'vrelatorioprodproj';
     protected $_primary = array('idprojeto');
     
}