<?php

class Repositorios extends Zend_Db_Table_Abstract
{

    protected $_name = 'repositorios';
    protected $_sequence = 'repositorios_idrepositorio_seq';
    protected $_depedentTables = array('projetos', 'vusuarioprojeto');
}

