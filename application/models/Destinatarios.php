<?php

class Destinatarios extends Zend_Db_Table_Abstract
{

    protected $_name = 'destinatarios';
    protected $_depedentTables = array('usuarios', 'mensagens');

    
    
    protected $_referenceMap = array(
        'mensagens' => array(
            'columns'       => 'idmensagem',
            'refTableClass' => 'Mensagens',
            'refColumns'    => 'idmensagem'
        ),
        'mensagens' => array(
            'columns'       => 'remetente',
            'refTableClass' => 'Mensagens',
            'refColumns'    => 'remetente'
        ),
        'usuarios' => array(
            'columns'       => 'destinatario',
            'refTableClass' => 'Usuarios',
            'refColumns'    => 'idUsuario'
        )
    );


}

