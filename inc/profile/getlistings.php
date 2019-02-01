<?php
    
    session_start();
    require_once('../../dbh.php');
    $db = '../../dbh.php';
    require_once('../currencyConversion.php');
    //$getOffers = $conn->prepare("SELECT size, price, offerID FROM offers WHERE sellerID = ? AND productID = ? AND offerID NOT IN (SELECT itemID FROM transactions, offers WHERE transactions.status != 'cancelled' and offers.offerID = transactions.itemID) ORDER BY size ASC");

    $getOffers = $conn->prepare("SELECT size, price, offerID FROM offers WHERE sellerID = ? AND productID = ? AND offerID NOT IN (SELECT * FROM (SELECT o.offerID FROM offers o, counterOffer r WHERE o.offerID = r.offerID UNION SELECT o.offerID FROM offers o, transactions t WHERE o.offerID = t.itemID AND t.status != 'cancelled' UNION SELECT o.offerID FROM offers o, reviewedCO r WHERE o.offerID = r.offerID AND r.status = 'accepted') AS A) ORDER BY size ASC");

    if(!isset($_SESSION['uid'])) {
        die('not connected');
    } else {
        if($_SESSION['country'] != 'US') {
            $currency = 'CA$';
        } else {
            $currency = '$';
        }
        
        if(!isset($_POST['productID'])) {
            die("error1");
        } else {
            $uid = $_SESSION['uid'];
            $productID = $_POST['productID'];
            $getOffers->bind_param("ii", $uid, $productID);
            if($getOffers->execute()) {
                $getOffers->bind_result($size, $price, $offerID);
                echo "<script>$(document).ready(function(){
                    $('.form-control').keydown(function (e) {
                        // Allow: backspace, delete, tab, escape, enter and .
                        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                            // Allow: Ctrl/cmd+A
                            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                    // Allow: Ctrl/cmd+C
                            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: Ctrl/cmd+X
                            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right
                            (e.keyCode >= 35 && e.keyCode <= 39)) {
                                // let it happen, don't do anything
                                return;
                        }
                        // Ensure that it is a number and stop the keypress
                        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                            e.preventDefault();
                        }
                    });
                });</script>";
                while($getOffers->fetch()) {
                    echo('<div class="one_item_listing listing-'.$offerID.'">
                        <h4>Size '.$size.'</h4>
                        <div class="input-group mb-3 item_price">
                            <div class="input-group-prepend">
                                <span class="input-group-text">'.$currency.'</span>
                            </div>
                            <input id="item_price-input" class="form-control input-'.$offerID.'" type="text" aria-label="Amount (to the nearest dollar)" placeholder="'.usdTocad($price, $db, false).'">
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                        <button onClick="saveChanges('.$offerID.');" class="btn-'.$offerID.'">Save New Price</button>
                        <button onClick="deleteListing('.$offerID.');" class="btn_delete-'.$offerID.'">Delete</button>

                    </div>');
                }
    
                $getOffers->close();
            } else {
                die("DB");
            }
        }
    }

?>