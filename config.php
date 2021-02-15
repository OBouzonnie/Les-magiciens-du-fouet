<!-- Constantes utiles aux échanges externes -->

<?php 

// constante pour la connexion à la BDD
define('DRIVER', 'mysql');
define('HOST','localhost');
define('PORT','3306');
define('DB','magiciendufouet');
define('CHARSET','utf8');
define('LOG','root');
define('PWD','');

// constantes pour PHPMailer
define('OWNER', 'Prenom Nom');
define('MAILTARGET', 'mail@fai.com');
define('MAILFROM', 'mail@fai.com');
define('SMTPSERVER','smtp.fai.com');
define('SMTPPORT', 465);
define('SMTPSECURE', 'ssl');
define('SMTPUSERNAME','mail@fai.com');
define('SMTPPASSWORD','password');

// constantes pour l'upload des images
define('TARGET', 'images/');
define('MAX_SIZE', 500000); 
define('EXTALLOWED', array('jpg','jpeg')); 

?>