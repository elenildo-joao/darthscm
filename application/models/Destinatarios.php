<?php

/**
 * 
 * Classe responsável pela abstração da tabela destinatários do banco de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Caique Pires
 * @version 0.1
 * @access public
 *
 */

class Destinatarios extends Zend_Db_Table_Abstract
{

    /** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */
    protected $_name = 'destinatarios';
    
    /** 
      * Tabelas referenciadas.
      * 
      * @access protected 
      * @name $_depedentTables
      */
    protected $_depedentTables = array('usuarios', 'mensagens'); 
    
    /** 
      * Mapeamento das referências.
      * 
      * @access protected 
      * @name $_referenceMap
      */ 
    protected $_referenceMap = array(
        'mensagens' => array(
            'columns'       => 'idmensagem',
            'refTableClass' => 'Mensagens',
            'refColumns'    => 'idmensagem'
        ),
        'mensagens' => array(
            'columns'       => 'remetente',
            'refTableClass' => 'Mensagens',
            'refColumns'    => 'remetente'
        ),
        'usuarios' => array(
            'columns'       => 'destinatario',
            'refTableClass' => 'Usuarios',
            'refColumns'    => 'idUsuario'
        )
    );

}