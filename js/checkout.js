/*var key;
$.getJSON('../credentials.json', function(json) {
    key = json.APIKEYS.stripe.US.live.public;
});
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
const stripe = Stripe("'"+key+"'");

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
}*/

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('4 27;$.36(\'../37.29\',7(29){27=29.38.1D.V.35.34});4 J;4 I;4 m;4 x;4 j;4 K;4 1w;4 u;4 15;4 1A;4 1K;4 f;4 n;4 1c;4 1g;4 1b;4 b;30 1D=31("\'"+27+"\'");4 1Z=1D.1Z();4 1x={39:{d:\'#3a\',3h:\'3i\',3f:\'"2d 2Z", 2d, 3b-3c\',3j:\'2V\',2Y:\'2U\',\'::1L\':{d:\'#2W\'}},2R:{d:\'#2y\',2X:\'#2y\'}};4 k=1Z.2T(\'k\',{1x:1x});k.3e(\'2L\',7(28){4 26=2a.2o(\'k-2m\');6(28.e){26.25=28.e.2p}8{26.25=\'\'}});$(2a).3Q(7(){$(".O").3R();$(".R").3S();1W();k.3T(\'#k-22\');$(\'#j\').2L(7(){6($(z).h()=="W"){13(\'W\')}8 6($(z).h()=="V"){13(\'V\')}});$(\'#2v\').1d(7(){6($(\'#2v\').24(\'21\')){$(\'#J\').h(J);$(\'#I\').h(I);$(\'#x\').h(x);6(j===\'W\'){13(\'W\')}$(\'#j 1[3="\'+j+\'"]\').l("P",10);$(\'#m 1[3="\'+m+\'"]\').l("P",10)}8{$(\'#J\').h(\'\');$(\'#I\').h(\'\');$(\'#x\').h(\'\');$(\'#m 1[3="\'+m+\'"]\').l("P",11);$(\'#j 1[3="\'+j+\'"]\').l("P",11);4 2z="2H";4 2s="V";13(\'V\');$(\'#m 1[3="\'+2z+\'"]\').l("P",10);$(\'#j 1[3="\'+2s+\'"]\').l("P",10)}});$(\'1C\').2f(7(){$(z).c(\'y-d\',\'v\')});$(\'1C\').2j(7(){$(z).c(\'y-d\',\'#1n\')});$(\'1v\').2f(7(){$(z).c(\'y-d\',\'v\')});$(\'1v\').2j(7(){$(z).c(\'y-d\',\'#1n\')});$(\'#S\').1d(7(){6($(\'#S\').24(\'21\')){$(\'#k-22\').c(\'1u\',\'1P\')}8{$(\'#k-22\').c(\'1u\',\'3O\')}});$(\'.r-M\').1d(7(){4 23;$(\'.r-M\').5(\'<i 1U="1O 17-2C-2x 17-2w"></i>\');6(!$(\'#S\').24(\'21\')){1D.3L(k).3M(7(1m){6(1m.e){4 2l=2a.2o(\'k-2m\');2l.25=1m.e.2p}8{23=2t(1m.1j)}})}4 1i=$(\'#J\').h();4 1o=$(\'#I\').h();4 19=$(\'#x\').h();4 1a=$(\'#m\').h();4 18=$(\'#j\').h();6((G(1i)||F(1i))||(G(1o)||F(1o))||(G(19)||F(19))||(G(1a)||F(1a))||(G(18)||F(18))){$(\'1C\').c(\'y-d\',\'2q\');$(\'1v\').c(\'y-d\',\'2q\');o(\'U 3N 1V n 3U?\');3V(2n,44)}8{6(23==11){o(\'16, 1V k 1E 45.\')}8{4 2e=1i+\', \'+1o+\', \'+1a+\' \'+19+\', \'+18;6(1I n!=\'41\'){n=0.2B}$.1l({1k:\'1h/r/40.Y\',14:\'1p\',9:{Q:Q,3W:2e,1c:1c,3Y:f,3Z:n},1e:7(9){6(9===\'1y 3I\'){o(\'U 2g 2h 2i 1T 1X 1M 1B u.\');$(\'.r-M\').5(\'T $\'+f.p(2))}8 6(9===\'1y 3s\'){o(\'1r 1s a 1t. 1z 1F 1X 1M 1R.\');$(\'.r-M\').5(\'T $\'+f.p(2))}8{3v.3m.3E(\'3y.Y?3K=\'+9)}},e:7(){o(\'16, 3B 3A 12 3z 1V 1H. 3C 3D 2D 3H @ 2D@3G.3F.\');$(\'.r-M\').5(\'T $\'+f.p(2))}})}}});$(\'#b-B\').1d(7(){4 A=$(\'#b\').h();$(z).5(\'<i 1U="1O 17-2C-2x 17-2w"></i>\');6(G(A)||F(A)){$(\'#b-e\').5(\'1f A 2P 3x.\').c(\'d\',\'v\');$(\'#b-B\').5(\'L H C\')}8{$.1l({1k:\'1h/r/3w.Y\',14:\'1p\',9:{A:A,Q:Q},1e:7(q){6(q===\'2r\'){$(\'#b-e\').5(\'U 1N 12 1Y.\').c(\'d\',\'v\');$(\'#b-B\').5(\'L H C\')}8 6(q===\'1y\'){$(\'#b-e\').5(\'U 1N 12 1Y.\').c(\'d\',\'v\');$(\'#b-B\').5(\'L H C\')}8 6(q===\'2O\'){$(\'#b-e\').5(\'U 1N 12 1Y.\').c(\'d\',\'v\');$(\'#b-B\').5(\'L H C\')}8 6(q===\'3p\'){$(\'#b-e\').5(\'1f A 2P 2R. 1f 3o 3n 3l A 3q&3r;t 2N.\').c(\'d\',\'v\');$(\'#b-B\').5(\'L H C\')}8{E.D(q);6(1I q===\'2E\'){2Q g=2I.2M(q);1c=g[0][\'20\'];1b=g[0][\'14\'];1g=g[0][\'3u\'];6(1b===\'3t\'){b=1J(1g);f=f-b}8 6(1b===\'3J\'){b=f*(1g/3X);f=f-b}$(\'#b-e\').5(\'1f 43.\').c(\'d\',\'42\');$(\'#f-1H\').5(\'$\'+f.p(2));$(\'.r-M\').5(\'T $\'+f.p(2));$(\'#u-b\').5(\'- $\'+b.p(2));$(\'#b-B\').5(\'L H C\')}8{$(\'#b-e\').5(\'1r 1s a 1t. 1z, 1F 1R.\').c(\'d\',\'v\');$(z).5(\'L H C\')}}},e:7(q){E.D(q);$(\'#b-e\').5(\'1r 1s a 1t. 1z, 1F 1R.\').c(\'d\',\'v\')}})}})});7 1W(){$.1l({1k:\'1h/r/1W.Y\',14:\'1p\',9:{Q:Q},1e:7(9){6(9==="1y"){$(".O").w();$(".R").3d();E.D(9);o(\'16, 1Q 1E 1B e. 1S 1q.\')}8 6(9==="2r"){$(".O").w();$(".R").w();o(\'U 2g 2h 2i 1T 1X 3g a 1M.\')}8 6(9===\'20\'){$(".O").w();$(".R").w();o(\'33 u 32 12 2N.\')}8 6(9==="2O"){$(".O").w();$(".R").w();E.D(9);o(\'16, 1Q 1E 1B e. 1S 1q.\')}8{E.D(9);6(1I 9===\'2E\'){2Q g=2I.2M(9);J=g[0][\'J\'];I=g[0][\'I\'];m=g[0][\'m\'];x=g[0][\'x\'];j=g[0][\'j\'];K=1J(g[0][\'K\']);1w=g[0][\'1w\'];u=g[0][\'u\'];f=1J(K+0.2B);15=g[0][\'15\'];1A=g[0][\'1A\'];1K=g[0][\'1K\'];n=g[0][\'n\'];6(n!=\'5I\'){f=K+n}$(\'#u-2b\').5(\'$\'+K.p(2));$(\'#5J\').5(\'$\'+K.p(2));$(\'#f-1H\').5(\'$\'+f.p(2));$(\'.r-M\').5(\'T $\'+f.p(2));$(\'#1G\').l(\'5D\',1w);$(\'#1G\').l(\'5E\',u);$(\'#1G\').l(\'5F\',u);$(\'#5K\').5(u);$(\'#n-2b\').5(\'$\'+n);6(15!="")$(\'2K[2J="S"]\').5(\'T 5R \'+15+\'<i 1U="1O 17-5P-k" 1x="d: #5M; 5N-47: 5C;"></i> 5B 1T \'+1A+\'.\');8{$(\'#S\').c(\'1u\',\'1P\');$(\'2K[2J="S"]\').c(\'1u\',\'1P\')}$(".O").w();$(".R").w()}8{E.D(9);o(\'1r 1s a 1t. 1z, 1F 1q.\')}}},e:7(9){o(\'16, 1Q 1E 1B e. 1S 1q.\');E.D(9)}})}7 G(N){Z(!N||/^\\s*$/.5p(N))}7 F(N){Z(!N||0===N.5o)}7 2n(){$(\'1C\').c(\'y-d\',\'#1n\');$(\'1v\').c(\'y-d\',\'#1n\')}7 2t(1j){$.1l({1k:\'1h/5n/5s.Y\',14:\'1p\',9:{1j:1j.5t},1e:7(9){6(9==""){Z 10}8{Z 11}},e:7(9){Z 11}})}7 13(j){6(j=="W"){$(\'#m\').5(\'<1 3="5x">5u</1><1 3="5v">5T 2u</1><1 3="5S">6h</1><1 3="6i">X 6j</1><1 3="6g">6f 6c 6d</1><1 3="6e">6k 6l</1><1 3="6q">6p</1><1 3="6n">6o 6m 2S</1><1 3="6b">6a</1><1 3="5Z">60</1><1 3="5Y">5X 5U</1><1 3="5V">5W</1><1 3="61">62</1>\');$(\'#x\').l(\'1L\',\'68 69\')}8 6(j=="V"){$(\'#m\').5(\'<1 3="2H">64</1><1 3="65">5k</1><1 3="5j">4w</1><1 3="4x">4y</1><1 3="W">4v</1><1 3="4u">4r</1><1 3="4s">4t</1><1 3="4z">4A</1><1 3="4G">4H 4F 2u</1><1 3="4E">4B</1><1 3="4C">4D</1><1 3="4q">4p</1><1 3="20">4d</1><1 3="4e">4f</1><1 3="4c">4b</1><1 3="48">49</1><1 3="4a">4g</1><1 3="4h">4n</1><1 3="4o">4m</1><1 3="4l">4i</1><1 3="4j">4k</1><1 3="4I">4J</1><1 3="58">59</1><1 3="57">56</1><1 3="53">54</1><1 3="55">5a</1><1 3="5b">5h</1><1 3="5i">5g</1><1 3="5f">5c</1><1 3="5d">X 5e</1><1 3="52">X 51</1><1 3="4P">X 4Q</1><1 3="4R">X 4O</1><1 3="4N">2c 2k</1><1 3="4K">2c 2F</1><1 3="4L">4M</1><1 3="4S">4T</1><1 3="4Z">50</1><1 3="4Y">4X</1><1 3="4U">4V 2S</1><1 3="4W">2G 2k</1><1 3="63">2G 2F</1><1 3="66">67</1><1 3="5y">5A</1><1 3="5z">5m</1><1 3="5l">5r</1><1 3="5O">2A</1><1 3="5Q">5L</1><1 3="5G">5H 2A</1><1 3="5w">46</1><1 3="3P">3k</1>\');$(\'#x\').l(\'1L\',\'5q\')}}',62,399,'|option||value|var|html|if|function|else|data||discount|css|color|error|total|jsonObject|val||country|card|attr|state|shipping|alert|toFixed|response|checkout|||item|tomato|fadeOut|postalCode|border|this|code|btn|CODE|log|console|isEmpty|isBlank|PROMO|city|street|price|ADD|pay|str|load|selected|item_ID|load_main|card_on_file|Pay|You|US|CA|New|php|return|true|false|not|changeState|type|card_brand|Sorry|fa|countryInput|postalCodeInput|stateInput|discountType|discountID|click|success|Discount|discountAmount|inc|streetInput|token|url|ajax|result|cccccc|cityInput|POST|again|We|have|problem|display|select|pic|style|ERROR|Please|card_last4|an|input|stripe|was|try|item_img|order|typeof|parseFloat|seller_ID|placeholder|purchase|are|fas|none|there|later|Try|in|class|your|getInfo|to|connected|elements|ID|checked|element|cardVerification|prop|textContent|displayError|key|event|json|document|cost|North|Helvetica|fullAddress|focusin|must|be|logged|focusout|Carolina|errorElement|errors|resetBorderColor|getElementById|message|red|CONNECTION|newCountry|handleCC|Columbia|same_address|spin|notch|fa755a|newState|Virginia|00|circle|support|string|Dakota|South|AL|JSON|for|label|change|parse|exist|DB|is|let|invalid|Island|create|16px|antialiased|aab7c4|iconColor|fontSize|Neue|const|Stripe|does|This|public|live|getJSON|credentials|APIKEYS|base|32325d|sans|serif|hide|addEventListener|fontFamily|make|lineHeight|18px|fontSmoothing|Wyoming|or|location|already|used|INVALID|doesn|apos|102|cash|amount|window|checkDiscount|empty|orderPlaced|place|could|we|Contact|our|replace|com|nxtdrop|team|101|percentage|transactionID|createToken|then|forgot|block|WY|ready|fadeIn|show|mount|address|setTimeout|shippingAddress|100|totalPrice|shippingCost|placeOrder|number|green|Activated|10000|rejected|Wisconsin|left|IA|Iowa|KS|Indiana|IN|Idaho|IL|Illinois|Kansas|KY|Maine|MD|Maryland|ME|Louisiana|Kentucky|LA|Hawaii|HI|Colorado|CT|Connecticut|CO|California|Arizona|AR|Arkansas|DE|Delaware|Florida|GA|Georgia|FL|Of|DC|District|MA|Massachusetts|ND|OH|Ohio|NC|York|NM|Mexico|NY|OK|Oklahoma|RI|Rhode|SC|Pennsylvania|PA|OR|Oregon|Jersey|NJ|MS|Mississippi|MO|Minnesota|MN|MI|Michigan|Missouri|MT|Nevada|NH|Hampshire|NV|Nebraska|Montana|NE|AZ|Alaska|VT|Utah|account_settings|length|test|90046|Vermont|CCHandle|id|Alberta|BC|WI|AB|TX|UT|Texas|ending|5px|src|alt|title|WV|West|FREE|item_price|item_description|Washington|aa0000|margin|VA|credit|WA|with|MB|British|Territories|NU|Nunavut|Northwest|NT|SK|Saskatchewan|YT|Yukon|SD|Alabama|AK|TN|Tennessee|M6K|3P6|Quebec|QC|and|Labrador|NS|Newfoundland|NL|Manitoba|NB|Brunswick|Nova|Scotia|Edward|PE|Prince|Ontario|ON'.split('|')))
