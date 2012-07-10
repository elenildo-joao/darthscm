<?php
class VSubTarefa extends Zend_Db_Table_Abstract
{

    protected $_name = 'vsubtarefas';
    protected $_depedentTables = array('usuariorealizatarefa');
    protected $_primary = array('idtarefa', 'idprojeto');
 }

?>
