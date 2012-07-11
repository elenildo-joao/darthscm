<?php

class Enderecos extends Zend_Db_Table_Abstract
{

    protected $_name = 'enderecos';
    protected $_sequence = 'enderecos_idendereco_seq';
    protected $_depedentTables = array('usuarios');
    
}

