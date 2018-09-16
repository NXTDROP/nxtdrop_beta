<?php
    require_once('../credentials.php');
    require_once('vendor/autoload.php');
    $email = new \SendGrid\Mail\Mail(); 
    $sendgrid = new \SendGrid($SENDGRID_API_KEY);

    class Email {

        private $recipient;
        private $recipientEmail;
        private $from;
        private $subject;
        private $cc;
        private $emailType;
        private $error;

        public function _construct($recipient, $recipientEmail, $from, $subject, $cc) {
            setRecipient($recipient);
            setRecipientEmail($recipientEmail);
            setFrom($from);
            setSubject($subject);
            setCC($cc);
        }

        private function setRecipient($recipient) {
            $this->recipient = $recipient;
        }

        private function setRecipientEmail($recipientEmail) {
            // Remove all illegal characters from email
            $email = filter_var($recipientEmail, FILTER_SANITIZE_EMAIL);
            if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                echo 'INVALID EMAIL';
                $error = true;
            }
            $this->recipientEmail = $email;
        }

        private function setFrom($from) {
            $this->from = $from;
        }

        private function setSubject($subject) {
            $this->subject = $subject;
        }

        private function setCC($cc) {
            $this->cc = $cc;
        }

        private function getRecipient() {
            return $this->recipient;
        }

        private function getRecipientEmail() {
            return $this->recipientEmail;
        }

        private function getFrom() {
            return $this->from;
        }

        private function getSubject() {
            return $this->subject;
        }

        private function getCC() {
            return $this->cc;
        }

        public function sendEmail($type) {
            $email->setFrom(getFrom(), 'NXTDROP');
            $email->addTo(getRecipientEmail(), getRecipient());
            $email->setSubject(getSubject());
            $email->addCCs($cc);
            switch($type) {
                case registration:
                    registration();
                    break;
                case giveaway:
                    raffle();
                    break;
                case orderPlaced:
                    orderPlaced();
                    break;
                case sellerConfirmation:
                    sellerConfirmation();
                    break;
                case sellerShipping:
                    sellerShipping();
                    break;
                case middlemanVerification:
                    middlemanVerification();
                    break;
                case middlemanShipping:
                    middlemanShipping();
                    break;
                case receivedOffer:
                    receivedOffer();
                    break;
                case usedCode:
                    usedCode();
                    break;
                case profileChange:
                    profileChange();
                    break;
                case stripeRegistration:
                    stripeRegistration();
                    break;
                default:
                    break;
            }
        }

        private function registration() {
            $c = curl_init('https://nxtdrop.com/email/registration.php?email='.getRecipientEmail().'');
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            if($status != '200') {
                return false;
            } else {
                $html = curl_exec($c);
                curl_close($c);
                $clean_html = preg_replace('/\s+/', '', $html);
                $email->addContent("text/html", "$clean_html");
                try {
                    $sendgrid->send($email);
                    return true;
                } catch(Exception $e) {
                    return false;
                }
            }
        }

        private function raffle() {
            $c = curl_init('https://nxtdrop.com/email/raffle.php?email='.getRecipientEmail().'');
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            if($status != '200') {
                return false;
            } else {
                $html = curl_exec($c);
                curl_close($c);
                $clean_html = preg_replace('/\s+/', '', $html);
                $email->addContent("text/html", "$clean_html");
                try {
                    $sendgrid->send($email);
                    return true;
                } catch(Exception $e) {
                    return false;
                }
            }
        }

        private function orderPlaced() {
            $c = curl_init('https://nxtdrop.com/email/orderPlaced.php?email='.getRecipientEmail().'');
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            if($status != '200') {
                return false;
            } else {
                $html = curl_exec($c);
                curl_close($c);
                $clean_html = preg_replace('/\s+/', '', $html);
                $email->addContent("text/html", "$clean_html");
                try {
                    $sendgrid->send($email);
                    return true;
                } catch(Exception $e) {
                    return false;
                }
            }
        }

        private function sellerConfirmation() {
            $c = curl_init('https://nxtdrop.com/email/sellerConfirmation.php?email='.getRecipientEmail().'');
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            if($status != '200') {
                return false;
            } else {
                $html = curl_exec($c);
                curl_close($c);
                $clean_html = preg_replace('/\s+/', '', $html);
                $email->addContent("text/html", "$clean_html");
                try {
                    $sendgrid->send($email);
                    return true;
                } catch(Exception $e) {
                    return false;
                }
            }
        }

        private function sellerShipping() {
            $c = curl_init('https://nxtdrop.com/email/sellerShipping.php?email='.getRecipientEmail().'');
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            if($status != '200') {
                return false;
            } else {
                $html = curl_exec($c);
                curl_close($c);
                $clean_html = preg_replace('/\s+/', '', $html);
                $email->addContent("text/html", "$clean_html");
                try {
                    $sendgrid->send($email);
                    return true;
                } catch(Exception $e) {
                    return false;
                }
            }
        }

        private function middlemanVerification() {
            $c = curl_init('https://nxtdrop.com/email/middlemanVerification.php?email='.getRecipientEmail().'');
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            if($status != '200') {
                return false;
            } else {
                $html = curl_exec($c);
                curl_close($c);
                $clean_html = preg_replace('/\s+/', '', $html);
                $email->addContent("text/html", "$clean_html");
                try {
                    $sendgrid->send($email);
                    return true;
                } catch(Exception $e) {
                    return false;
                }
            }
        }

        private function middlemanShipping() {
            $c = curl_init('https://nxtdrop.com/email/middlemanShipping.php?email='.getRecipientEmail().'');
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            if($status != '200') {
                return false;
            } else {
                $html = curl_exec($c);
                curl_close($c);
                $clean_html = preg_replace('/\s+/', '', $html);
                $email->addContent("text/html", "$clean_html");
                try {
                    $sendgrid->send($email);
                    return true;
                } catch(Exception $e) {
                    return false;
                }
            }
        }

        private function receivedOffer() {
            $c = curl_init('https://nxtdrop.com/email/receivedOffer.php?email='.getRecipientEmail().'');
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            if($status != '200') {
                return false;
            } else {
                $html = curl_exec($c);
                curl_close($c);
                $clean_html = preg_replace('/\s+/', '', $html);
                $email->addContent("text/html", "$clean_html");
                try {
                    $sendgrid->send($email);
                    return true;
                } catch(Exception $e) {
                    return false;
                }
            }
        }

        private function usedCode() {
            $c = curl_init('https://nxtdrop.com/email/usedCode.php?email='.getRecipientEmail().'');
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            if($status != '200') {
                return false;
            } else {
                $html = curl_exec($c);
                curl_close($c);
                $clean_html = preg_replace('/\s+/', '', $html);
                $email->addContent("text/html", "$clean_html");
                try {
                    $sendgrid->send($email);
                    return true;
                } catch(Exception $e) {
                    return false;
                }
            }
        }

        private function profileChange() {
            $c = curl_init('https://nxtdrop.com/email/profileChange.php?email='.getRecipientEmail().'');
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            if($status != '200') {
                return false;
            } else {
                $html = curl_exec($c);
                curl_close($c);
                $clean_html = preg_replace('/\s+/', '', $html);
                $email->addContent("text/html", "$clean_html");
                try {
                    $sendgrid->send($email);
                    return true;
                } catch(Exception $e) {
                    return false;
                }
            }
        }

        private function stripeRegistration() {
            $c = curl_init('https://nxtdrop.com/email/stripeRegistration.php?email='.getRecipientEmail().'');
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
            if($status != '200') {
                return false;
            } else {
                $html = curl_exec($c);
                curl_close($c);
                $clean_html = preg_replace('/\s+/', '', $html);
                $email->addContent("text/html", "$clean_html");
                try {
                    $sendgrid->send($email);
                    return true;
                } catch(Exception $e) {
                    return false;
                }
            }
        }
    }