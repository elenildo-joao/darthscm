<?php

class Email{
    private $mensagem;
    private $assunto;
    private $destinatario;

    public function  __construct($mensagem, $assunto, $destinatarioEmail, $destinatarioNome) {
        $this->assunto = utf8_decode($assunto);
        $this->mensagem = $mensagem;
        $this->destinatario['email'] = utf8_decode($destinatarioEmail);
        $this->destinatario['nome'] = utf8_decode($destinatarioNome);
    }

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