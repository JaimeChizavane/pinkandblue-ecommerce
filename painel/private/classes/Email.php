<?php
define('MAILUSER','atendimento@casacoimbramaputo.com');
define('MAILPASS','@2018@CasaCoimbraMaputo');
define('MAILPORT','587');
define('MAILHOST','smtp.ipage.com');
define('MAILSECURE',false);

class Email extends Model
{	
	public function sendEmail($emailTo, $emailFrom , $subject, $body)
	{		
		$mail          			 = new PHPMailer();
		$mail->setLanguage('pt');
		$mail->isSMTP();
		$mail->Host     		 = MAILHOST;
		$mail->SMTPAuth  		 = true;
		$mail->Username  		 = MAILUSER;
		$mail->Password  		 = MAILPASS;
		$mail->Port      		 = MAILPORT;
		$mail->SMTPSecure    	 = MAILSECURE;
		$mail->From      		 = $emailFrom;
		$mail->FromName  		 = "CASA COIMBRA REAL ESTATE";
		$mail->addAddress($emailTo);			
		$mail->isHTML(true);
		$mail->CharSet           = 'utf-8';
		$mail->WordWrap          = 70;
		$mail->Subject  		 = $subject;			
		$mail->Body  			 = $body;
		$mail->AltBody  		 = strip_tags($body);	
		$mail->Send();	
	}	
}