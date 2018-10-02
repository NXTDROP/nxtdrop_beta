<?php 
    session_start();
    include "dbh.php";
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Fashion Trade Centre
    </title>
    <head>
        <?php include('inc/head.php'); ?>

        <style type="text/css">
            body {
                font-family: 'Ubuntu', sans-serif;
                background: #f5f5f5;
            }

            label img {
                width: 100px;
            }

            h1 {
                font-family: 'Ubuntu', sans-serif;
                font-weight: 700;
                text-align: center;
                margin: 15px 15px 0px 15px;
                font-size: 20px;  
                letter-spacing: 1px;
                text-transform: uppercase;  
            }

            #small {
                text-align: center;
                font-size: 12px;
            }

            .brand_selection {
                width: 100%;
                margin: 20px 0;
            }
            
            .brand_selection img {
                width: 5%;
                margin: 50px 7.38%;
                display: inline-block;
                cursor: pointer;
                padding: 10px;
                border-radius: 4px;
            }

            .brand_selection img:hover {
                background-color: #f27178;
            }

            .interest {
                width: 100%;
            }

            .interest table {
                width: 100%;
                margin: 20px 0;
                font-weight: 700;
            }

            .interest table tr {
                text-align: center;
            }

            .interest table tr td img {
                width: 15%;
                cursor: pointer;
                padding: 8px;
                border-radius: 4px;
            }

            .interest table tr td img:hover {
                background-color: #f27178;
            }

            .pref-btn {
                width: 40%;
                margin: 50px 30%;
                padding: 8px;
                text-transform: uppercase;
                letter-spacing: 2px;
                cursor: pointer;
                border: 1px solid #f27178;
                background-color: #f27178;
                color: #fff;
                border-radius: 4px;
                font-weight: 700;
            }


            .pref-btn:hover {
                background-color: #c64d53;
                border-color: #c64d53;
            }

            .selected {
                background: #c64d53;
            }

            .iselected {
                background: #c64d53;
            }
        </style>

        <script type="text/javascript">
            $(document).ready(function() {
                var i = 0;
                var j = 0;
                var brand1;
                var brand2;
                var interest;
                $('.brand_selection > img').click(function() {
                    var id = $(this).attr('id');
                    if($('#'+id+'').hasClass('selected')) {
                        $('#'+id+'').removeClass('selected');
                        i--;
                    } else {
                        if(i < 2) {
                            $('#'+id+'').addClass('selected');
                            i++;
                        }
                    }

                    if(i == 1) {
                        brand1 = id;
                    } else {
                        brand2 = id;
                    }
                });
                
                $('td > img').click(function() {
                    var id = $(this).attr('id');
                    if($('#'+id+'').hasClass('iselected')) {
                        $('#'+id+'').removeClass('iselected');
                        j--;
                    } else {
                        if(j < 1) {
                            $('#'+id+'').addClass('iselected');
                            j++;
                        }
                    }

                    interest = id;
                });

                $('.pref-btn').click(function() {
                    if(i != 2) {
                        alert('Please select two brands.');
                    } else if(j != 1) {
                        alert('Please tell us what you interested in.');
                    } else {
                        //alert('Brand 1: ' + brand1 + '\n Brand 2 :' + brand2 + '\n Interest: ' + interest);
                        $('.pref-btn').html('<i class="fas fa-circle-notch fa-spin"></i>');
                        $.ajax({
                            url: 'inc/preferences/send.php',
                            type: 'POST',
                            data: {brand1: brand1, brand2: brand2, interest: interest},
                            success: function(response) {
                                console.log(response);
                                if(response === 'CONNECTION') {
                                    $('.pref-btn').html('Error.');
                                    setTimeout(() => {
                                        $('.pref-btn').html('NEXT');
                                    }, 3000);
                                } else if(response === 'DB') {
                                    $('.pref-btn').html('Error.');
                                    setTimeout(() => {
                                        $('.pref-btn').html('NEXT');
                                    }, 3000);
                                } else if(response === 'MISSING') {
                                    $('.pref-btn').html('Error.');
                                    setTimeout(() => {
                                        $('.pref-btn').html('NEXT');
                                    }, 3000);
                                } else if(response === 'GOOD') {
                                    $('.pref-btn').html('Welcome <?php echo $_SESSION['username']?>');
                                    setTimeout(() => {
                                        $('.pref-btn').html('Redirecting...');
                                    }, 2000);
                                    setTimeout(() => {
                                        window.location.replace('home');
                                    }, 4000);
                                } else {
                                    setTimeout(() => {
                                        $('.pref-btn').html('NEXT');
                                    }, 3000);
                                }
                            },  
                            error: function(response) {
                                console.log(response);
                                $('.pref-btn').html('We have a problem. Try later.');
                                setTimeout(() => {
                                    $('.pref-btn').html('NEXT');
                                }, 2500);
                            }
                        });
                    }
                })
            });
        </script>
    </head>

    <body>
        <img class="pref_logo" src="img/nxtdroplogo.png" style="width: 5%; margin: 10px 47.5%;">

        <div class="brand_selection">
            <h1>What brands are you interested in? Choose Two.</h1>
            <p id="small">Tap on logo to select</p>
            <img src="img/adidaslogo.png" alt="Adidas" id="adidas">
            <img src="img/nikelogo.png" alt="Nike" id="nike">
            <img src="img/jordanlogo.png" alt="Jordan Brand" id="jordan">
            <img src="img/vanslogo.png" alt="Vans" id="vans">
            <img src="img/nblogo.png" alt="New Balance" id="newbalance">
        </div>

        <div class="interest">
            <h1>What are you interested in?</h1>
            <table>
                <tr>
                    <td><img src="img/shop.png" alt="SELLING" id="sell"></td>
                    <td><img src="img/both.png" alt="BOTH" id="both"></td>
                    <td><img src="img/cart.png" alt="BUYING" id="buy"></td>
                </tr>
                <tr>
                    <td><p>SELLING</p></td>
                    <td><p>BOTH</p></td>
                    <td><p>BUYING</p></td>
                </tr>
            </table>
        </div>

        <button class="pref-btn">NEXT</button>
    </body>
</html>