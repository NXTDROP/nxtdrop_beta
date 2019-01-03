<?php 
    session_start();
    include "dbh.php";
    if (isset($_SESSION['uid'])) {
        date_default_timezone_set("UTC");
    }
    else {
        header("Location: signup");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('inc/head.php'); ?>
        <title>
            Checkout - NXTDROP - Canada's #1 Sneaker Marketplace
        </title>
        <link rel="canonical" href="https://nxtdrop.com/checkout.php">
        <!-- Javasripts -->
        <script type="text/javascript" src="https://www.wepay.com/min/js/iframe.wepay.js"></script>
        <script type="text/javascript">
            var item_ID = <?php echo "'".$_GET['item']."'"; ?>;
            function goNext() {
                $('.checkout-cancel').html('<i class="fas fa-circle-notch fa-spin"></i>');
                var streetInput = $('#street').val();
                var cityInput = $('#city').val();
                var postalCodeInput = $('#postalCode').val();
                var stateInput = $('#state').val();
                var countryInput = $('#country').val();
                if((isBlank(streetInput) || isEmpty(streetInput)) || (isBlank(cityInput) || isEmpty(cityInput)) || (isBlank(postalCodeInput) || isEmpty(postalCodeInput)) || (isBlank(stateInput) || isEmpty(stateInput)) || (isBlank(countryInput) || isEmpty(countryInput)))  {
                    $('input').css('border-color', 'red');
                    $('select').css('border-color', 'red');
                    alert('You forgot your shipping address?');
                    $('.checkout-cancel').html('NEXT');
                    setTimeout(resetBorderColor, 10000);
                } else {
                    var fullAddress = streetInput + ', ' + cityInput + ', ' + stateInput + ' ' + postalCodeInput + ', ' + countryInput;

                    $.ajax({
                        url: 'inc/checkout/wePayCheckout.php',
                        type: 'POST',
                        data: {amount: total, shippingCost: shipping, itemID: item_ID, discountID: discountID, shippingAddress: fullAddress, item: item},
                        success: function(response) {
                            $(response).insertAfter('.checkout-cancel');
                            $("input").attr('disabled', 'disabled')
                            $(".checkout-cancel").hide();                   
                        }
                    });
                }
            }
        </script>
        <script type="text/javascript" src="js/checkout.js"></script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        
        <?php include('inc/navbar/navbar.php'); ?>

        <div class="container checkout">
            <h1>Order Details</h1>

            <div class="checkout-item">
                <h3>Item</h3>
                <img id="item_img">
                <span id="item_description"></span>
                <p id="item_price"></p>
            </div>  

            <div class="checkout-buyer-info">
                <h3>Personal Information</h3>
                <h4>Shipping To</h4>
                <!--<input type="checkbox" id="same_address">
                <label for="same_address">Check if shipping address same as personal address.</label>
                <br>-->
                <input type="text" name="street" id="street" placeholder="Street">
                <input type="text" name="line2" id="line2" placeholder="Apt/Suite/Etc...">
                <input type="text" name="city" id="city" placeholder="City">
                <select name="state" id="state">
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District Of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select>
                <select name="country" id="country">
                    <option value="US">United States of America</option>
                    <option value="CA">Canada</option>
                </select>
                <input type="text" name="Zip" id="postalCode" placeholder="90046">
            </div>

            <div>
                <input type="text" name="discount" id="discount" placeholder="Discount Code">
                <button id="discount-btn">ADD PROMO CODE</button>
                <p id="discount-error"></p>
            </div>

            <div class="checkout-summary">
                <h3>Summary</h3>
                <div class="summary-shipping">
                    <strong>Shipping</strong>
                    <strong id="shipping-cost">FREE</strong>
                </div>
                
                <hr>
                <div class="summary-item">
                    <strong>Item</strong>
                    <strong id="item-cost">US$0.00</strong>
                </div>

                <hr>
                <div class="summary-discount">
                    <strong>Discount</strong>
                    <strong id="item-discount">- US$0.00</strong>
                </div>
                
                <hr>
                <div class="summary-total">
                    <strong>Total</strong>
                    <strong id="total-order">US$00.00</strong>
                </div>
                <hr>
            </div>

            <button class="checkout-cancel" onclick="goNext();">Next</button>
        </div>

        <?php require_once('inc/footer.php'); ?>

        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php'); ?>
        <?php include('inc/checkout/loadingInfo.php'); ?>
    </body>
</html>