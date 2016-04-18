<?php
 
if(isset($_POST['email'])) {
  // EDIT THE 2 LINES BELOW AS REQUIRED
 
  $email_to = "benjaminisaacs@gmail.com";//"mendicants.business@gmail.com";
  $email_subject = "Mendicants Event Request";
 
  function died($error) {
    // your error code can go here
    echo json_encode(array('error' => $error));
    die();
  }
    
  // validation expected data exists
  if(!isset($_POST['name'])      ||
     !isset($_POST['email'])     ||
     !isset($_POST['telephone']) ||
     !isset($_POST['comments'])) {
      died('missing form element');     
  }
 
  $name = $_POST['name'];           // required
  $email_from = $_POST['email'];    // required
  $telephone = $_POST['telephone']; // not required
  $comments = $_POST['comments'];   // required

  $error_messages = array();

  $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
   
  if(!preg_match($email_exp,$email_from)) { 
      array_push($error_messages, 'invalid email address');
  }
   
  $string_exp = "/^[A-Za-z .'-]+$/";
   
  if(!preg_match($string_exp, $name)) {
    array_push($error_messages, 'invalid name');
  }
   
  if(strlen($comments) < 2) {
    array_push($error_messages, 'invalid comments');
  }
   
  if(count($error_messages) > 0) {
    died($error_messages);
  }
   
  $email_message = "Form details below.\n\n";
   
  function clean_string($string) {
    $bad = array("content-type", "bcc:", "to:", "cc:", "href");
    return str_replace($bad, "", $string);
  }

  $email_message .= "Name: "      . clean_string($name)       . "\n";
  $email_message .= "Email: "     . clean_string($email_from) . "\n";
  $email_message .= "Telephone: " . clean_string($telephone)  . "\n";
  $email_message .= "Comments: "  . clean_string($comments)   . "\n";

  // create email headers
   
  $headers = 'From: '         . $email_from . "\r\n" .
             'Reply-To: '     . $email_from . "\r\n" .
             'X-Mailer: PHP/' . phpversion();

  @mail($email_to, $email_subject, $email_message, $headers);  
   
  ?>
   
  <!-- include your own success html here --> 
   
  Thank you for contacting us. We will be in touch with you very soon.
   
  <?php
 
}
 
?>