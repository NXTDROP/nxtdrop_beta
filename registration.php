<?php 
    include 'dbh.php';
    session_start();
    $email = $_GET['email'];
    $checkCountry = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if(mysqli_num_rows($checkCountry) > 0) {
        $data = $checkCountry->fetch_assoc();
        if($data['country'] != '') {
            $countryKnown = true;
            $country = $data['country'];
        } else {
            $countryKnown = false;
            $country = '';
        }
    } else {
        header("Location: nxtdrop.com");
        exit();
    }
?>
<!DOCTYPE html>

<html>
    <title>
    NXTDROP: The Fashion Trade Centre
    </title>
    <head>
        <base href="https://nxtdrop.com/">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="logstylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Font-Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            $(document).ready(function() {
                var email = <?php echo $_GET['email']; ?>;
                var country = <?php echo $countr; ?>;
                var countryKnown = <?php echo $countryKnown; ?>;

                if(countryKnown === true) {
                    $.ajax({
                        url: 'paymentRegistration.php',
                        type: 'POST',
                        data: {country: country, email: email},
                        success: function(response) {
                            if(response ===  'DB') {
                                $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                            } else if(response === '') {
                                $('#form-message').html('Thank you for updating your account. Hope to see you soon!');
                            } else {
                                $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                            }
                        },
                        error: function() {
                            $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                        }
                    });
                }

                $('#submit').click(function() {
                    country = $('.country_select').val();
                    $.ajax({
                        url: 'paymentRegistration.php',
                        type: 'POST',
                        data: {country: country, email: email},
                        success: function(response) {
                            if(response ===  'DB') {
                                $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                            } else if(response === '') {
                                $('#form-message').html('Thank you for updating your account. Hope to see you soon!');
                            } else {
                                $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                            }
                        },
                        error: function() {
                            $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                        }
                    });
                });
            });
        </script>
    </head>

    <body>
        </script>
        <header>
            <a href="home"><img id ="logo" src="img/nxtdroplogo.png" width="125px"></a>
        </header>
        
        <div class="form-container" style="margin-top: 150px">
            <select class="country_select">
                <option selected>Select Country [REQUIRED]</option>
                <option value="CA">CANADA</option>
                <option value="US">UNITED STATES</option>
            </select>
            <button type="submit" name="submit" id="submit">Update Account</button><br>
            <p id="agreement" style="margin: 10px 12.5%; width: 75%; text-align: center;">By creating an account, you agree to our <a href="terms" target="_blank">Terms of Use</a>, <a href="privacy" target="_blank">Privacy Policy</a> and the <a href="https://stripe.com/us/connect-account/legal" target="_blank">Stripe Connected Account Agreement</a>.<p>
            <p id="form-message" style="font-size: 13px; font-weight: 500;"></p>
        </div>
    </body>
</html>