<?php

class Projetos extends Zend_Db_Table_Abstract
{

    protected $_name = 'projetos';
    protected $_sequence = 'projetos_idprojeto_seq';
    protected $_depedentTables = array('usuariotrabalhaemprojeto');
    
    protected $_referenceMap = array(
        'repositorios' => array(
            'columns'       => 'idrepositorio',
            'refTableClass' => 'Repositorios',
            'refColumns'    => 'idrepositorio'
        )
    );
}

