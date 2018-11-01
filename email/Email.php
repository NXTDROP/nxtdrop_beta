<?php
    /*require_once('../vendor/autoload.php');
    include_once('../../credentials.php');*/
    $SD = $SD_TEST_API_KEY;

    class Email {

        private $recipient;
        private $recipientEmail;
        private $from;
        private $subject;
        private $cc;
        private $emailType;
        private $error;
        private $transactionID;
        private $SD;
        private $tID;
        private $ext;
        private $news;

        public function __construct($recipient, $recipientEmail, $from, $subject, $cc) {
            $this->setRecipient($recipient);
            $this->setRecipientEmail($recipientEmail);
            $this->setFrom($from);
            $this->setSubject($subject);
            $this->setCC($cc);
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

        public function setTransactionID($transactionID) {
            $this->transactionID = $transactionID;
        }

        public function setTID($tID) {
            $this->tID = $tID;
        }

        public function setExt($ext) {
            $this->ext = $ext;
        }

        public function setNewsletter($news) {
            $this->news = $news;
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

        private function getTransactionID() {
            return $this->transactionID;
        }

        private function getTID() {
            return $this->tID;
        }

        private function getExt() {
            return $this->ext;
        }

        private function getNewsletter() {
            return $this->news;
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
                case 'mentionNotification':
                    $this->mentionNotification();
                    break;
                case 'discount':
                    $this->discountCode();
                    break;
                case 'counterOffer':
                    $this->counterOffer();
                    break;
                case 'counterOfferConf':
                    $this->counterOfferConf();
                    break;
                case 'orderConfirmation':
                    $this->orderConfirmation();
                    break;
                case 'orderCancellation':
                    $this->orderCancellation();
                    break;
                case 'orderConfirmation_seller':
                    $this->orderConfirmation_seller();
                    break;
                case 'orderCancellation_seller':
                    $this->orderCancellation_seller();
                    break;
                case 'orderShipping':
                    $this->orderShipping();
                    break;
                case 'purchaseFollowUp':
                    $this->purchaseFollowUp();
                    break;
                case 'newsletter':
                    $this->newsletter();
                    break;
                default:
                    $u = 'https://nxtdrop.com/email/'.$type.'?email='.$this->getRecipientEmail().'&username='.$this->getRecipient();
                    $url = str_replace(" ", "%20", $u);
                    $c = file_get_contents($url);
                    if(!$this->deliverMail($c, 'NXTDROP SUPPORT TEAM')) {
                        echo 'false';
                    }
                    break;
            }
        }

        private function deliverMail($html, $f) {
            $email = new \SendGrid\Mail\Mail();
            $email->addTo($this->getRecipientEmail(), $this->getRecipient());
            $email->setSubject($this->getSubject());
            $email->addContent("text/html", $html);
            if ($this->getCC() != '') {$email->addCC($this->getCC());}
            $email->setFrom($this->getFrom(), $f);
            try {
                $sendgrid = new \SendGrid($GLOBALS['SD']);
                $sendgrid->send($email);
                return true;
            } catch(Exception $e) {
                return false;
            }
        }

        private function registration() {
            $u = 'https://nxtdrop.com/email/registration.php?email='.$this->getRecipientEmail();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function raffle() {
            $u = 'https://nxtdrop.com/email/raffle.php?email='.$this->getRecipientEmail().'&username='.$this->getRecipient();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function orderPlaced() {
            $u = 'https://nxtdrop.com/email/orderPlaced.php?email='.$this->getRecipientEmail().'&transactionID='.$this->getTransactionID();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function sellerConfirmation() {
            $u = 'https://nxtdrop.com/email/sellerConfirmation.php?email='.$this->getRecipientEmail().'&itemID='.$this->getTransactionID();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function sellerShipping() {
            $u = 'https://nxtdrop.com/email/sellerShipping.php?email='.$this->getRecipientEmail().'&transactionID='.$this->getTransactionID();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function middlemanVerification() {
            $u = 'https://nxtdrop.com/email/middlemanVerification.php?email='.$this->getRecipientEmail();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function middlemanShipping() {
            $u = 'https://nxtdrop.com/email/middlemanShipping.php?email='.$this->getRecipientEmail();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function receivedOffer() {
            $u = 'https://nxtdrop.com/email/receivedOffer.php?email='.$this->getRecipientEmail();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function usedCode() {
            $u = 'https://nxtdrop.com/email/usedCode.php?email='.$this->getRecipientEmail();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function profileChange() {
            $u = 'https://nxtdrop.com/email/profileChange.php?email='.$this->getRecipientEmail();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function stripeRegistration() {
            $u = 'https://nxtdrop.com/email/stripeRegistration.php?email='.$this->getRecipientEmail().'&username='.$this->getRecipient();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function mentionNotification() {
            $u = 'https://nxtdrop.com/email/mentionNotif.php?tID='.$this->getTID().'&email='.$this->getRecipientEmail();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function discountCode() {
            $u = 'https://nxtdrop.com/email/discountCode.php?email='.$this->getRecipientEmail().'&username='.$this->getRecipient();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                //SEND ALERT EMAIL
                $email = new \SendGrid\Mail\Mail(); 
                $email->setFrom("hello@nxtdrop.com", "NXTDROP DISCOUNT");
                $email->setSubject("Discount ".$username."");
                $email->addTo('admin@nxtdrop.com', 'NXTDROP TEAM');
                $html = "<p>".$this->getRecipient()." didn't receive an email for his discount.</p>";
                $email->addContent("text/html", $html);
                $sendgrid = new \SendGrid($SD_TEST_API_KEY);
                $sendgrid->send($email);
            }
        }

        private function counterOffer() {
            $u = 'https://nxtdrop.com/email/counterOffer.php?'.$this->getExt();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function counterOfferConf() {
            $u = 'https://nxtdrop.com/email/coConfirmation.php?'.$this->getExt();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function orderConfirmation() {
            $u = 'https://nxtdrop.com/email/orderConfirmation.php?email='.$this->getRecipientEmail().'&transactionID='.$this->getTransactionID();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function orderCancellation() {
            $u = 'https://nxtdrop.com/email/orderCancellation.php?email='.$this->getRecipientEmail().'&transactionID='.$this->getTransactionID();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function orderConfirmation_seller() {
            $u = 'https://nxtdrop.com/email/orderConfirmation_seller.php?email='.$this->getRecipientEmail().'&transactionID='.$this->getTransactionID();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function orderCancellation_seller() {
            $u = 'https://nxtdrop.com/email/orderCancellation_seller.php?email='.$this->getRecipientEmail().'&transactionID='.$this->getTransactionID();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function orderShipping() {
            $u = 'https://nxtdrop.com/email/orderShipping.php?email='.$this->getRecipientEmail().'&transactionID='.$this->getTransactionID();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function purchaseFollowUp() {
            $u = 'https://nxtdrop.com/email/purchaseFollowUp.php?email='.$this->getRecipientEmail();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NXTDROP')) {
                echo 'false';
            }
        }

        private function newsletter() {
            $u = 'https://nxtdrop.com/email/newsletter/'.$this->getNewsletter().'?email='.$this->getRecipientEmail().'&username='.$this->getRecipient();
            $url = str_replace(" ", "%20", $u);
            $c = file_get_contents($url);
            if(!$this->deliverMail($c, 'NEWS by NXTDROP')) {
                echo 'false';
            }
        }
    }