<?php

/**
 * 
 * Classe responsável pela abstração da tabela mensagens do banco de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Caique pires
 * @version 0.1
 * @access public
 *
 */

class Mensagens extends Zend_Db_Table_Abstract
{
    
    	/** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */
    protected $_name = 'mensagens';
    
      /** 
      * Sequência da tabela.
      * 
      * @access protected 
      * @name $_sequence 
      */ 
    protected $_sequence = 'mensagens_idmensagem_seq'; 
    
    /** 
      * Tabelas referenciadas.
      * 
      * @access protected 
      * @name $_depedentTables
      */
    protected $_depedentTables = array('usuarios', 'destinatarios');
          
     /** 
      * Mapeamento das referências.
      * 
      * @access protected 
      * @name $_referenceMap
      */ 
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
