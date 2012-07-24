<?php

/**
 * 
 * Classe responsável pelo envio de e-mail.
 *
 * @package DarthSCM
 * @subpackage models
 * @author Elenildo João
 * @version 0.1
 * @access public
 *
 */

class Email{
    
    /** 
     * Mensagem do e-mail.
     * 
     * @access private 
     * @name $mensagem 
     */ 
    private $mensagem;
    
    /** 
     * Assunto do e-mail.
     * 
     * @access private 
     * @name $assunto 
     */ 
    private $assunto;
    
    /** 
     * Destinatário do e-mail.
     * 
     * @access private 
     * @name $destinatario
     */ 
    private $destinatario;

    /**
     * Construtor da classe.
     *
     * @author Elenildo João
     * @access public
     * @param String $mensagem
     * @param String $assunto
     * @param String $destinatarioEmail
     * @param String $destinatarioNome
     * @return void
     *
     */
    
    public function  __construct($mensagem, $assunto, $destinatarioEmail, $destinatarioNome) {
        $this->assunto = utf8_decode($assunto);
        $this->mensagem = $mensagem;
        $this->destinatario['email'] = utf8_decode($destinatarioEmail);
        $this->destinatario['nome'] = utf8_decode($destinatarioNome);
    }

    /**
     * Envia o e-mail.
     *
     * @author Elenildo João
     * @access public
     * @return void
     *
     */
    
    public function enviar(){
        $smtp = "smtp.gmail.com";
        $mailTransport = new Zend_Mail_Transport_Smtp($smtp, $this->getConfiguracao());

        $mail = new Zend_Mail();
        $mail->setBodyHtml($this->mensagem, 'utf-8');
        $mail->setFrom('sithsolutions.contato@gmail.com', utf8_decode('DarthSCM') );
        $mail->addTo($this->destinatario['email'], $this->destinatario['nome']);
        $mail->setSubject($this->assunto);
        $mail->send($mailTransport);
    }
    
    /**
     * Função responsável pela configuração da conta pela qual o e-mail vai ser 
     * enviado.
     *
     * @author Elenildo João
     * @access public
     * @return $config Informações da conta
     *
     */
    
    private function getConfiguracao(){        
        $conta = "sithsolutions.contato@gmail.com";
        $senha = "sithdarth";

        $config = array (
            'auth' => 'login',
            'username' => $conta,
            'password' => $senha,
            'ssl' => 'ssl',
            'port' => '465'
        );

        return $config;
    }
}

?>