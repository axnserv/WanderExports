<?php
  if(file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
  } else {
    die( 'Unable to load the "PHP Email Form" library!');
  }

  $phpEmailForm = new PhpEmailForm();
  $messageArray = ["Name: {$_POST['name']}", "Email: {$_POST['email']}", "Message: {$_POST['message']}"];
  $message = join(PHP_EOL, $messageArray);
  echo $phpEmailForm->verifyRecaptchaAndSend($_POST['email'], $_POST['subject'], $message);
?>
