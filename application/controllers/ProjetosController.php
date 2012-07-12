<?php

class ProjetosController extends Zend_Controller_Action
{

    private $projeto;
    private $repositorio;
    private $trabalhaEm;
    private $usuario;
    private $tarefa = null;
    private $realiza = null;
    private $vUsuarioProjeto;
    private $vTarefaUsuario = null;
    private $vRealiza = null;
    private $vSubTarefa;
    private $vRelatorioCol;
    private $vRelatorioProj;
    private $db;

    public function init()
    {
        $this->projeto = new Projetos();
        $this->repositorio = new Repositorios();
        $this->trabalhaEm = new TrabalhaEm();
        $this->usuario = new Usuarios();
        $this->tarefa = new Tarefas();
        $this->realiza = new Realiza();
        $this->vUsuarioProjeto = new VUsuarioProjeto();
        $this->vTarefaUsuario = new VTarefaUsuario();
        $this->vRealiza = new VRealiza();
        $this->vSubTarefa = new VSubTarefa();
        $this->vRelatorioCol = new VRelatorioProdCol();
        $this->vRelatorioProj = new VRelatorioProdProj();
        $this->db = Zend_Db_Table::getDefaultAdapter();
    }

    public function indexAction()
    {
        $this->_forward('listar');
    }
    
    public function listarAction()
    {
        $this->view->projetos = $this->vUsuarioProjeto
                ->fetchAll(
                        $this->vUsuarioProjeto->select()->where('papel= ? ', 'gerente')
                        ->order('datainicioprojeto DESC')
                        );
    }
    
    public function novoAction()
    {
        if ( !$this->_request->isPost() )
            $this->view->usuarios = $this->usuario->fetchAll();
        else
        {
            $dadosRepositorio = array(
                'endereco' => $this->_request->getPost('repositorio'),
                'nome'     => 'default',
                'conta'    => 'default'
            );
            
            $dadosProjeto = array(
                'nome'        => $this->_request->getPost('nome'),
                'descricao'   => $this->_request->getPost('descricao'),
                'datainicio'  => $this->_request->getPost('dataInicio'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim')
            );
            
            $dadosTrabalhaEm = array(
                'idusuario'  => $this->_request->getPost('gerente'),
                'papel'      => 'GERENTE',
                'datainicio' => $dadosProjeto['datainicio']
            );
            
            $this->repositorio->insert($dadosRepositorio);
            
            $dadosProjeto['idrepositorio'] = $this->db->lastInsertId('repositorios', 'idrepositorio');
            
            $this->projeto->insert($dadosProjeto);
            
            $dadosTrabalhaEm['idprojeto'] = $this->db->lastInsertId('projetos', 'idprojeto');
            
            $this->trabalhaEm->insert($dadosTrabalhaEm);
        
            $this->_redirect('/projetos/listar');
        }
    }
    
    public function editarAction()
    {     
        if ( !$this->_request->isPost() )
        {           
            $idProjeto = (int) $this->_getParam('id'); 
            
            $projeto = $this->projeto->find($idProjeto)->current();
            
            $selectGerente = $this->trabalhaEm->select()
                                       ->where('idprojeto = ?', $projeto->idprojeto)
                                       ->where('papel = ?', 'GERENTE');
            
            $idGerente = $this->trabalhaEm->fetchRow($selectGerente)->idusuario;
            
            $this->view->gerente = $this->usuario->find($idGerente)->current();            
            $this->view->projeto  = $projeto;
            $this->view->repositorio  = $projeto->findParentRepositorios();
        }
        else
        {
            $dadosProjetos = array(
                'nome'        => $this->_request->getPost('nome'),
                'descricao'   => $this->_request->getPost('descricao'),
                'datainic'    => $this->_request->getPost('dataInic'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim')
            );
                        
            $dadosRepositorio = array(
                'endereco' => $this->_request->getPost('endereco')
            );
            
            $idProjeto = $this->_request->getPost('idProjeto');
            $idRepositorio = $this->_request->getPost('idRepositorio');
            
            $whereProjeto = $this->projeto->getAdapter()->quoteInto('idprojeto = ?', (int) $idProjeto);
            $whereRepositorio = $this->repositorio->getAdapter()->quoteInto('idrepositorio = ?', (int) $idRepositorio);
            
            $this->projeto->update($dadosProjetos, $whereProjeto);
            $this->repositorio->update($dadosRepositorio, $whereRepositorio); 
        
            $this->_redirect('/projetos/listar');
        }
    }
    
    public function removerAction()
    {
        $idUsuario = (int) $this->_getParam('id'); 
        $usuario = $this->usuario->find($idUsuario)->current();
        
        $whereEndereco = $this->endereco->getAdapter()->quoteInto('idendereco = ?', (int) $usuario->endereco);
        $whereLogin = $this->login->getAdapter()->quoteInto('idusuario = ?', (int) $idUsuario);
        $whereUsuario = $this->usuario->getAdapter()->quoteInto('idusuario = ?', (int) $idUsuario);
        
        $this->login->delete($whereLogin);
        $this->usuario->delete($whereUsuario);
        $this->endereco->delete($whereEndereco);
        
        $this->_redirect('/usuarios/listar');
    }

    public function listarTarefasAction()
    {
        $this->view->tarefas = $this->tarefa
                ->fetchAll(
                        $this->tarefa->select()->order('nome')
                        );
        
        $this->view->vRealiza = $this->vRealiza
                ->fetchAll(
                        $this->vRealiza->select()->order('nome')
                        );
        
        $this->view->VTarefaUsuario = $this->vTarefaUsuario
                ->fetchAll(
                        $this->vTarefaUsuario->select()->order('nomeusuario')
                        );
    }      
    public function novaTarefaAction()
    {
        if ( !$this->_request->isPost() ){
            $this->view->usuarios = $this->usuario->fetchAll();
            $this->view->projetos = $this->projeto->fetchAll();
        } 
        else
        {   
            $dadosTarefa = array(
                'idprojeto' => $this->_request->getPost('nomeproj'),
                'nome' => $this->_request->getPost('nome'),
                'descricao'   => $this->_request->getPost('descricao'),
                'datainicio'  => $this->_request->getPost('dataInicio'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim'),
                'prioridade' => $this->_request->getPost('prioridade')
            );
            
            $dadosRealiza = array(
                'idprojeto'  => $this->_request->getPost('nomeproj'),
                'idusuario'  => $this->_request->getPost('responsavel'),
                'tempo'      => '00:00:00',
                'datainicio' => $this->_request->getPost('dataInicio')
            );
                        
            $this->tarefa->insert($dadosTarefa);
            
            $dadosRealiza['idtarefa'] = $this->db->lastInsertId('tarefas', 'idtarefa');

            $this->realiza->insert($dadosRealiza);
        
            $this->_redirect('/projetos/listar-tarefas');
        }
    }

    public function editarTarefaAction(){
        if ( !$this->_request->isPost() )
        {
            $idTarefa = (int) $this->_getParam('idtarefa'); 
            $idProjeto = (int) $this->_getParam('idprojeto'); 
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->tarefa  = $tarefa;
        }
        else
        {
            $dadosTarefas = array(
                'nome'     => $this->_request->getPost('nome'),
                'descricao'    => $this->_request->getPost('descricao'),
                'datainicio'      => $this->_request->getPost('dataInicio'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim'),
                'prioridade' => $this->_request->getPost('prioridade')
            );
            
            $idTarefa = $this->_request->getPost('idtarefa');
            
            $whereTarefa = $this->tarefa->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);
            
            $this->tarefa->update($dadosTarefas, $whereTarefa);
        
            $this->_redirect('/projetos/listar-tarefas');
        }
    }

    public function removeTarefa($idTarefa, $idProjeto) {
        $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();

        $whereRealiza = $this->realiza->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);
        $whereTarefa = $this->tarefa->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);

        $this->realiza->delete($whereRealiza);

        $subTarefas = $this->tarefa->fetchAll($this->tarefa->select()->where('idsupertarefa = ?', $idTarefa));
        foreach ( $subTarefas as $subTarefa ){
            $this->removeTarefa($subTarefa->idtarefa, $subTarefa->idprojeto);
        }

        $this->tarefa->delete($whereTarefa);
}

    public function removerTarefaAction(){
        $idTarefa = (int) $this->_getParam('idtarefa');
        $idProjeto = (int) $this->_getParam('idprojeto'); 

        $this->removeTarefa($idTarefa, $idProjeto);
        
        $this->_redirect('/projetos/listar-tarefas');
    }

    public function fecharTarefaAction(){
        $idTarefa = $this->_request->getParam('idtarefa');
        $this->fechaTarefa($idTarefa);
        $this->_redirect('/projetos/listar-tarefas');
    }
    
    public function fechaTarefa($idTarefa){
        $dados = array(
            'datafim' => date("Y-m-d")
        );

        $usuariosTarefas = $this->vRealiza->fetchAll($this->vRealiza->select()->where('idtarefa = ?', $idTarefa));

        foreach ( $usuariosTarefas as $usuarioTarefa ){
            $whereRealiza = $this->realiza->getAdapter()->quoteInto('idtarefa = ?', (int) $usuarioTarefa->idtarefa);
            $this->realiza->update($dados, $whereRealiza);
        }

        $subTarefas = $this->vSubTarefa->fetchAll($this->vSubTarefa->select()->where('idsupertarefa = ?', $idTarefa));
        foreach ( $subTarefas as $subTarefa ){
            $this->fechaTarefa($subTarefa->idtarefa);
        }

        $whereTarefa = $this->tarefa->getAdapter()->quoteInto('idtarefa = ?', (int) $idTarefa);
        $this->tarefa->update($dados, $whereTarefa);
    }
    
    public function alocarUsuarioTarefaAction(){
        if ( !$this->_request->isPost() )
        {
            $idProjeto = (int) $this->_getParam('idprojeto');
            $idTarefa = (int) $this->_getParam('idtarefa'); 
            $usuarioProjeto = $this->vUsuarioProjeto->find($idProjeto);
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current(); 
            $usuarioTarefa = $this->vRealiza->find($idTarefa, $idProjeto);
            $this->view->vUsuarioProjeto  = $usuarioProjeto;
            $this->view->vRealiza = $usuarioTarefa; 
            $this->view->tarefa  = $tarefa;
        }
        else
        {
            $idTarefa=$this->_request->getPost('idtarefa');
            $idProjeto=$this->_request->getPost('idprojeto');
            $idUsuario=$this->_request->getPost('usuario');
            $dadosRealiza = array(
                'idtarefa'     => $idTarefa,
                'idprojeto'     => $idProjeto,
                'idusuario'    => $idUsuario,
                'datainicio'      => date("Y-m-d"),
                'tempo' => '00:00:00'
            );

            $dadosAtualiza = array('datafim' => null);
            
            $usuRealizaTar = $this->realiza->find($idTarefa, $idProjeto, $idUsuario)->current();
            
            if($usuRealizaTar){
                $whereAtualiza = $this->realiza->getAdapter()->quoteInto(array('idtarefa = ?' => (int) $idTarefa, 'idusuario = ?' => (int) $idUsuario));
                $this->realiza->update($dadosAtualiza, $whereAtualiza);
            }
            else{
                $this->realiza->insert($dadosRealiza);
            }
            
            $this->_redirect('/projetos/listar-tarefas');
        }
    }

    public function desalocarUsuarioTarefaAction(){
        if ( !$this->_request->isPost() )
        {
            $idProjeto = (int) $this->_getParam('idprojeto');
            $idTarefa = (int) $this->_getParam('idtarefa'); 
            $usuariosTarefas = $this->vRealiza->find($idTarefa, $idProjeto);
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->vRealiza  = $usuariosTarefas;
            $this->view->tarefa  = $tarefa; 
        }
        else
        {
            $dadosRealiza = array(
                'datafim'      => date("Y-m-d")
            );
            $idProjeto = $this->_request->getPost('idprojeto');             
            $idTarefa = $this->_request->getPost('idtarefa'); 
            $idUsuario = $this->_request->getPost('usuario'); 
            
            $usuariosTarefas = $this->vRealiza->fetchAll($this->vRealiza->select()->where('idtarefa = ?', $idTarefa)->where ('idusuario = ?', $idUsuario));
            foreach ( $usuariosTarefas as $usuarioTarefa ){
                $whereRealiza = $this->realiza->getAdapter()->quoteInto(array('idusuario = ?' => (int) $usuarioTarefa->idusuario, 'idtarefa = ?' => (int) $usuarioTarefa->idtarefa));
                $this->realiza->update($dadosRealiza, $whereRealiza);
            }

            $this->_redirect('/projetos/listar-tarefas');
        }
    }
    public function novaSubTarefaAction()
    {
        if ( !$this->_request->isPost() ){
            $idProjeto = $this->_getParam('idprojeto');
            $idTarefa = $this->_getParam('idtarefa'); 
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $usuarioProjeto = $this->vUsuarioProjeto->find($idProjeto);
            $this->view->vUsuarioProjeto = $usuarioProjeto;
            $this->view->tarefa = $tarefa;
        } 
        else
        {
            $idProjeto = $this->_request->getPost('idprojeto');             
            $idTarefa = $this->_request->getPost('idtarefa'); 
            $dadosTarefa = array(
                'idprojeto' => $idProjeto,
                'nome' => $this->_request->getPost('nome'),
                'descricao'   => $this->_request->getPost('descricao'),
                'datainicio'  => $this->_request->getPost('dataInicio'),
                'dataprevfim' => $this->_request->getPost('dataPrevFim'),
                'prioridade' => $this->_request->getPost('prioridade'),
                'idsupertarefa' => $idTarefa,
                'idprojetosupertarefa' => $idProjeto
            );
            
            $dadosRealiza = array(
                'idprojeto'  => $idProjeto,
                'idusuario'  => $this->_request->getPost('responsavel'),
                'tempo'      => '00:00:00',                        
                'datainicio' => $this->_request->getPost('dataInicio')
            );
                        
            $this->tarefa->insert($dadosTarefa);
            
            $dadosRealiza['idtarefa'] = $this->db->lastInsertId('tarefas', 'idtarefa');

            $this->realiza->insert($dadosRealiza);
        
            $this->_redirect('/projetos/listar-tarefas');
        }
    }
            
    public function adicionarTempoAction(){        
        if ( !$this->_request->isPost() )
        {
            $idProjeto = (int) $this->_getParam('idprojeto');
            $idTarefa = (int) $this->_getParam('idtarefa'); 
            $tarefaUsuario = $this->vTarefaUsuario->find($idTarefa, $idProjeto);
            $this->view->vTarefaUsuario  = $tarefaUsuario;
            $tarefa = $this->tarefa->find($idTarefa, $idProjeto)->current();
            $this->view->tarefa  = $tarefa;
        }
        else
        {    
            $int1=new DateInterval('P0D');
            
            $idTarefa=$this->_request->getPost('idtarefa');
            $idProjeto=$this->_request->getPost('idprojeto');                        
            $idUsuario=$this->_request->getPost('usuario');
            
            $int1->d=$this->_request->getPost('dias');
            $int1->h=$this->_request->getPost('horas');
            $int1->i=$this->_request->getPost('minutos');
            
            $realiza = $this->realiza->find($idTarefa, $idProjeto, $idUsuario)->current();
            
            $tempo=$realiza->tempo;
            
            $x=0; 
            $flagd=0; 
            $d2="0";
            while ($x<strlen($tempo)-1){
                if ($tempo[$x]=='d'){
                   for ($y=0; $y<$x-1; $y++)
                       $d2=$d2.$tempo[$y];
                   $flagd=1;
                   break;
                }
                $x++;
            }
            if ($flagd==0)
                $x=0;
            while ($x<strlen($tempo)-1){
                if ($tempo[$x]==' '){
                    $h2=$tempo[++$x].$tempo[++$x];
                    $x++;
                    $m2=$tempo[++$x].$tempo[++$x];
                    break;
                }
            $x++;
            }
                        
            $int2=new DateInterval('P0D');
            $int2->d=$d2;
            $int2->h=$h2;
            $int2->i=$m2;
            
            $int2=$this->SomaInterval($int1, $int2);
            
            if ($int2->d==0){
                $dadosRealiza = array(
                    'tempo'      => $int2->h.':'.$int2->i.':00'
                );
            }
            else {
                $dadosRealiza = array(
                    'tempo'      => $int2->d.' '.$int2->h.':'.$int2->i.':00'
                );
            }  
            $whereRealiza = $this->realiza->getAdapter()->quoteInto(array('idusuario = ?' => (int) $idUsuario, 'idtarefa = ?' => (int) $idTarefa));
            $this->realiza->update($dadosRealiza, $whereRealiza);
            $this->_redirect('/projetos/listar-tarefas');
        } 
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

     public function relatorioColaboradorAction (){
     
        $this->view->vRelatorioCol = $this->vRelatorioCol
                ->fetchAll(
                        $this->vRelatorioCol->select()->order('nomeprojeto')->order('nomeusuario')
                        );
     }
     
     public function relatorioProjetoAction (){
     
     $this->view->vRelatorioProj = $this->vRelatorioProj
                ->fetchAll(
                        $this->vRelatorioProj->select()->order('nomeprojeto')
                        );
     }
     
     public function graficoRelColaboradorAction (){
     
        $this->view->vRelatorioCol = $this->vRelatorioCol
                ->fetchAll(
                        $this->vRelatorioCol->select()->order('nomeusuario')
                        );
        $this->view->visao1 = $this->vRelatorioCol
                ->fetchAll(
                        $this->vRelatorioCol->select()->order('nomeprojeto')->order('nomeusuario')
                        );
     }
     
     public function detalharProjetoAction () {
         
         $idProjeto = (int) $this->_getParam('id');
         $projeto = $this->projeto->find($idProjeto)->current();
         
         $this->view->tarefas = $this->tarefa
                   ->fetchAll(
                        $this->tarefa->select()->where('idprojeto = ?', $idProjeto)->order('nome')
                        );
         $this->view->projeto = $projeto;
         
     }
}

