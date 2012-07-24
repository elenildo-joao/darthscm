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
     protected $_name = 'vusuarioprojeto';
     protected $_primary = 'idprojeto';
     
     protected $_referenceMap = array(
        'repositorios' => array(
            'columns'       => 'idrepositorio',
            'refTableClass' => 'Repositorios',
            'refColumns'    => 'idrepositorio'
        )
    );

}

