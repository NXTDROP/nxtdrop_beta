<?php 
    session_start();
    include "dbh.php";
    require_once('vendor/autoload.php');
    \Stripe\Stripe::setApiKey("sk_test_zFMuyMBC60raTKDdLGzR4wdb");
    if (!isset($_SESSION['uid'])) {
        header("Location: welcome_home.php");
        exit();
    }
    $country = $_SESSION['country'];
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Fashion Trade Centre
    </title>

    <head>
        <?php include('inc/head.php'); ?>
        <!-- Javasripts -->
        <script>var country = <?php echo "'".$country."'"; ?>;</script>
        <script src="js/account_settings.js"></script>
        <style>
            label {
                font-size: 14px;
            }

            .StripeElement {
                background-color: white;
                height: 40px;
                padding: 10px 12px;
                border-radius: 4px;
                border: 1px solid transparent;
                box-shadow: 0 1px 3px 0 #e6ebf1;
                -webkit-transition: box-shadow 150ms ease;
                transition: box-shadow 150ms ease;
            }

            .StripeElement--focus {
                box-shadow: 0 1px 3px 0 #cfd7df;
            }

            .StripeElement--invalid {
                border-color: #fa755a;
            }

            .StripeElement--webkit-autofill {
                background-color: #fefde5 !important;
            }
        </style>
    </head>

    <body>
        <?php include('inc/navbar/navbar.php'); ?>

        <div class="form_container">
            <form class="personal_information" action="" method="POST">
                <!------- INDIVIDUAL OR BUSINESS ------->
                <strong style="font-size: 25px;">Personal Information</strong>
                <small>Make sure the information you provide is accurate.</small>
                <br>
                <div id="personal_info">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="entity" id="individual" value="individual" required>
                        <label class="form-check-label" for="individual" style="font-size: 16px;">Individual</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="entity" id="business" value="business" required>
                        <label class="form-check-label" for="business" style="font-size: 16px;">Business</label>
                    </div>
                </div>

                <p id="personal_info_errors" style="color: #cc0000;"></p>
                <!------- FIRST & LAST NAME ------->
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="inputFirstName" placeholder="First Name" required>
                    </div>
                    <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="inputLastName" placeholder="Last Name" required>
                    </div>
                </div>

                <!------- DATE OF BIRTH ------->
                <div class="form-row">
                    <div class="col-md-2 mb-2">
                    <input type="text" class="form-control" id="inputMonth" placeholder="MM" required>
                    </div>
                    <div class="col-md-2 mb-2">
                    <input type="text" class="form-control" id="inputDay" placeholder="DD" required>
                    </div>
                    <div class="col-md-3 mb-3">
                    <input type="text" class="form-control" id="inputYear" placeholder="YYYY" required>
                    </div>
                </div>

                <!------- ADDRESS ------->
                <div class="form-group">
                    <label for="inputAddress">Street</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="1324 Main St" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="inputCity">City</label>
                    <input type="text" class="form-control" id="inputCity" required>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="inputState">State/Province</label>
                    <select id="inputState" class="form-control">
                    <?php
                        echo '<option value="" selected>Choose...</option>';
                        if ($country == 'US') {
                            echo '<option value="AL">AL</option><option value="AK">AK</option><option value="AR">AR</option><option value="AZ">AZ</option><option value="CA">CA</option><option value="CO">CO</option><option value="CT">CT</option><option value="DC">DC</option><option value="DE">DE</option><option value="FL">FL</option><option value="GA">GA</option><option value="HI">HI</option><option value="IA">IA</option><option value="ID">ID</option><option value="IL">IL</option><option value="IN">IN</option><option value="KS">KS</option><option value="KY">KY</option><option value="LA">LA</option><option value="MA">MA</option><option value="MD">MD</option><option value="ME">ME</option><option value="MI">MI</option><option value="MN">MN</option><option value="MO">MO</option>	<option value="MS">MS</option><option value="MT">MT</option><option value="NC">NC</option><option value="NE">NE</option><option value="NH">NH</option><option value="NJ">NJ</option><option value="NM">NM</option><option value="NV">NV</option><option value="NY">NY</option><option value="ND">ND</option><option value="OH">OH</option><option value="OK">OK</option><option value="OR">OR</option><option value="PA">PA</option><option value="RI">RI</option><option value="SC">SC</option><option value="SD">SD</option><option value="TN">TN</option><option value="TX">TX</option><option value="UT">UT</option><option value="VT">VT</option><option value="VA">VA</option><option value="WA">WA</option><option value="WI">WI</option><option value="WV">WV</option><option value="WY">WY</option>';
                        }
                        else if ($country == 'CA') {
                            echo '<option value="AB">AB</option><option value="BC">BC</option><option value="MB">MB</option><option value="NB">NB</option><option value="NL">NL</option><option value="NS">NS</option><option value="ON">ON</option><option value="PE">PE</option><option value="QC">QC</option><option value="SK">SK</option><option value="NT">NT</option><option value="NU">NU</option><option value="YT">YT</option>';
                        }
                    ?>
                    </select>
                    </div>
                    <?php
                        if($country == 'US') {
                            echo '<div class="form-group col-md-2">
                            <label for="inputZip">Zip</label>
                            <input type="text" class="form-control" id="inputZip" placeholder="19131" required>
                            </div>';
                        }
                        else if($country == 'CA') {
                            echo '<div class="form-group col-md-2">
                            <label for="inputZip">Postal</label>
                            <input type="text" class="form-control" id="inputZip" placeholder="M6K 3P6" style="padding: 5px;" required>
                            </div>';
                        }
                    ?>
                </div>

                <!------- COUNTRY & SSN OR SIN ------->
                <div class="form-group">
                    <label for="inputCountry">Country</label>
                    <input type="text" class="form-control" id="inputCountry" disabled>
                    <?php
                        if($country == 'US') {
                            echo '<label for="inputSSN">Last 4 digits of SSN</label><span id="popoverSSN"><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="We are required to gather this information by Stripe, Inc. This information will help us detect frauds. Failure to provide this information could prevent you from transfering funds to your bank account. Know that Stripe, Inc. processes the payments on our platform and cannot share this information."></i></span>
                            <input type="text" style="width: 65px;" class="form-control col-md-2" id="inputSocial" maxlength="4" placeholder="XXXX">';
                        }
                        else if($country == 'CA') {
                            echo '<label for="inputSIN">SIN (Tax ID)</label><span id="popoverSIN"><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="We are required to gather this information by Stripe, Inc. This information will help us detect frauds. Failure to provide this information could prevent you from transfering funds to your bank account. Know that Stripe, Inc. processes the payments on our platform and cannot share this information."></i></span>
                            <input type="text"  class="form-control col-md-4" id="inputSocial" maxlength="12" placeholder="123 123 123 123">';
                        }
                    ?>
                </div>

                <!------- BUSINESS INFORMATION ------->
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="inputBusinessName" placeholder="Business Name" disabled required>
                    </div>
                    <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="inputBusinessNumber" placeholder="Business Number (Tax ID)" disabled required>
                    </div>
                </div>
                
                <input type="hidden" name="token" id="token_PI">
                <button class="btn btn-primary">Update Personal Information</button>
                <br>
                <br>
            </form>

            <form class="payment_information" method="POST">
                <!------- PAYMENT OPTIONS ------->
                <strong style="font-size: 25px;">Buyer Information</strong>
                <br>

                <!------- CC INFORMATION ------->
                <div id="CC_Info">
                    <!-- CC ACCEPTED -->
                    <i class="fab fa-cc-visa fa-2x" title="Visa"></i>
                    <i class="fab fa-cc-mastercard fa-2x" title="Mastercard"></i>
                    <i class="fab fa-cc-amex fa-2x" title="American Express"></i>
                    <i class="fab fa-cc-jcb fa-2x" title="JCB"></i>
                    <i class="fab fa-cc-discover fa-2x" title="Discover"></i>
                    <i class="fab fa-cc-diners-club fa-2x" title="Diners Club"></i>
                    
                    <div class="current_payment_option">
                    <small>Current payment option:</small>
                    <strong>NONE</strong>
                    </div>

                    <div class="form-group">
                        <label for="card-element">
                        Credit or Debit
                        </label><span><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="When storing your card details, we send over a request to the issuing bank for either a $0 or a $1 authorization to verify that the card is issued and the bank will allow it to be authorized."></i></span>
                        <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                </div>
                
                <input type="hidden" name="token" id="token_PaymentInfo">
                <button class="btn btn-primary" id="payment_submit">Update Payment Information</button>
                <p class="error_payment" style="color: #cc0000;"></p>
                <br>
                <br>
            </form>

            <form class="payout_information" method="POST">
                <!------- PAYOUT OPTIONS ------->
                <strong style="font-size: 25px;">Seller Information</strong>
                    <br>
                <div class="form-group" id="payoutOption">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payoutOption" id="card_payout_radio" value="card">
                        <label class="form-check-label" for="card_payout_radio">U.S. Visa or Mastercard Debit Only</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payoutOption" id="bank_payout_radio" value="bank">
                        <label class="form-check-label" for="bank_payout_radio">Bank</label>
                    </div>
                </div>

                <div class="current_payout_option">
                    <small>Current payout option:</small>
                    <strong>NONE</strong>
                </div>

                <!------- CC INFORMATION ------->
                <div id="CC_PayInfo">
                    <!-- CC ACCEPTED -->
                    <i class="fab fa-cc-visa fa-2x" title="Visa"></i>
                    <i class="fab fa-cc-mastercard fa-2x" title="Mastercard"></i>
                    <i class="fab fa-cc-amex fa-2x" title="American Express"></i>
                    <i class="fab fa-cc-jcb fa-2x" title="JCB"></i>
                    <i class="fab fa-cc-discover fa-2x" title="Discover"></i>
                    <i class="fab fa-cc-diners-club fa-2x" title="Diners Club"></i>

                    <div class="form-group">
                        <label for="card-element-payout">
                        Credit or Debit
                        </label><span><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="When storing your card details, we send over a request to the issuing bank for either a $0 or a $1 authorization to verify that the card is issued and the bank will allow it to be authorized."></i></span>
                        <div id="card-element-payout">
                        <!-- A Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors. -->
                        <div id="card-errors-payout" role="alert"></div>
                    </div>
                </div>

                <?php 
                    $country = $_SESSION['country'];
                    $class = 'img-fluid';
                    $src = "'".'img/check.jpg'."'";
                    $src2 = "'".'img/check.gif'."'";
                    echo '<!------- PAYMENT BANK INFORMATION ------->';
                    if ($country == 'US') {
                        echo '<br>
                        <!-- US BANK INFO -->
                        <div class="form-group" id="payBank">
                            <label for="inputUSRouting">Routing Number</label><span><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="<img class='.$class.' src='.$src.'/>"></i></span>
                            <input type="text" class="form-control col-md-6" maxlength="9" id="inputPayRouting" placeholder="111000000">
                            <label for="inputUSAccount" style="margin-top: 5px;">Account Number</label><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="right" data-trigger="hover" data-toggle="popover" data-content="<img class='.$class.' src='.$src.'/>"></i></span>
                            <input type="text" class="form-control col-md-6" id="inputPayAccount">
                            <label for="inputConfUSAccount" style="margin-top: 5px;">Confirm Account Number</label>
                            <input type="text" class="form-control col-md-6" id="inputConfPayAccount">
                        </div>';
                    }
                    else if ($country == 'CA') {
                        echo '<br>
                        <!-- CA BANK INFO -->
                        <div class="form-group" id="payBank">
                            <label for="inputTransitNumber">Transit Number</label><span><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="<img class='.$class.' src='.$src2.'/>"></i></span>
                            <input type="text" class="form-control col-md-6" maxlength="5" id="inputPayTransitNumber" placeholder="12345">
                            <label for="inputInstitution">Institution Number</label><span><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="<img class='.$class.' src='.$src2.'/>"></i></span>
                            <input type="text" class="form-control col-md-6" maxlength="3" id="inputPayInstitution" placeholder="123">
                            <label for="inputCAAccount" style="margin-top: 5px;">Account Number</label><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="right" data-trigger="hover" data-toggle="popover" data-content="<img class='.$class.' src='.$src2.'/>"></i></span>
                            <input type="text" class="form-control col-md-6" id="inputPayAccount">
                            <label for="inputConfCAAccount" style="margin-top: 5px;">Confirm Account Number</label>
                            <input type="text" class="form-control col-md-6" id="inputConfPayAccount">
                        </div>';
                    }
                ?>
                
                <!-- SUBMIT BUTTON -->
                <button class="btn btn-primary" id="payout_submit">Update Payout Information</button>
                <p class="payout_error" style="color: #cc0000"></p>
            </form>
        </div>

        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php') ?>
        <?php include('inc/buyer_transaction_confirmation.php') ?>
        <?php include('inc/account_settings/loadingInfo.php') ?>
    </body>
</html>