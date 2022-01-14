<?php

/* =====================================================
 * change this to the email you want the form to send to
 * ===================================================== */
$email_to = "thiagomaisweb@gmail.com"; 
$email_from = "thiagomaisweb@gmail.com"; // must be different than $email_from 
$email_subject = "Fomulário Claro Ultra Fibra";

if(isset($_POST['name']))
{

    function return_error($error)
    {
        echo json_encode(array('success'=>0, 'message'=>$error));
        die();
    }

    // check for empty required fields
    if (!isset($_POST['name']) ||
        !isset($_POST['telefone']) ||
		 !isset($_POST['cidade']) ||
		  !isset($_POST['cep']) ||
		   !isset($_POST['provedoratual']) ||
		    !isset($_POST['valorplanoatual'])) 
    {
        return_error('Por favor, preencha todos os campos.');
    }

    // form field values
     $name = $_POST['name']; // required
	 $telefone = $_POST['telefone']; // required
	 $cidade = $_POST['cidade']; // required
	 $cep = $_POST['cep']; // required
	 $provedoratual = $_POST['provedoratual']; // required
	 $valorplanoatual = $_POST['valorplanoatual']; // required
	


    // form validation
    $error_message = "";

    // name
    $name_exp = "/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/";
    if (!preg_match($name_exp,$name))
    {
        $this_error = 'Nome invalido.';
        $error_message .= ($error_message == "") ? $this_error : "<br/>".$this_error;
    }        

   

    // if there are validation errors
    if(strlen($error_message) > 0)
    {
        return_error($error_message);
    }

    // prepare email message
    $email_message = "Fomulário Claro Ultra Fibra\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Nome: ".clean_string($name)."\n";
	$email_message .= "Telefone: ".clean_string($telefone)."\n";
	$email_message .= "Cidade: ".clean_string($cidade)."\n";
	$email_message .= "CEP: ".clean_string($cep)."\n";
	$email_message .= "Provedor Atual: ".clean_string($provedoratual)."\n";
	$email_message .= "Valor do Plano Atual: ".clean_string($valorplanoatual)."\n";
   
 

    // create email headers
    $headers = 'From: '.$email_from."\r\n".
    'Reply-To: '.$email."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    if (@mail($email_to, $email_subject, $email_message, $headers))
    {
       @header ("location:enviado.html");
    }

    else 
    {
        echo json_encode(array('success'=>0, 'message'=>'Erro. Por favor, tente novamente.')); 
        die();        
    }
}
else
{
    echo 'Por favor, preencha todos os campos.';
    die();
}
?>