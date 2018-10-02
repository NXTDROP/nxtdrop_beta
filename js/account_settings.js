const stripe = Stripe('pk_live_ZeS4R1yiq76rObz3ADsgOs13');

$(document).ready(function() {
    updateInfo();
    $('#Bank').css('display', 'none');

    $('#CC_PayInfo').css('display', 'none');

    if (country == 'US') {
        $('#inputCountry').attr('placeholder', 'United States of America');
        $('label[for="inputSIN"]').css('display', 'none');
        $('#payout_checkbox').prop('checked', 'checked');
        $('#payBank').css('display', 'none');
    }
    else {
        $('#inputCountry').attr('placeholder', 'Canada');
        $('#card_payout_radio').attr('disabled', true);
        $('#bank_payout_radio').attr('checked', true);
        
    }

    $('#payout_checkbox').change(function() {
        if ($('#payout_checkbox').prop('checked')) {
            $('#card_payout_radio').attr('disabled', true);
            $('#bank_payout_radio').attr('disabled', true);
            $('#payBank').css('display', 'none');
            $('#CC_PayInfo').css('display', 'none');
        }
        else {
            $('#bank_payout_radio').attr('disabled', false);
            if(country == "US") $('#card_payout_radio').attr('disabled', false);
            if(country == 'CA') $('#payBank').css('display', 'block');
        }
    });

    $('#personal_info').change(function() {
        if($('#individual').prop('checked')) {
            $('#inputBusinessName').attr('disabled', true);
            $('#inputBusinessNumber').attr('disabled', true);
        }
        else {
            $('#inputBusinessName').attr('disabled', false);
            $('#inputBusinessNumber').attr('disabled', false);
        }
    });

    $('#payoutOption').change(function() {
        if($('#card_payout_radio').prop('checked')) {
            $('#CC_PayInfo').css('display', 'block');
            $('#payBank').css('display', 'none');
        }
        else {
            $('#payBank').css('display', 'block');
            $('#CC_PayInfo').css('display', 'none');
        }
    });

    /*************** Personal Information Handling ***************************************/
    $('.personal_information').submit(function(e) {
        e.preventDefault();
        $('#update_personalInfo').html('<i class="fas fa-circle-notch fa-spin"></i>');

        var first_name = document.querySelector('#inputFirstName').value;
        var last_name = document.querySelector('#inputLastName').value;
        var day = document.querySelector('#inputDay').value;
        var month = document.querySelector('#inputMonth').value;
        var year = document.querySelector('#inputYear').value;
        var address = document.querySelector('#inputAddress').value;
        var city = document.querySelector('#inputCity').value;
        var state = document.querySelector('#inputState').value;
        var zip = document.querySelector('#inputZip').value;
        var entity = document.querySelector('input[name=entity]:checked').value;
        var social = document.querySelector('#inputSocial').value;

        var complete_address = address + ', ' + city + ', ' + state + ' ' + zip;

        if(country == 'US') {
            var social_length = 4;
        }
        else if(country == 'CA') {
            var social_length = 12;
        }

        if(isEmpty(first_name) || isBlank(first_name)) {
            $('#personal_info_errors').html('First Name is empty.');
        }
        else {
            if(isEmpty(last_name) || isBlank(last_name)) {
                $('#personal_info_errors').html('Last Name is empty.');
            }
            else {
                if(day >= 31) {
                    $('#personal_info_errors').html('Day cannot be higher than 31. It is currently ' + day);
                }
                else {
                    if(month >= 12) {
                        $('#personal_info_errors').html('Month cannot be higher than 12. It is currently ' + month);
                    }
                    else {
                        if(year >= new Date().getFullYear()) {
                            $('#personal_info_errors').html('Year cannot be higher than current year. It is currently ' + year);
                        }
                        else {
                            var current_date = new Date();
                            var date = new Date(year, month-1, day, 0, 0, 0);
                            if(dateDiffInYears(date, current_date) < 18) {
                                $('#personal_info_errors').html('You are not of legal age to use our platform.');
                            }
                            else {
                                if(entity != 'individual' && entity != 'company') {
                                    $('#personal_info_errors').html('Pick entity (Individual or Business).');
                                }
                                else {
                                    if(social.length != social_length) {
                                        if(social != "") {
                                            $('#personal_info_errors').html('Your SSN/SIN is invalid.');
                                        }
                                        else {
                                            handlePersonalInfo(country, complete_address, first_name, last_name);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    });

    /*************** Payment Information Handling ***************************************/
    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
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
    
    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    $('.payment_information').submit(function(e) {
        e.preventDefault();
        $('#payment_submit').html('<i class="fas fa-circle-notch fa-spin"></i>');
        stripe.createToken(card).then(function(result) {
            if (result.error) {
              // Inform the customer that there was an error.
              var errorElement = document.getElementById('card-errors');
              errorElement.textContent = result.error.message;
            } else {
              // Send the token to your server.
              handleCC(result.token);
            }
        });
    });

    /*************** Payout Information Handling ***************************************/
    // Create an instance of Elements.
    var payout = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var stylePayout = {
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
    var cardPayout = payout.create('card', {style: stylePayout});
    
    // Add an instance of the card Element into the `card-element` <div>.
    cardPayout.mount('#card-element-payout');

    // Handle real-time validation errors from the card Element.
    cardPayout.addEventListener('change', function(eventPayout) {
        var displayErrorPayout = document.getElementById('card-errors-payout');
        if (eventPayout.error) {
            displayErrorPayout.textContent = eventPayout.error.message;
        } else {
            displayErrorPayout.textContent = '';
        }
    });

    $('.payout_information').submit(function(e) {
        e.preventDefault();
        $('#payout_submit').html('<i class="fas fa-circle-notch fa-spin"></i>');
        var type = document.querySelector('input[name=payoutOption]:checked').value;

        if(type == "bank") {
            if(country == 'US') {
                var transit = document.querySelector('#inputPayRouting').value;
                var account = document.querySelector('#inputPayAccount').value;
                var confAccount = document.querySelector('#inputConfPayAccount').value;
            }
            else if(country == 'CA') {
                var transitNumber = document.querySelector('#inputPayTransitNumber').value;
                var institution = document.querySelector('#inputPayInstitution').value;
                var account = document.querySelector('#inputPayAccount').value;
                var confAccount = document.querySelector('#inputConfPayAccount').value;

                if(account === confAccount) {
                    stripe.createToken('bank_account', {
                        country: 'CA',
                        currency: 'cad',
                        routing_number: transitNumber+institution,
                        account_number: account,
                    }).then(function(result) {
                        // Handle result.error or result.token
                        if(result.error) {
                            $('.payout_error').html('We cannot update your payout information now. Contact support@nxtdrop.com.');
                        }
                        else {
                            handlePayoutInfo(result.token);
                        }
                      });
                }
                else {
                    $('#inputPayAccount').css('border-color', '#cc0000');
                    $('#inputConfPayAccount').css('border-color', '#cc0000');
                }
            }
            else {
                $('#payout_submit').html('Error');
            }
        }
        else if(type == "card") {
            var extraDetails = {
                currency: 'usd',
                country: 'US'
            };

            stripe.createToken(cardPayout, extraDetails).then(function(resultPayout) {
                if (resultPayout.error) {
                    // Inform the customer that there was an error.
                    var errorElements = document.getElementById('card-errors-payout');
                    errorElements.textContent = resultPayout.error.message;
                } else {
                    // Send the token to your server.
                    handlePayoutInfo(resultPayout.token);
                }
            });
        }
        else {
            alert('else');
        }
    });

});


/********************************* FUNCTIONS *******************************************************************/

function isBlank(str) {
    return (!str || /^\s*$/.test(str));
}

function isEmpty(str) {
    return (!str || 0 === str.length);
}

function dateDiffInYears(dateold, datenew) {
    var ynew = datenew.getFullYear();
    var mnew = datenew.getMonth();
    var dnew = datenew.getDate();
    var yold = dateold.getFullYear();
    var mold = dateold.getMonth();
    var dold = dateold.getDate();
    var diff = ynew - yold;
    if (mold > mnew) diff--;
    else {
        if (mold == mnew) {
            if (dold > dnew) diff--;
        }
    }
    return diff;
}

async function handlePersonalInfo(country, address, first_name, last_name) {
    if(country == "US") {
        const result = await stripe.createToken('account', {
            legal_entity: {
                first_name: document.querySelector('#inputFirstName').value,
                last_name: document.querySelector('#inputLastName').value,
                dob: {
                    day: document.querySelector('#inputDay').value,
                    month: document.querySelector('#inputMonth').value,
                    year: document.querySelector('#inputYear').value
                },
                address: {
                    line1: document.querySelector('#inputAddress').value,
                    city: document.querySelector('#inputCity').value,
                    state: document.querySelector('#inputState').value,
                    postal_code: document.querySelector('#inputZip').value
                },
                type: document.querySelector('input[name=entity]:checked').value,
                ssn_last_4: document.querySelector('#inputSocial').value,
                business_name: document.querySelector('#inputBusinessName').value,
                business_tax_id: document.querySelector('#inputBusinessNumber').value
            }
        });

        if(result.token) {
            $.ajax({
                url: 'inc/account_settings/personalInfo.php',
                type: 'POST',
                data: {token: result.token.id, first_name: first_name, last_name: last_name, address: address},
                success: function(data) {
                    if(data != "") {
                        $('#personal_info_errors').html(data);
                        console.log('Error');
                    }
                    else {
                        console.log('Perfect');
                        $('#update_personalInfo').html('Update Personal Information');
                        updateInfo();
                    }
                },
                error: function() {
                    $('#personal_info_errors').html('Error 100. Contact us @ support@nxtdrop.com or text us @ 267 670-4645');
                }
            });
        }
        else if (result.error) {
            $('#personal_info_errors').html('Error 101. Contact us @ support@nxtdrop.com or text us @ 267 670-4645');
        }
    }
    else if(country == "CA") {
        const result = await stripe.createToken('account', {
            legal_entity: {
                first_name: document.querySelector('#inputFirstName').value,
                last_name: document.querySelector('#inputLastName').value,
                dob: {
                    day: document.querySelector('#inputDay').value,
                    month: document.querySelector('#inputMonth').value,
                    year: document.querySelector('#inputYear').value
                },
                address: {
                    line1: document.querySelector('#inputAddress').value,
                    city: document.querySelector('#inputCity').value,
                    state: document.querySelector('#inputState').value,
                    postal_code: document.querySelector('#inputZip').value
                },
                type: document.querySelector('input[name=entity]:checked').value,
                personal_id_number: document.querySelector('#inputSocial').value,
                business_name: document.querySelector('#inputBusinessName').value,
                business_tax_id: document.querySelector('#inputBusinessNumber').value
            }
        });

        if(result.token) {
            $('#token_PI').val(result.token.id);
    
            $.ajax({
                url: 'inc/account_settings/personalInfo.php',
                type: 'POST',
                data: {token: result.token.id, first_name: first_name, last_name: last_name, address: address},
                success: function(data) {
                    if(data != "") {
                        $('#personal_info_errors').html(data);
                        console.log('Error');
                    }
                    else {
                        console.log('Perfect');
                        $('#update_personalInfo').html('Update Personal Information');
                        updateInfo();
                    }
                },
                error: function() {
                    $('#personal_info_errors').html('Error 100. Contact us @ support@nxtdrop.com or text us @ 267 670-4645');
                }
            });
        }
        else if (result.error) {
            $('#personal_info_errors').html('Error 101. Contact us @ support@nxtdrop.com or text us @ 267 670-4645');
        }
    }
    else {
        $('#personal_info_errors').html('Sorry. Try Later!');
    }
}

function handleCC(token) {
    $.ajax({
        url: 'inc/account_settings/CCHandle.php',
        type: 'POST',
        data: {token: token.id},
        success: function(data) {
            if (data == "") {
                $('#payment_submit').html('UPDATED');
                setTimeout(function(){ $('#payment_submit').html('Update Payment Information'); }, 3000);
                updateInfo();
            }
            else {
                $('#payment_submit').html('ERROR');
                $('.error_payment').html(data);
                setTimeout(function(){ $('#payment_submit').html('Update Payment Information'); }, 3000);
            }
        },
        error: function() {
            $(".error_payment").html('Cannot update your payment information now. Try Later.');
        }
    });
}

function handlePayoutInfo(token) {
    $.ajax({
        url: 'inc/account_settings/BankHandle.php',
        type: 'POST',
        data: {token: token.id},
        success: function(data) {
            if (data == "") {
                $('#payout_submit').html('UPDATED');
                setTimeout(function(){ $('#payout_submit').html('Update Payout Information'); }, 3000);
                updateInfo();
            }
            else {
                $('#payout_submit').html('ERROR');
                $('.payout_error').html(data);
                setTimeout(function(){ $('#payout_submit').html('Update Payout Information'); }, 3000);
            }
        },
        error: function() {
            $(".error_payout").html('Cannot update your payout information now. Try Later.');
        }
    });
}

function updateInfo() {
    $(".load").fadeIn();
    $(".load_main").show();
    $.ajax({
        url: 'inc/account_settings/updateAccSettings.php',
        type: 'POST',
        success: function(data) {
            if(data === "ERROR") {
                console.log(data);
                $('.load_content').html('Could not load your information. Please try reloading the page.');
            }
            else {
                console.log(data);
                let jsonObject = JSON.parse(data);
                $(".load").fadeOut();
                $(".load_main").fadeOut();
                var entity = jsonObject[0]['entity'];
                if(entity === 'individual') {
                    $('#'+entity).prop('checked', true);
                }
                else if(entity === 'business') {
                    $('#inputBusinessName').attr('disabled', false);
                    $('#inputBusinessNumber').val('disabled', false);
                    $('#inputBusinessName').val(jsonObject[0]['businessName']);
                    $('#inputBusinessNumber').val(jsonObject[0]['businessNumber']);
                    $(entity).prop('checked', true);
                }
                $('#inputFirstName').val(jsonObject[0]['firstName']);
                $('#inputLastName').val(jsonObject[0]['lastName']);
                $('#inputMonth').val(jsonObject[0]['month']);
                $('#inputDay').val(jsonObject[0]['day']);
                $('#inputYear').val(jsonObject[0]['year']);
                $('#inputAddress').val(jsonObject[0]['street']);
                $('#inputCity').val(jsonObject[0]['city']);
                $('#inputState option[value="'+jsonObject[0]['state']+'"]').attr("selected", true);
                $('#inputZip').val(jsonObject[0]['zip']);
                if(jsonObject[0]['social'] != false) $('#inputSocial').val(jsonObject[0]['social']);
                if(jsonObject[0]['payout_brand'] != "") $('.current_payout_option').html('<small>Current payout option:</small><i class="fas fa-piggy-bank" style="color: #aa0000; margin-left: 5px;"></i><span id="currentPayoutOp" style="margin-left: 5px;"><strong>'+jsonObject[0]['payout_brand']+' ending in <span style="color: #aa0000">'+jsonObject[0]['payout_last4']+'</span>.</strong></span>');
                if(jsonObject[0]['card_brand'] != "") $('.current_payment_option').html('<small>Current payment option:</small><i class="fas fa-credit-card" style="color: #aa0000; margin-left: 5px;"></i><span id="currentPayoutOp" style="margin-left: 5px;"><strong>'+jsonObject[0]['card_brand']+' ending in <span style="color: #aa0000">'+jsonObject[0]['card_last4']+'</span>.</strong></span>');
            }
        },
        error: function() {
            $('.load_content').html('Could not load your information. Please try reloading the page.');
        }
    });
}