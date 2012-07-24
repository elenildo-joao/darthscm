<?php

/**
 * 
 * Classe responsável pela abstração da visão vusuarioprojeto do banco de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class VUsuarioProjeto extends Zend_Db_Table_Abstract
{
    
    /** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */ 
     protected $_name = 'vusuarioprojeto';
     
     /** 
      * Chave primária da tabela.
      * 
      * @access protected 
      * @name $_primary 
      */ 
     protected $_primary = 'idprojeto';
     
     /** 
      * Mapeamento das referências.
      * 
      * @access protected 
      * @name $_referenceMap
      */ 
     protected $_referenceMap = array(
        'repositorios' => array(
            'columns'       => 'idrepositorio',
            'refTableClass' => 'Repositorios',
            'refColumns'    => 'idrepositorio'
        )
    );

}