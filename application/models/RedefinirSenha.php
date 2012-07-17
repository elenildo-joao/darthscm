<?php

class RedefinirSenha extends Zend_Db_Table_Abstract
{

    protected $_name = 'destinatarios';
    protected $_depedentTables = array('usuarios', 'mensagens');
    
}

