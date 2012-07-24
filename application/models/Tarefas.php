<?php

/**
 * 
 * Classe responsável pela abstração da tabela tarefas do banco de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Jacqueline Midlej
 * @version 0.1
 * @access public
 *
 */

class Tarefas extends Zend_Db_Table_Abstract
{

    	/** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */ 
    protected $_name = 'tarefas';
    
    /** 
      * Sequência da tabela.
      * 
      * @access protected 
      * @name $_sequence 
      */ 
    protected $_sequence = 'tarefas_idtarefa_seq';
    
    /** 
      * Tabelas referenciadas.
      * 
      * @access protected 
      * @name $_depedentTables
      */
    protected $_depedentTables = array('usuariorealizatarefa');
    
    /** 
      * Mapeamento das referências.
      * 
      * @access protected 
      * @name $_referenceMap
      */ 
    protected $_referenceMap = array(
        'projetos' => array(
            'columns'       => 'idprojeto',
            'refTableClass' => 'Projetos',
            'refColumns'    => 'idprojeto'
        ),
        'superTaferas' => array(
            'columns'       => array('idsupertarefa', 'idsuperprojeto'),
            'refTableClass' => 'Tarefas',
            'refColumns'    => array ('idtarefa', 'idprojeto')
        )
    );
}
?>
