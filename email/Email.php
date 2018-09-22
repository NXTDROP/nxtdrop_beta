<?php
    require_once('../vendor/autoload.php');
    include_once('../../credentials.php');
    $SD = $SD_TEST_API_KEY;

    class Email {

        private $recipient;
        private $recipientEmail;
        private $from;
        private $subject;
        private $cc;
        private $emailType;
        private $error;
        private $itemID;
        private $SD;

        public function __construct($recipient, $recipientEmail, $from, $subject, $cc) {
            $this->setRecipient($recipient);
            $this->setRecipientEmail($recipientEmail);
            $this->setFrom($from);
            $this->setSubject($subject);
            $this->setCC($cc);
        }

        public function Email($recipient, $recipientEmail, $from, $subject, $cc, $itemID) {
            $this->setRecipient($recipient);
            $this->setRecipientEmail($recipientEmail);
            $this->setFrom($from);
            $this->setSubject($subject);
            $this->setCC($cc);
            $this->setItemID($itemID);
        }

        public function setRecipient($recipient) {
            $this->recipient = $recipient;
        }

        public function setRecipientEmail($recipientEmail) {
            // Remove all illegal characters from email
            $email = filter_var($recipientEmail, FILTER_SANITIZE_EMAIL);
            if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                echo 'INVALID EMAIL';
                $error = true;
            }
            $this->recipientEmail = $email;
        }

        public function setFrom($from) {
            $this->from = $from;
        }

        public function setSubject($subject) {
            $this->subject = $subject;
        }

        public function setCC($cc) {
            $this->cc = $cc;
        }

        public function setItemID($itemID) {
            $this->itemID = $itemID;
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

        private function getItemID() {
            return $this->itemID;
        }

        public function sendEmail($type) {
            switch($type) {
                case 'registration':
                    $this->registration();
                    break;
                case 'giveaway':
                    $this->raffle();
                    break;
                case 'orderPlaced':
                    $this->orderPlaced();
                    break;
                case 'sellerConfirmation':
                    $this->sellerConfirmation();
                    break;
                case 'sellerShipping':
                    $this->sellerShipping();
                    break;
                case 'middlemanVerification':
                    $this->middlemanVerification();
                    break;
                case 'middlemanShipping':
                    $this->middlemanShipping();
                    break;
                case 'receivedOffer':
                    $this->receivedOffer();
                    break;
                case 'usedCode':
                    $this->usedCode();
                    break;
                case 'profileChange':
                    $this->profileChange();
                    break;
                case 'stripeRegistration':
                    $this->stripeRegistration();
                    break;
                default:
                    break;
            }
        }

        private function deliverMail($html) {
            $email = new \SendGrid\Mail\Mail();
            $email->addTo($this->getRecipientEmail(), $this->getRecipient());
            $email->setSubject($this->getSubject());
            $email->addContent("text/html", $html);
            if ($this->getCC() != '') {$email->addCC($this->getCC());}
            else {echo 'nocc';}
            $email->setFrom($this->getFrom(), 'NXTDROP');
            try {
                $sendgrid = new \SendGrid($GLOBALS['SD']);
                $sendgrid->send($email);
                return true;
            } catch(Exception $e) {
                return false;
            }
        }

        private function registration() {
            $c = file_get_contents('http://localhost/nd-v1.00/email/registration.php?email='.$this->getRecipientEmail().'');
            if($this->deliverMail($c)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }

        private function raffle() {
            $c = file_get_contents('https://nxtdrop.com/email/raffle.php?email='.$this->getRecipientEmail().'');
            if($this->deliverMail($c)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }

        private function orderPlaced() {
            $html = file_get_contents('http://localhost/nd-v1.00/email/orderPlaced.php?email='.$this->getRecipientEmail().'&itemID='.$this->getItemID().'');
            if($this->deliverMail($html)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }

        private function sellerConfirmation() {
            $c = file_get_contents('https://nxtdrop.com/email/sellerConfirmation.php?email='.$this->getRecipientEmail().'');
            if($this->deliverMail($c)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }

        private function sellerShipping() {
            $c = file_get_contents('https://nxtdrop.com/email/sellerShipping.php?email='.$this->getRecipientEmail().'');
            if($this->deliverMail($c)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }

        private function middlemanVerification() {
            $c = file_get_contents('https://nxtdrop.com/email/middlemanVerification.php?email='.$this->getRecipientEmail().'');
            if($this->deliverMail($c)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }

        private function middlemanShipping() {
            $c = file_get_contents('https://nxtdrop.com/email/middlemanShipping.php?email='.$this->getRecipientEmail().'');
            if($this->deliverMail($c)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }

        private function receivedOffer() {
            $c = file_get_contents('https://nxtdrop.com/email/receivedOffer.php?email='.$this->getRecipientEmail().'');
            if($this->deliverMail($c)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }

        private function usedCode() {
            $c = file_get_contents('https://nxtdrop.com/email/usedCode.php?email='.$this->getRecipientEmail().'');
            if($this->deliverMail($c)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }

        private function profileChange() {
            $c = file_get_contents('https://nxtdrop.com/email/profileChange.php?email='.$this->getRecipientEmail().'');
            if($this->deliverMail($c)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }

        private function stripeRegistration() {
            $c = file_get_contents('https://nxtdrop.com/email/stripeRegistration.php?email='.$this->getRecipientEmail().'');
            if($this->deliverMail($c)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }