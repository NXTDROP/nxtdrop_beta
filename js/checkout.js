var street;
var city;
var state;
var postalCode;
var country;
var price;
var pic;
var item;
var card_brand;
var card_last4;
var seller_ID;
var total;
var shipping;
var discountID;
var discountAmount;
var discountType;
var discount;
const stripe = Stripe('pk_live_ZeS4R1yiq76rObz3ADsgOs13');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
var style = {
    base: {
        color: '#32325d',
        lineHeight: '18px',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
        color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

// Create an instance of the card Element.
var card = elements.create('card', {style: style});

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

$(document).ready(function() {
    $(".load").fadeIn();
    $(".load_main").show();
    getInfo();

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    $('#country').change(function() {
        if($(this).val() == "CA") {
            changeState('CA');
        }
        else if($(this).val() == "US") {
            changeState('US');
        }
    });

    $('#same_address').click(function() {
        if($('#same_address').prop('checked')) {
            $('#street').val(street);
            $('#city').val(city);
            $('#postalCode').val(postalCode);
            if (country === 'CA') {
                changeState('CA');
            }
            $('#country option[value="'+country+'"]').attr("selected", true);
            $('#state option[value="'+state+'"]').attr("selected", true);
        }
        else {
            $('#street').val('');
            $('#city').val('');
            $('#postalCode').val('');
            $('#state option[value="'+state+'"]').attr("selected", false);
            $('#country option[value="'+country+'"]').attr("selected", false);
            var newState = "AL";
            var newCountry = "US";
            changeState('US');
            $('#state option[value="'+newState+'"]').attr("selected", true);
            $('#country option[value="'+newCountry+'"]').attr("selected", true);
        }
    });

    $('input').focusin(function() {
        $(this).css('border-color', 'tomato');
    });

    $('input').focusout(function() {
        $(this).css('border-color', '#cccccc');
    });

    $('select').focusin(function() {
        $(this).css('border-color', 'tomato');
    });

    $('select').focusout(function() {
        $(this).css('border-color', '#cccccc');
    });


    $('#card_on_file').click(function() {
        if($('#card_on_file').prop('checked')) {
            $('#card-element').css('display', 'none');
        }
        else {
            $('#card-element').css('display', 'block');
        }
    });

    $('.checkout-pay').click(function() {
        var cardVerification;
        $('.checkout-pay').html('<i class="fas fa-circle-notch fa-spin"></i>');
        if(!$('#card_on_file').prop('checked')) {
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                  // Inform the customer that there was an error.
                  var errorElement = document.getElementById('card-errors');
                  errorElement.textContent = result.error.message;
                } else {
                  // Send the token to your server.
                  cardVerification = handleCC(result.token);
                }
            });
        }
        
        var streetInput = $('#street').val();
        var cityInput = $('#city').val();
        var postalCodeInput = $('#postalCode').val();
        var stateInput = $('#state').val();
        var countryInput = $('#country').val();
        if((isBlank(streetInput) || isEmpty(streetInput)) || (isBlank(cityInput) || isEmpty(cityInput)) || (isBlank(postalCodeInput) || isEmpty(postalCodeInput)) || (isBlank(stateInput) || isEmpty(stateInput)) || (isBlank(countryInput) || isEmpty(countryInput)))  {
            $('input').css('border-color', 'red');
            $('select').css('border-color', 'red');
            alert('You forgot your shipping address?');
            setTimeout(resetBorderColor, 10000);
        }
        else {
            if(cardVerification == false) {
                alert('Sorry, your card was rejected.');
            }
            else {
                var fullAddress = streetInput + ', ' + cityInput + ', ' + stateInput + ' ' + postalCodeInput + ', ' + countryInput;
                //console.log('ID: ' + item_ID + ', Address: ' + fullAddress + ', DiscountID: ' + discountID  + ', Total: ' + total);

                if(typeof shipping != 'number') {
                    shipping = 0.00;
                }

                $.ajax({
                    url: 'inc/checkout/placeOrder.php',
                    type: 'POST',
                    data: {item_ID: item_ID, shippingAddress: fullAddress, discountID: discountID, totalPrice: total, shippingCost: shipping},
                    success: function(data) {
                        if(data === 'ERROR 101') {
                            alert('You must be logged in to purchase an item.');
                            $('.checkout-pay').html('Pay $'+total.toFixed(2));
                        }
                        else if(data === 'ERROR 102') {
                            alert('We have a problem. Please try to purchase later.');
                            $('.checkout-pay').html('Pay $'+total.toFixed(2));
                        }
                        else {
                            window.location.replace('orderPlaced.php?transactionID='+data);
                        }
                    },
                    error: function() {
                        alert('Sorry, we could not place your order. Contact our support team @ support@nxtdrop.com.');
                        $('.checkout-pay').html('Pay $'+total.toFixed(2));
                    }
                });
            }
        }
    });

    $('#discount-btn').click(function() {
        var code = $('#discount').val();
        $(this).html('<i class="fas fa-circle-notch fa-spin"></i>');
        if(isBlank(code) || isEmpty(code)) {
            $('#discount-error').html('Discount code is empty.').css('color', 'tomato');   
            $('#discount-btn').html('ADD PROMO CODE');
        } else {
            $.ajax({
                url: 'inc/checkout/checkDiscount.php',
                type: 'POST',
                data: {code: code, item_ID: item_ID},
                success: function(response) {
                    if (response === 'CONNECTION') {
                        $('#discount-error').html('You are not connected.').css('color', 'tomato');
                        $('#discount-btn').html('ADD PROMO CODE');
                    } else if (response === 'ERROR') {
                        $('#discount-error').html('You are not connected.').css('color', 'tomato');
                        $('#discount-btn').html('ADD PROMO CODE');
                    } else if (response === 'DB') {
                        $('#discount-error').html('You are not connected.').css('color', 'tomato');
                        $('#discount-btn').html('ADD PROMO CODE');
                    } else if (response === 'INVALID') {
                        $('#discount-error').html('Discount code is invalid. Discount used already or code doesn&apos;t exist.').css('color', 'tomato');
                        $('#discount-btn').html('ADD PROMO CODE');
                    } else {
                        console.log(response);
                        if(typeof response === 'string') {
                            let jsonObject = JSON.parse(response);
                            discountID = jsonObject[0]['ID'];
                            discountType = jsonObject[0]['type'];
                            discountAmount = jsonObject[0]['amount'];
                            if (discountType === 'cash') {
                                discount = parseFloat(discountAmount);
                                total = total - discount;
                            } else if (discountType === 'percentage') {
                                discount = total * (discountAmount / 100);
                                total = total - discount;
                            }
                            $('#discount-error').html('Discount Activated.').css('color', 'green');
                            $('#total-order').html('$' + total.toFixed(2));
                            $('.checkout-pay').html('Pay $' + total.toFixed(2));
                            $('#item-discount').html('- $' + discount.toFixed(2));
                            $('#discount-btn').html('ADD PROMO CODE');
                        } else {
                            $('#discount-error').html('We have a problem. Please, try later.').css('color', 'tomato');
                            $(this).html('ADD PROMO CODE');
                        }
                    }
                },
                error: function(response) {
                    console.log(response);
                    $('#discount-error').html('We have a problem. Please, try later.').css('color', 'tomato');
                }
            });
        }
    });
});

function getInfo() {
    $.ajax({
        url: 'inc/checkout/getInfo.php',
        type: 'POST',
        data: {item_ID: item_ID},
        success: function(data) {
            if(data === "ERROR") {
                $(".load").fadeOut();
                $(".load_main").hide();
                console.log(data);
                alert('Sorry, there was an error. Try again.');
            }
            else if(data === "CONNECTION") {
                $(".load").fadeOut();
                $(".load_main").fadeOut();
                alert('You must be logged in to make a purchase.');
            }
            else if(data === 'ID') {
                $(".load").fadeOut();
                $(".load_main").fadeOut();
                alert('This item does not exist.');
            } 
            else if(data === "DB") {
                $(".load").fadeOut();
                $(".load_main").fadeOut();
                console.log(data);
                alert('Sorry, there was an error. Try again.');
            }
            else {
                console.log(data);
                if (typeof data === 'string') {
                    let jsonObject = JSON.parse(data);
                    street = jsonObject[0]['street'];
                    city = jsonObject[0]['city'];
                    state = jsonObject[0]['state'];
                    postalCode = jsonObject[0]['postalCode'];
                    country = jsonObject[0]['country'];
                    price = parseFloat(jsonObject[0]['price']);
                    pic = jsonObject[0]['pic'];
                    item = jsonObject[0]['item'];
                    total = parseFloat(price + 0.00);
                    card_brand = jsonObject[0]['card_brand'];
                    card_last4 = jsonObject[0]['card_last4'];
                    seller_ID = jsonObject[0]['seller_ID'];
                    shipping = jsonObject[0]['shipping'];

                    if(shipping != 'FREE') {
                        total = price + shipping;
                    }

                    $('#item-cost').html('$'+price.toFixed(2));
                    $('#item_price').html('$'+price.toFixed(2));
                    $('#total-order').html('$'+total.toFixed(2));
                    $('.checkout-pay').html('Pay $'+total.toFixed(2));
                    $('#item_img').attr('src', pic);
                    $('#item_img').attr('alt', item);
                    $('#item_img').attr('title', item);
                    $('#item_description').html(item);
                    $('#shipping-cost').html('$' + shipping);
                    if(card_brand != "") $('label[for="card_on_file"]').html('Pay with ' + card_brand + '<i class="fas fa-credit-card" style="color: #aa0000; margin-left: 5px;"></i> ending in '+card_last4+'.');
                    else { $('#card_on_file').css('display', 'none'); $('label[for="card_on_file"]').css('display', 'none'); }
                    $(".load").fadeOut();
                    $(".load_main").fadeOut();
                } else {
                    console.log(data);
                    alert('We have a problem. Please, try again.');
                }
            }
        },
        error: function(data) {
            alert('Sorry, there was an error. Try again.');
            console.log(data)
        }
    });
}

function isBlank(str) {
    return (!str || /^\s*$/.test(str));
}

function isEmpty(str) {
    return (!str || 0 === str.length);
}

function resetBorderColor() {
    $('input').css('border-color', '#cccccc');
    $('select').css('border-color', '#cccccc');
}

function handleCC(token) {
    $.ajax({
        url: 'inc/account_settings/CCHandle.php',
        type: 'POST',
        data: {token: token.id},
        success: function(data) {
            if (data == "") {
                return true;
            }
            else {
                return false
            }
        },
        error: function(data) {
            return false;
        }
    });
}

function changeState(country) {
    if(country == "CA") {
        $('#state').html('<option value="AB">Alberta</option><option value="BC">British Columbia</option><option value="MB">Manitoba</option><option value="NB">New Brunswick</option><option value="NL">Newfoundland and Labrador</option><option value="NS">Nova Scotia</option><option value="ON">Ontario</option><option value="PE">Prince Edward Island</option><option value="QC">Quebec</option><option value="SK">Saskatchewan</option><option value="NT">Northwest Territories</option><option value="NU">Nunavut</option><option value="YT">Yukon</option>');
        $('#postalCode').attr('placeholder', 'M6K 3P6');
    }
    else if(country == "US") {
        $('#state').html('<option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District Of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option>');
        $('#postalCode').attr('placeholder', '90046');
    }
}