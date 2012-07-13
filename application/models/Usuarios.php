<?php

class Usuarios extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuarios';
    protected $_sequence = 'usuarios_idusuario_seq';
    protected $_depedentTables = array('usuariotrabalhaemprojeto');
    
    protected $_referenceMap = array(
        'enderecos' => array(
            'columns'       => 'endereco',
            'refTableClass' => 'Enderecos',
            'refColumns'    => 'idendereco'
        ),
        'login' => array(
            'columns'       => 'idusuario',
            'refTableClass' => 'Login',
            'refColumns'    => 'idusuario'
        )
    );
    
    public function emailJaExiste($email) 
    {
        $select = $this->select()
                ->from($this->_name, 'COUNT(*) AS num')
                ->where('email = ?', $email);

        return ($this->fetchRow($select)->num) ? true : false; 
    }
    
    public function cpfJaExiste($cpf) 
    {
        $select = $this->select()
                ->from($this->_name, 'COUNT(*) AS num')
                ->where('cpf = ?', $cpf);

        return ($this->fetchRow($select)->num) ? true : false; 
    }

}