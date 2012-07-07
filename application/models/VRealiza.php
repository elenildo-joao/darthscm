<?php
class VRealiza extends Zend_Db_Table_Abstract
{
     protected $_name = 'vrealiza';
     protected $_primary = array('idtarefa', 'idprojeto', 'idusuario');
}

?>
