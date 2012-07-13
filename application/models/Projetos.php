<?php

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
    public function trataInterval ($tempo, $int1, $int2, $d2, $h2, $m2){
    $x=0;  
    $flagd=0;

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
        $flagsd=0;
        while ($x<strlen($tempo)-1){
            if ($tempo[$x]==' '){
                $x++;
                $flagsd=1;
                while ($tempo[$x]!=':')
                    $h2=$h2.$tempo[$x++];
                $x++;
                while ($tempo[$x]!=':')
                    $m2=$m2.$tempo[$x++];
            } 
            $x++;
        }
        if ($flagsd==0){
            $x=0; $h2="0"; 
            $m2="0";
            while ($x<strlen($tempo)-1){
                    while ($tempo[$x]!='d')
                    $d2=$d2.$tempo[$x++];
            }
        } 
    } 
    else
    { 
        $x=0; $d2=0;
        
        while ($x<strlen($tempo)-1){
                
                while ($tempo[$x]!=':')
                    $h2=$h2.$tempo[$x++];
                //$x++;
                while ($tempo[$x]!=':')
                    $m2=$m2.$tempo[$x++];
            $x++;
        }
    }
    $int2->d=$d2;
    $int2->h=$h2;
    $int2->i=$m2; 
    } 
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

