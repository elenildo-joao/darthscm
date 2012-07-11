<?php

class Login extends Zend_Db_Table_Abstract 
{
    
    protected $_name = 'login';
    protected $_sequence = 'login_idlogin_seq';
    protected $_depedentTables = array('usuarios');
    
}


