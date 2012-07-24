<?php

/**
 * 
 * Classe responsável pela abstração da tabela projetos do banco de dados.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class Projetos extends Zend_Db_Table_Abstract
{

    protected $_name = 'projetos';
    protected $_sequence = 'projetos_idprojeto_seq';
    protected $_depedentTables = array('usuariotrabalhaemprojeto');
    
    protected $_referenceMap = array(
        'repositorios' => array(
            'columns'       => 'idrepositorio',
            'refTableClass' => 'Repositorios',
            'refColumns'    => 'idrepositorio'
        )
    ); 

    /**
     * 
     *
     * @author Jacqueline Midlej
     * @access public
     * @param int $tempo
     * @param int $int2
     * @return void
     *
     */
    public function trataInterval ($tempo, $int2){
        $x=0;  
        $flagd=0;
            $d2="";
            $h2="";
            $m2="";
        while ($x<strlen($tempo)-1){
            if ($tempo[$x]=='d'){
            for ($y=0; $y<$x-1; $y++)
                $d2=$d2.$tempo[$y];
            $flagd=1;
            break;
            }
            $x++;
        }    
        if ($flagd==1){
            $flags=0;
            while ($x<strlen($tempo)-1){
                if ($tempo[$x]==' '){
                    $x++;
                    $flags=1;
                    while ($tempo[$x]!=':')
                        $h2=$h2.$tempo[$x++];
                    $x++;
                    while ($tempo[$x]!=':')
                        $m2=$m2.$tempo[$x++];
                } 
                $x++;
            }
            if ($flags==0){
                $x=0; 
                            $h2="0"; 
                $m2="0"; $d2="";
                while ($x<strlen($tempo)-1){
                        while ($tempo[$x]!=' '){
                        $d2=$d2.$tempo[$x++];
                                            if ($tempo[$x]==' ')
                                                    break;
                                            }
                                            $x=strlen($tempo);
                }
            } 
        } 
        else
        { 
            $x=0; 
                    $d2=0;
            while ($x<strlen($tempo)-1){
                    while ($tempo[$x]!=':'){
                        $h2=$h2.$tempo[$x++]; 
                                            if ($tempo[$x]==':') 
                                                    break;
                                    }
                    $x++;
                    while ($tempo[$x]!=':'){ 
                        $m2=$m2.$tempo[$x++];
                                            if ($tempo[$x]==':') 
                                            break;
                                            }
                $x=strlen($tempo);
            }
        }
        $int2->d=$d2;
        $int2->h=$h2;
        $int2->i=$m2; 
        }
        
    /**
     * 
     *
     * @author Jacqueline Midlej
     * @access public
     * @param int $int1
     * @param int $int2
     * @return $int2
     *
     */
        
    public function SomaInterval($int1, $int2){
        $min=$int2->i+$int1->i;
        $hora=$int2->h+$int1->h;
        $dia=$int2->d+$int1->d;
        if ($min>59){
            $hora=$hora+(int)$min/60;
            $min=$min%60;
        }
        $int2->i=$min;        
        if ($hora>23){
            $dia=$dia+(int)$hora/24;
            $hora=$hora%24;
        }
        $int2->h=$hora;
        $int2->d=$dia;
        return $int2;
    }
}

