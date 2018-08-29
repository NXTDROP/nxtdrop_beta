const stripe = Stripe('pk_test_CVpEzpXzTZ97XvjAR1suM1m6');
var street;
var city;
var state;
var postalCode;
var country;
var price;
var pic;
var item;

$(document).ready(function() {
    getInfo();

    $('#country').change(function() {
        if($(this).val() == "CA") {
            $('#state').html('<option value="AB">Alberta</option><option value="BC">British Columbia</option><option value="MB">Manitoba</option><option value="NB">New Brunswick</option><option value="NL">Newfoundland and Labrador</option><option value="NS">Nova Scotia</option><option value="ON">Ontario</option><option value="PE">Prince Edward Island</option><option value="QC">Quebec</option><option value="SK">Saskatchewan</option><option value="NT">Northwest Territories</option><option value="NU">Nunavut</option><option value="YT">Yukon</option>');
            $('#postalCode').attr('placeholder', 'M6K 3P6');
        }
        else if($(this).val() == "US") {
            $('#state').html('<option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District Of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option>');
            $('#postalCode').attr('placeholder', '90046');
        }
    });

    $('#same_address').click(function() {
        if($('#same_address').prop('checked')) {
            $('#street').val(street);
            $('#city').val(city);
            $('#postalCode').val(postalCode);
            $('#state option[value="'+state+'"]').attr("selected", true);
            $('#country option[value="'+country+'"]').attr("selected", true);
        }
        else {
            $('#street').val('');
            $('#city').val('');
            $('#postalCode').val('');
            $('#state option[value="'+state+'"]').attr("selected", false);
            $('#country option[value="'+country+'"]').attr("selected", false);
            var newState = "AL";
            var newCountry = "US";
            $('#state option[value="'+newState+'"]').attr("selected", true);
            $('#country option[value="'+newCountry+'"]').attr("selected", true);
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
                alert('Sorry, there was an error. Try again.');
            }
            else if(data === "CONNECTION") {
                alert('You must be logged in to make a purchase.');
            }
            else if(data === 'ID') {
                alert('This item does not exist.');
            }
            else if(data === 'NO CARD') {
                alert('You have not filed a card to make a purchase.');
            }
            else {
                console.log(data);
                let jsonObject = JSON.parse(data);
                street = jsonObject[0]['street'];
                city = jsonObject[0]['city'];
                state = jsonObject[0]['state'];
                postalCode = jsonObject[0]['postalCode'];
                country = jsonObject[0]['country'];
                price = parseFloat(jsonObject[0]['price']);
                pic = jsonObject[0]['pic'];
                item = jsonObject[0]['item'];
                var total = price + 13.65;

                $('#item-cost').html('$'+price.toFixed(2));
                $('#item_price').html('$'+price.toFixed(2));
                $('#total-order').html('$'+total);
                $('.checkout-pay').html('Pay $'+total);
                $('#item_img').attr('src', pic);
                $('#item_img').attr('alt', item);
                $('#item_img').attr('title', item);
                $('#item_description').html(item);
            }
        },
        error: function(data) {

        }
    });
}