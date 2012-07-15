<?php

class Mensagens extends Zend_Db_Table_Abstract
{

    protected $_name = 'mensagens';
    protected $_sequence = 'mensagens_idmensagem_seq';
    
    protected $_depedentTables = array('usuarios', 'destinatarios');

    
    
    protected $_referenceMap = array(
        'usuarios' => array(
            'columns'       => 'remetente',
            'refTableClass' => 'Usuarios',
            'refColumns'    => 'idusuario'
        ),
        'destinatarios' => array(
            'columns'   =>  'idmensagem',
            'refTableClass' => 'Mensagens',
            'refColumns'    => 'idmensagem'
        )
    );
    
//    public function emailJaExiste($email) 
//    {
//        $select = $this->select()
//                ->from($this->_name, 'COUNT(*) AS num')
//                ->where('email = ?', $email);
//
//        return ($this->fetchRow($select)->num) ? true : false; 
//    }
//    
//    public function cpfJaExiste($cpf) 
//    {
//        $select = $this->select()
//                ->from($this->_name, 'COUNT(*) AS num')
//                ->where('cpf = ?', $cpf);
//
//        return ($this->fetchRow($select)->num) ? true : false; 
//    }
    
}

?>
