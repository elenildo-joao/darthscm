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
    /** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */  
     protected $_name = 'vrelatorioprodproj';
     
     /** 
      * Chave primária da tabela.
      * 
      * @access protected 
      * @name $_primary 
      */
     protected $_primary = array('idprojeto');
     
}