<?php
class PhpEmailForm {
    private $recaptchaSecretKey = "6Lf2dhUrAAAAACZKcOCoVtTKI7mERaH4Ng3AVyvq";
    private $from = "ashley@wanderexport.com";
    private $to = "ashley@wanderexport.com";

    public function verifyRecaptchaAndSend($replyTo, $subject, $message) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha-response'])) {
            // Build POST request:
            $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
            $recaptchaResponse = $_POST['recaptcha-response'];
        
            // Make and decode POST request:
            $recaptcha = file_get_contents($recaptchaUrl . '?secret=' . $this->recaptchaSecretKey . '&response=' . $recaptchaResponse);
            $recaptcha = json_decode($recaptcha);

            // Uncomment to see ReCaptcha JSON response
            //echo "<pre>"; print_r($recaptcha); echo "</pre>";

            // Take action based on the score returned:
            if ($recaptcha->score >= 0.5) {
                // Verified - send email
                $result = $this->send($replyTo, $subject, $message);
            } else {
                // Not verified - show form error
                $result = "Failed to verify that you're human. Please try again.";
            }

            return $result;
        }
    }

    private function send($replyTo, $subject, $message) {
        $headersArray = ["From: {$this->from}", "Reply-To: {$replyTo}"];
        $headers = join(PHP_EOL, $headersArray);
        $success = mail($this->to, $subject, $message, $headers);
        if ($success)
        {
            $result = "OK";
        }
        else
        {
            $result = "Not received. Sorry! Please reach us by email or phone.";
        }
        return $result;
    }
}
?>
