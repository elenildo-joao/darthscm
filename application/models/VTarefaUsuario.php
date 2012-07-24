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
    /** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */ 
    protected $_name = 'vtarefausuario'; 
    
     /** 
      * Chave primária da tabela.
      * 
      * @access protected 
      * @name $_primary 
      */ 

     protected $_primary = array('idtarefa', 'idprojeto');
}