<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('PHPMailer-master/src/Exception.php');
require_once('PHPMailer-master/src/SMTP.php');
require_once('PHPMailer-master/src/PHPMailer.php');

class Contact{

    public function __construct(string $owner, string $mailTarget, string $mailFrom, string $SMTPserver, int $SMTPport, string $SMTPsecure, string $SMTPuserName, string $SMTPpwd){
        $this->owner = $owner;
        $this->mailTarget = $mailTarget;
        $this->mailFrom = $mailFrom;

        $this->mailer = new PHPMailer;
        $this->mailer->isSMTP();
        $this->mailer->Host= $SMTPserver;
        $this->mailer->Port= $SMTPport;
        $this->mailer->SMTPSecure = $SMTPsecure;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username= $SMTPuserName;
        $this->mailer->Password= $SMTPpwd;       
        
    }    

    private string $owner;
    private string $mailTarget;
    private string $mailFrom;
    private object $mailer;

    public function sendMail($nomPOST, $prenomPOST, $emailPOST, $messagePOST){

        $nom = filter_var(preg_replace('/[\s0-9]/','', $nomPOST), FILTER_SANITIZE_STRING);
        $prenom = filter_var(preg_replace('/[\s0-9]/','', $prenomPOST), FILTER_SANITIZE_STRING);
        $email = filter_var(filter_var($emailPOST, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        $message = filter_var($messagePOST, FILTER_SANITIZE_STRING);

        if(!$email){
            $info = "Une adresse email valide est nécessaire pour l'envoi du message 😕";
            return $info;
        }
        else{

            $subject = 'Message de ';
        
            if($nom == '' AND $prenom == ''){
                $from = 'inconnu';
                $subject .= $from;
            }
            else{
                $from = $prenom.' '.$nom;
                $subject .= $from;
            }
        
            $this->mailer->setFrom($this->mailFrom, $from);
            $this->mailer->addReplyTo($email, $from);
            $this->mailer->addAddress($this->mailTarget, $this->owner);
            $this->mailer->Subject = $subject;
            $this->mailer->Body= $message;
        
            if(!$this->mailer->send()){
                $info = 'Désolé : Une erreur s\'est produite 😔<br> Description de l\'erreur : '.$this->mailer->ErrorInfo;
                //appelle de la constante de debug de PHPMailer pour la maintenance
                //$this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
                return $info;
            }
            else{
                $info = 'Votre message a bien été envoyé, nous vous répondrons le plus rapidement possible 😉';
                return $info;
            }
        }
    }


}


?>