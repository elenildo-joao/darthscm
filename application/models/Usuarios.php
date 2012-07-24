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