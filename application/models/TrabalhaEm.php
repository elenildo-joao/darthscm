<?php

/**
 * 
 * Classe responsável pela abstração da tabela usuariotrabalhaemprojeto do banco 
 * de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class TrabalhaEm extends Zend_Db_Table_Abstract
{

    /** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */ 
    protected $_name = 'usuariotrabalhaemprojeto';
    
    /** 
      * Chave primária da tabela.
      * 
      * @access protected 
      * @name $_primary 
      */ 
    protected $_primary = array('idusuario', 'idprojeto');
    
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
        'projetos' => array(
            'columns'       => 'idprojeto',
            'refTableClass' => 'Projetos',
            'refColumns'    => 'idprojeto'
        )
    );
}

