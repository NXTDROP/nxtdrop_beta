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
        </style>
    </head>

    <body>
        <?php include('inc/navbar/navbar.php'); ?>

        <div class="form_container" method="POST">
            <form action="" class="personal_information">
                <!------- INDIVIDUAL OR BUSINESS ------->
                <strong>Personal Information</strong>
                <small>Make sure the information you provide is accurate.</small>
                <br>
                <div id="personal_info">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="entity" id="individual" value="individual">
                        <label class="form-check-label" for="individual" style="font-size: 16px;">Individual</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="entity" id="business" value="business">
                        <label class="form-check-label" for="business" style="font-size: 16px;">Business</label>
                    </div>
                </div>

                <p id="personal_info_errors" style="color: red;"></p>
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
                    <input type="text" class="form-control" id="inputMonth" placeholder="01" required>
                    </div>
                    <div class="col-md-2 mb-2">
                    <input type="text" class="form-control" id="inputDay" placeholder="01" required>
                    </div>
                    <div class="col-md-3 mb-3">
                    <input type="text" class="form-control" id="inputYear" placeholder="2018" required>
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
                            echo '<option value="Alabama">Alabama</option><option value="Alaska">Alaska</option><option value="Arizona">Arizona</option><option value="Arkansas">Arkansas</option><option value="California">California</option><option value="Colorado">Colorado</option><option value="Connecticut">Connecticut</option><option value="Delaware">Delaware</option><option value="District Of Columbia">District Of Columbia</option><option value="Florida">Florida</option><option value="Georgia">Georgia</option><option value="Hawaii">Hawaii</option><option value="Idaho">Idaho</option><option value="Illinois">Illinois</option><option value="Indiana">Indiana</option><option value="Iowa">Iowa</option><option value="Kansas">Kansas</option><option value="Kentucky">Kentucky</option><option value="Louisiana">Louisiana</option><option value="Maine">Maine</option><option value="Maryland">Maryland</option><option value="Massachusetts">Massachusetts</option><option value="Michigan">Michigan</option><option value="Minnesota">Minnesota</option><option value="Mississippi">Mississippi</option><option value="Missouri">Missouri</option><option value="Montana">Montana</option><option value="Nebraska">Nebraska</option><option value="Nevada">Nevada</option><option value="New Hampshire">New Hampshire</option><option value="New Jersey">New Jersey</option><option value="New Mexico">New Mexico</option><option value="New York">New York</option><option value="North Carolina">North Carolina</option><option value="North Dakota">North Dakota</option><option value="Ohio">Ohio</option><option value="Oklahoma">Oklahoma</option><option value="Oregon">Oregon</option><option value="Pennsylvania">Pennsylvania</option><option value="Rhode Island">Rhode Island</option><option value="South Carolina">South Carolina</option><option value="South Dakota">South Dakota</option><option value="Tennessee">Tennessee</option><option value="Texas">Texas</option>
                            <option value="Utah">Utah</option><option value="Vermont">Vermont</option><option value="Virginia">Virginia</option><option value="Washington">Washington</option><option value="West Virginia">West Virginia</option><option value="Wisconsin">Wisconsin</option><option value="Wyoming">Wyoming</option>';
                        }
                        else if ($country == 'CA') {
                            echo '<option value="Alberta">Alberta</option><option value="British Columbia">British Columbia</option><option value="Manitoba">Manitoba</option><option value="New Brunswick">New Brunswick</option><option value="Newfoundland and Labrador">Newfoundland and Labrador</option><option value="Nova Scotia">Nova Scotia</option><option value="Ontario">Ontario</option><option value="Prince Edward Island">Prince Edward Island</option><option value="Quebec">Quebec</option><option value="Saskatchewan">Saskatchewan</option><option value="Northwest Territorie">Northwest Territories</option><option value="Nunavut">Nunavut</option><option value="Yukon">Yukon</option>';
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
                            echo '<label for="inputSSN">Last 4 digits of SSN</label><span id="popoverSSN"><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="We are required to gather this information to identify you. However, you do not have to provide this information until we notify you. Failure to provide this information could prevent you from transfering funds to your bank account."></i></span>
                            <input type="text" style="width: 65px;" class="form-control col-md-2" id="inputSSN" maxlength="4" placeholder="XXXX">';
                        }
                        else if($country == 'CA') {
                            echo '<label for="inputSIN">SIN (Tax ID)</label><span id="popoverSIN"><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="We are required to gather this information to identify you. However, you do not have to provide this information until we notify you. Failure to provide this information could prevent you from transfering funds to your bank account."></i></span>
                            <input type="text"  class="form-control col-md-4" id="inputSIN" maxlength="12" placeholder="123 123 123 123">';
                        }
                    ?>
                </div>

                <!------- BUSINESS INFORMATION ------->
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="inputBusinessName" placeholder="Business Name" disabled>
                    </div>
                    <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="inputBusinessNumber" placeholder="Business Number (Tax ID)" disabled>
                    </div>
                </div>
                
                <input type="hidden" name="token" id="token_PI">
                <button type="submit" class="btn btn-primary">Update Personal Information</button>
                <br>
                <br>
            </form>

            <form class="payment_information" method="POST">
                <!------- PAYMENT OPTIONS ------->
                <div class="form-group" id="paymentOption">
                    <strong>Payment Information</strong>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="paymentOption" id="card_radio" value="C">
                        <label class="form-check-label" for="card_radio">Card</label>
                        </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="paymentOption" id="bank_radio" value="B">
                        <label class="form-check-label" for="bank_radio">Bank</label>
                    </div>
                </div>

                <!------- CC INFORMATION ------->
                <div id="CC_Info">
                    <!-- CC ACCEPTED -->
                    <i class="fab fa-cc-visa fa-2x" title="Visa"></i>
                    <i class="fab fa-cc-mastercard fa-2x" title="Mastercard"></i>
                    <i class="fab fa-cc-amex fa-2x" title="American Express"></i>
                    <i class="fab fa-cc-jcb fa-2x" title="JCB"></i>
                    <i class="fab fa-cc-discover fa-2x" title="Discover"></i>
                    <i class="fab fa-cc-diners-club fa-2x" title="Diners Club"></i>

                    <div class="form-group">
                        <label for="inputAddress">Card #</label>
                        <input type="tel" class="form-control" id="inputCard" maxlength="16" placeholder="1234 1234 1234 1234">
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                    <p>Expiration Date</p>
                    <div class="form-row" id="CC_">
                        <div class="col-md-2 md-2">
                            <input type="text" class="form-control" id="expMonth" maxlength="2" placeholder="03">
                        </div>
                        <div class="col-md-3 md-3">
                            <input type="text" class="form-control" id="expYear" maxlength="4" placeholder="2018">
                        </div>
                        <div class="col-md-3 md-3">
                            <input type="text" class="form-control" id="inputCVC" maxlength="3" placeholder="CVC">
                        </div>
                    </div>
                </div>

                <?php 
                    $class = 'img-fluid';
                    $src = 'img/check.jpg';
                    $src2 = 'img/check.gif';
                    echo '<!------- BANK INFORMATION ------->';
                    if ($country == 'US') {
                        echo '<br>
                        <!-- US BANK INFO -->
                        <div class="form-group" id="Bank">
                            <p>This information is normally found on a check provided by your bank.</p>
                            <label for="inputUSRouting">Routing Number</label><span><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="<img class='.$class.' src='.$src.'/>"></i></span>
                            <input type="text" class="form-control col-md-6" maxlength="9" id="inputRouting" placeholder="111000000">
                            <label for="inputUSAccount" style="margin-top: 5px;">Account Number</label><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="right" data-trigger="hover" data-toggle="popover" data-content="<img class='.$class.' src='.$src.'/>"></i></span>
                            <input type="text" class="form-control col-md-6" id="inputAccount">
                            <label for="inputConfUSAccount" style="margin-top: 5px;">Confirm Account Number</label>
                            <input type="text" class="form-control col-md-6" id="inputConfAccount">
                        </div>';
                    }
                    else if ($country == 'CA') {
                        echo '<br>
                        <!-- CA BANK INFO -->
                        <div class="form-group" id="Bank">
                            <p>This information is normally found on a check provided by your bank.</p>
                            <label for="inputTransitNumber">Transit Number</label><span><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="<img class='.$class.' src='.$src2.'/>"></i></span>
                            <input type="text" class="form-control col-md-6" maxlength="5" id="inputTransitNumber" placeholder="12345">
                            <label for="inputInstitution">Institution Number</label><span><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="<img class='.$class.' src='.$src2.'/>"></i></span>
                            <input type="text" class="form-control col-md-6" maxlength="3" id="inputInstitution" placeholder="123">
                            <label for="inputCAAccount" style="margin-top: 5px;">Account Number</label><i class="fas fa-info-circle" style="margin-left: 10px;" data-html="true" data-placement="right" data-trigger="hover" data-toggle="popover" data-content="<img class='.$class.' src='.$src2.'/>"></i></span>
                            <input type="text" class="form-control col-md-6" id="inputAccount">
                            <label for="inputConfCAAccount" style="margin-top: 5px;">Confirm Account Number</label>
                            <input type="text" class="form-control col-md-6" id="inputConfAccount">
                        </div>';
                    }
                ?>
                
                <input type="hidden" name="token" id="token_PaymentInfo">
                <button type="submit" class="btn btn-primary">Update Payment Information</button>
                <br>
                <br>
            </form>

            <form class="payout_information" method="POST">
                <!------- PAYOUT OPTIONS ------->
                <strong>Payout Information</strong>
                    <br>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="cc" id="payout_checkbox">
                    <label class="form-check-label" for="payout_checkbox">Uncheck if your payout information is different from your payment information.</label>
                </div>
                <div class="form-group" id="payoutOption">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payoutOption" id="card_payout_radio" value="C">
                        <label class="form-check-label" for="card_payout_radio">Card</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payoutOption" id="bank_payout_radio" value="B">
                        <label class="form-check-label" for="bank_payout_radio">Bank</label>
                    </div>
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
                        <label for="inputAddress">Card #</label>
                        <input type="tel" class="form-control" id="inputPayCard" maxlength="16" placeholder="1234 1234 1234 1234">
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                    <p>Expiration Date</p>
                    <div class="form-row" id="CC_">
                        <div class="col-md-2 md-2">
                            <input type="text" class="form-control" id="expPayMonth" maxlength="2" placeholder="03">
                        </div>
                        <div class="col-md-3 md-3">
                            <input type="text" class="form-control" id="expPayYear" maxlength="4" placeholder="2018">
                        </div>
                        <div class="col-md-3 md-3">
                            <input type="text" class="form-control" id="inputPayCVC" maxlength="3" placeholder="CVC">
                        </div>
                    </div>
                </div>

                <?php 
                    $country = $_SESSION['country'];
                    $class = 'img-fluid';
                    $src = 'img/check.jpg';
                    $src2 = 'img/check.gif';
                    echo '<!------- PAYMENT BANK INFORMATION ------->';
                    if ($country == 'US') {
                        echo '<br>
                        <!-- US BANK INFO -->
                        <div class="form-group" id="payBank">
                            <p>This information is normally found on a check provided by your bank.</p>
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
                            <p>This information is normally found on a check provided by your bank.</p>
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
                
                <input type="hidden" name="token" id="token_PayoutInfo">
                <!-- SUBMIT BUTTON -->
                <button type="submit" class="btn btn-primary">Update Payout Information</button>
            </form>
        </div>

        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php') ?>
        <?php include('inc/buyer_transaction_confirmation.php') ?>
    </body>
</html>