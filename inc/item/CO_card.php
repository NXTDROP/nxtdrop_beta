<script>
    const stripe = Stripe('pk_live_ZeS4R1yiq76rObz3ADsgOs13');

    var verified;

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

    $(document).ready(function(){     

        $(".card_close").click(function(){
            $(".card_pop").fadeOut();
            $(".card_main").fadeOut(); 
        });
    });

    function card_verification() {
        $("#card_verification").html('<i class="fas fa-circle-notch fa-spin"></i>');
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the customer that there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                addCC(result.token);
                setTimeout(() => {
                    if(verified) {
                        setTimeout(() => {
                            $("#card_verification").html('Done');
                            $(".card_pop").fadeOut();
                            $(".card_main").fadeOut();
                            // Add an instance of the card Element into the `card-element` <div>.
                            card.unmount();
                        }, 2500);
                    } else {
                        $("#card_verification").html('Card Declined');
                        setTimeout(() => {
                            $("#card_verification").html('Done');
                        }, 2500);
                    }
                }, 3000);
            }
        });
    }

    function addCC(token) {
    $.ajax({
        url: 'inc/account_settings/CCHandle.php',
        type: 'POST',
        data: {token: token.id},
        success: function(data) {
            console.log(data);
            if (data == "") {
                verified = true;
            }
            else {
                verified = false;
            }
        },
        error: function(data) {
            verified = false;
        }
    });
}
</script>

<div class="card_pop">
    <div class="card_close"></div>
    <div class="card_main popup_window_main">
        <h2>Card Information</h2>
        <div class="card_content">
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

        <p>Disclaimer: We collect your card information to incentivize people to make serious offers. Note that you'll be charged if the seller accept your counter-offer. We cannot refund you unless the shoes fail to pass the authentication process.</p>

        <button id="card_verification" onclick="card_verification()">DONE</button>
    </div>       
</div>