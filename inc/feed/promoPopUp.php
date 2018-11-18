<script>
    var promoProductID;
    var assetURL;
    var model;
    var retailPrice;
    var releaseDate;
    var brand;
    $(document).ready(function(){
        $('#enter_raffle').click(function() {
            $('#enter_raffle').html('<i class="fas fa-circle-notch fa-spin"></i>');
            var size =  $('#item_size').val();
            if(size == 0) {
                alert('Select a size.');
            } else {
                $.ajax({
                    url: 'inc/feed/placeHolidayOrder.php',
                    type: 'POST',
                    data: {itemID: promoProductID, size: size},
                    success: function(response) {
                        console.log(response);
                        if(response == 'GOOD') {
                            $('#enter_raffle').html('THANK YOU');
                            setTimeout(() => {
                                $('#enter_raffle').html('ENTER');
                                $('.promo_pop').fadeOut();
                                $('.promo_main').hide();
                            }, 3000);
                        } else if(response == 'DB') {
                            $('#enter_raffle').html('ENTER');
                            alert("We have a problem. Please try later.");
                        } else if(response == 'CONNECT') {
                            $('#enter_raffle').html('ENTER');
                            alert("You must be connected to enter the raffle.");
                        } else {
                            $('#enter_raffle').html('ENTER');
                            alert("We have a problem. Please try later.");
                        }
                    },
                    error: function(response) {
                        alert("We have a problem. Please try later.");
                    }
                });
            }
        });
    });
</script>

<style>
    #enter_raffle {
        border: none;
        border-radius: 4px;
        background: #f27178;
        padding: 5px;
        width: 60%;
        margin: 0px 20% 15px 20%;
        letter-spacing: 2px;
        cursor: pointer;
        color: #fff;
    }

    #enter_raffle:hover {
        background: #CA4950;
    }

    .promo_main {
        top: 60px;
    }

    .promo_content img {
        width: 40%;
        margin: 5px 30%;
    }

    .promo_content p {
        text-transform: uppercase;
        text-align: center;
        font-size: 14px;
        color: #CA4950;
    }

    .promo_content span {
        color: #555555;
    }

    #promo-item-description {
        width: 80%;
        text-align: center;
        margin: 0 10%;
    }

    #promo-item-description #header td p {
        color: #555555;
    }

    #promo-item-description tr td {
        padding: 5px;
        font-size: 11px;
        border: 1px solid #cccccc;
    }

    .promo_content #item_size {
        margin: 15px 30%;
        width: 40%;
    }

    .promo_main h2 {
        letter-spacing: 2px;
    }
</style>

<div class="transaction_pop promo_pop">
    <div class="transaction_close promo_close close"></div>
    <div class="transaction_main promo_main">
        <h2>ENTER RAFFLE</h2>
        <div class="transaction_content promo_content">  
            <img src="#" alt="">  

            <table id="promo-item-description">
                <tr id="header">
                    <td><p>Brand</p></td>
                    <td><p>Model</p></td>
                    <td><p>Release Date</p></td>
                    <td><p>Retail Price</p></td>
                </tr>

                <tr>
                    <td><p id="brand"></p></td>
                    <td><p id="model"></p></td>
                    <td><p id="releaseDate"></p></td>
                    <td><p id="retailPrice"></p></td>
                </tr>
            </table>

            <select name="size" id="item_size">
                <option value="0" selected>Select Size...</option>
                <option value="4">US 4</option>
                <option value="4.5">US 4.5</option>
                <option value="5">US 5</option>
                <option value="5.5">US 5.5</option>
                <option value="6">US 6</option>
                <option value="6.5">US 6.5</option>
                <option value="7">US 7</option>
                <option value="7.5">US 7.5</option>
                <option value="8">US 8</option>
                <option value="8.5">US 8.5</option>
                <option value="9">US 9</option>
                <option value="9.5">US 9.5</option>
                <option value="10">US 10</option>
                <option value="10.5">US 10.5</option>
                <option value="11">US 11</option>
                <option value="11.5">US 11.5</option>
                <option value="12">US 12</option>
                <option value="12.5">US 12.5</option>
                <option value="13">US 13</option>
                <option value="13.5">US 13.5</option>
                <option value="14">US 14</option>
                <option value="14.5">US 14.5</option>
                <option value="15">US 15</option>
                <option value="15.5">US 15.5</option>
                <option value="16">US 16</option>
                <option value="16.5">US 16.5</option>
                <option value="17">US 17</option>
            </select>

            <button id="enter_raffle">ENTER</button>
            <p style="font-size: 12px; margin: 5px 0; color: #555555;">Reminder: <b>You'll receive an email if you win. Good Lucky! Happy Thanksgiving!!!</b></p>
        </div>
    </div>       
</div>