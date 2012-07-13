<?php

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

