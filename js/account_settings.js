const stripe = Stripe('pk_test_CVpEzpXzTZ97XvjAR1suM1m6');
$(document).ready(function() {
    $('#Bank').css('display', 'none');
    $('#CC_Info').css('display', 'none');

    $('#payBank').css('display', 'none');
    $('#CC_PayInfo').css('display', 'none');

    $('#payout_checkbox').prop('checked', 'checked');
    $('#card_payout_radio').attr('disabled', true);
    $('#bank_payout_radio').attr('disabled', true);

    if (country == 'US') {
        $('#inputCountry').attr('placeholder', 'United States of America');
        $('label[for="inputSIN"]').css('display', 'none');
    }
    else {
        $('#inputCountry').attr('placeholder', 'Canada');
        $('#card_payout_radio').attr('disabled', 'disabled');
    }

    $('#payout_checkbox').change(function() {
        if ($('#payout_checkbox').prop('checked')) {
            $('#card_payout_radio').attr('disabled', true);
            $('#bank_payout_radio').attr('disabled', true);
            $('#payBank').css('display', 'none');
            $('#CC_PayInfo').css('display', 'none');
        }
        else {
            $('#card_payout_radio').attr('disabled', false);
            $('#bank_payout_radio').attr('disabled', false);
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

    $('#paymentOption').change(function() {
        if($('#card_radio').prop('checked')) {
            $('#CC_Info').css('display', 'block');
            $('#Bank').css('display', 'none');
        }
        else {
            $('#Bank').css('display', 'block');
            $('#CC_Info').css('display', 'none');
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
});

/*************** Personal Information Handling ***************************************/
const myForm = document.querySelector('.my-form');
myForm.addEventListener('submit', handlePersonalInfo);

async function handlePersonalInfo(event) {
    event.preventDefault();

    const result = await stripe.createToken('account', {
        legal_entity: {
            first_name: document.querySelector('#inputFirstName').value,
            last_name: document.querySelector('#inputLastName').value,
            dob: {
                day: document.querySelector('').value,
                month: document.querySelector('').value,
                year: document.querySelector('').value
            },
            address: {
                line1: document.querySelector('').value,
                city: document.querySelector('').value,
                state: document.querySelector('').value,
                postal_code: document.querySelector('').value
            },
            type: document.querySelector('').value,
            ssn_last_4: document.querySelector('').value
        }
    });

    if(result.token) {
        document.querySelector('#token_PI').value = result.token.id;

        $.ajax({
            
        });
    }
}