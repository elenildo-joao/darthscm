<?php

/**
 * 
 * Classe responsável pela abstração da tabela usuariorealizatarefa do banco de 
 * dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class Realiza extends Zend_Db_Table_Abstract
{

    /** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */ 
    protected $_name = 'usuariorealizatarefa';
    
    /** 
      * Chave primária da tabela.
      * 
      * @access protected 
      * @name $_primary 
      */   
    protected $_primary = array('idtarefa', 'idprojeto', 'idusuario');
    
    /** 
      * Mapeamento das referências.
      * 
      * @access protected 
      * @name $_referenceMap
      */ 
    protected $_referenceMap = array(
        'usuarios' => array(
            'columns'       => 'idusuario',
            'refTableClass' => 'Usuarios',
            'refColumns'    => 'idusuario'
        ),
        'tarefas' => array(
            'columns'       => array('idtarefa','idprojeto'),
            'refTableClass' => 'Tarefas',
            'refColumns'    => array('idtarefa','idprojeto')
        )
    );
}
?>
