<?php

/**
 * 
 * Classe responsável pela abstração da tabela usuarios do banco de dados.
 * 
 * @package DarthSCM
 * @subpackage models
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class Usuarios extends Zend_Db_Table_Abstract
{
    /** 
     * Nome da tabela no banco de dados.
     * 
     * @access protected 
     * @name $_name 
     */ 
    protected $_name = 'usuarios';
          
     /** 
      * Sequência da tabela.
      * 
      * @access protected 
      * @name $_sequence 
      */    
    protected $_sequence = 'usuarios_idusuario_seq';
    
    /** 
      * Tabelas referenciadas.
      * 
      * @access protected 
      * @name $_depedentTables
      */
    protected $_depedentTables = array('usuariotrabalhaemprojeto');
    
    /** 
      * Mapeamento das referências.
      * 
      * @access protected 
      * @name $_referenceMap
      */ 
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
    
    /**
     * Verifica se o e-mail já está cadastrado no banco de dados.
     *
     * @author Elenildo João
     * @access public
     * @param String $email
     * @return boolean
     *
     */
    
    public function emailJaExiste($email) 
    {
        $select = $this->select()
                ->from($this->_name, 'COUNT(*) AS num')
                ->where('email = ?', $email);

        return ($this->fetchRow($select)->num) ? true : false; 
    }
    
    /**
     * Verifica se o cpf já está cadastrado no banco de dados.
     *
     * @author Elenildo João
     * @access public
     * @param String $cpf
     * @return boolean
     *
     */
    
    public function cpfJaExiste($cpf) 
    {
        $select = $this->select()
                ->from($this->_name, 'COUNT(*) AS num')
                ->where('cpf = ?', $cpf);

        return ($this->fetchRow($select)->num) ? true : false; 
    }

}