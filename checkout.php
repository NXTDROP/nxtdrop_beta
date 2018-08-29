<?php 
    session_start();
    include "dbh.php";
    if (isset($_SESSION['uid'])) {
        date_default_timezone_set("UTC");
    }
    else {
        header("Location: welcome");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Fashion Trade Centre
    </title>
    <head>
        <?php include('inc/head.php'); ?>
        <!-- Javasripts -->
        <script type="text/javascript">
            var item_ID = <?php echo "'".$_GET['item']."'"; ?>;
            function goBack() {
                window.history.back();
            }
        </script>
        <script type="text/javascript" src="js/checkout.js"></script>
    </head>

    <body>
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
                <small>Payment Method: </small>
                <strong>NONE</strong>
                <h4>Shipping To</h4>
                <input type="checkbox" id="same_address">
                <label for="same_address">Check if shipping address same as personal address.</label>
                <br>
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

            <div class="checkout-summary">
                <h3>Summary</h3>
                <div class="summary-shipping">
                    <strong>Shipping</strong>
                    <strong id="shipping-cost">$13.65</strong>
                </div>
                
                <hr>
                <div class="summary-item">
                    <strong>Item</strong>
                    <strong id="item-cost"></strong>
                </div>
                
                <hr>
                <div class="summary-total">
                    <strong>Total</strong>
                    <strong id="total-order"></strong>
                </div>
                <hr>
            </div>

            <button class="checkout-pay" disabled></button>
            <button class="checkout-cancel" onclick="goBack();">Cancel Order</button>
        </div>

        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php') ?>
    </body>
</html>