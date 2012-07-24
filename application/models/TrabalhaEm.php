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

    protected $_name = 'usuariotrabalhaemprojeto';
    protected $_primary = array('idusuario', 'idprojeto');    
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

