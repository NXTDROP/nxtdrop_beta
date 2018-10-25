<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-546WBVB');</script>
<!-- End Google Tag Manager -->
<?php
    if($_SERVER['SERVER_NAME'] === 'localhost') {
        $base = 'https://localhost/nd-v1.00/';
    } else {
        $base = 'https://nxtdrop.com/';
    }
?>
<base href="<?php echo $base; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="robots" content="index, follow" />
<meta name="google" content="notranslate" />
<meta name="language" content="english" />
<meta name="twitter:card" value="summary" />
<meta name="twitter:site" content="@nxtdrop" />
        <?php
            if(isset($_GET['model'])) {
                echo '<meta name="description" content="Buy and Sell '.$model.' on NXTDROP and many other '.$brand.' shoes." />';
                echo '<meta name="twitter:title" content="'.$model.' - NXTDROP - Canada&apos;s #1 Sneaker Marketplace" />';
                echo '<meta name="og:title" content="'.$model.' - NXTDROP - Canada&apos;s #1 Sneaker Marketplace" />';
                echo '<meta name="twitter:description" content="Buy and Sell '.$model.' on NXTDROP and many other '.$brand.' shoes." />';
                echo '<meta name="og:description" content="Buy and Sell '.$model.' on NXTDROP and many other '.$brand.' shoes." />';
                echo '<meta name="keywords" content="'.$brand.', '.$line.', '.$model.', sneakers, nxtdrop, buy, real, shoes" />';
            } else {
                echo 'NXTDROP - Canada&apos;s #1 Sneaker Marketplace';
            }
        ?>
<meta name="twitter:creator" content="@nxtdrop" />
<meta name="twitter:image" content="/img/nxtdroplogo.png" />
<meta name="twitter:image:alt" content="NXTDROP" />
<meta property="og:type" content="website" />
<meta property="og:url" content="www.nxtdrop.com" />
<meta property="og:image" content="/img/nxtdroplogo.png" />
<meta property="og:site_name" content="NXTDROP" />
<meta http-equiv="Content-Language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">

<!-- CSS -->
<link type="text/css" rel="stylesheet" href="main.css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

<!-- Font-Awesome -->
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>

<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover();
    });
</script>