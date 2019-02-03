<?php 
    session_start();
    include "dbh.php";
    $db = 'dbh.php';
    require_once('login/rememberMe.php');
?>
<!DOCTYPE html>
<html>
    <head>
    <?php include('inc/head.php'); ?>
    <title>
        FAQ - NXTDROP - Canada's #1 Sneaker Marketplace
    </title>
    <link rel="canonical" href="https://nxtdrop.com/faq" />
    </head>

    <body>
        <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB" height="0" width="0" style="display:none visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php include('inc/navbar/navbar.php'); ?>
        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php') ?>

        <div id="contact-info">
            <h2>Contact Us</h2>
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">How do I contact you?</button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">Customer service is very important to us. We're available 24/7 at help@nxtdrop.com.</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0 collapsetwo">
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div id="general-info">
            <h2>General Information</h2>
            <div class="accordion" id="accordionTwo">
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#generalone" aria-expanded="true" aria-controls="generalone">What is NXTDROP?</button>
                        </h5>
                    </div>
                    <div id="generalone" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionTwo">
                        <div class="card-body">Founded in 2018 and based in Toronto, Ontario, NXTDROP is an online sneaker marketplace. It is also the safest way to buy and sell sneakers in Canada. If you're looking to buy rare sneakers or make money selling, NXTDROP is the place for you. We offer an authentication service to make sure all the shoes sold are 100% authentic.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#generaltwo" aria-expanded="true" aria-controls="generaltwo">How does it work?</button>
                        </h5>
                    </div>
                    <div id="generaltwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionTwo">
                        <div class="card-body">Sellers list their sneaker on NXTDROP, while buyers browse over a 1,000 sneakers on the website. If a buyer makes a purchase, the seller is required to ship the sneakers to us for verification. Once we authenticate the sneakers, we'll ship them to you. If we find that the shoes are replicas or are not in condition, we'll cancel the order and refund you.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#generalthree" aria-expanded="true" aria-controls="generalthree">I can&apos;t find an answer to my question. What do I do?</button>
                        </h5>
                    </div>
                    <div id="generalthree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionTwo">
                        <div class="card-body">Contact us at help@nxtdrop.com</div>
                    </div>
                </div>
            </div> 
        </div>

        <div id="buying-nxtdrop">
            <h2>Buying on NXTDROP</h2>
            <div class="accordion" id="accordionThree">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#buyingone" aria-expanded="true" aria-controls="buyingone">What payment options do you accept?</button>
                        </h5>
                    </div>
                    <div id="buyingone" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionThree">
                        <div class="card-body">If you purchase on NXTDROP, we accept American Express, Discover, MasterCard, Visa, and PayPal.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#buyingtwo" aria-expanded="true" aria-controls="buyingtwo">Have issues purchashing?</button>
                        </h5>
                    </div>
                    <div id="buyingtwo" class="collapse" aria-labelledby="headingOne" data-parent="#accordionThree">
                        <div class="card-body">Our payment processor may be unable to complete a purchase. Make sure that the information that you entered is accurate. If the information you entered is correct, we recommend reaching the card issuing bank. If you're still having issues, please email us at help@nxtdrop.com.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#buyingthree" aria-expanded="true" aria-controls="buyingthree">Can I cancel my order?</button>
                        </h5>
                    </div>
                    <div id="buyingthree" class="collapse" aria-labelledby="headingOne" data-parent="#accordionThree">
                        <div class="card-body">You may cancel your order before the seller confirms it. <br> Please note: You can't cancel an order if you check out following a counter-offer.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#buyingfour" aria-expanded="true" aria-controls="buyingfour">How do I know that the sneakers are real?</button>
                        </h5>
                    </div>
                    <div id="buyingfour" class="collapse" aria-labelledby="headingOne" data-parent="#accordionThree">
                        <div class="card-body">We, at NXTDROP, work hard to ensure all shoes are 100% authentic. We review all sellers and their products. If you purchase from NXTDROP, the seller is required to ship the sneakers to us for verification before we ship them to you. If we find that the shoes are replicas or not in condition, we'll cancel the order and refund you.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#buyingfive" aria-expanded="true" aria-controls="buyingfive">How much does your authentication process cost?</button>
                        </h5>
                    </div>
                    <div id="buyingfive" class="collapse" aria-labelledby="headingOne" data-parent="#accordionThree">
                        <div class="card-body">Our authentication service is 100% free.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#buyingsix" aria-expanded="true" aria-controls="buyingsix">Do you accept returns?</button>
                        </h5>
                    </div>
                    <div id="buyingsix" class="collapse" aria-labelledby="headingOne" data-parent="#accordionThree">
                        <div class="card-body">WE DO NOT ACCEPT RETURNS. ALL SALE ARE FINAL!</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#buyingseven" aria-expanded="true" aria-controls="buyingseven">How much does shipping cost?</button>
                        </h5>
                    </div>
                    <div id="buyingseven" class="collapse" aria-labelledby="headingOne" data-parent="#accordionThree">
                        <div class="card-body">The shipping cost is CA$18 within Canada. Customers may incur additional charges for sneaker packs and heavy items. Since all shoes come to us for verification first, orders will typically arrive at the destination within 7-10 business days for domestic customers.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#buyingeight" aria-expanded="true" aria-controls="buyingeight">How long does it takes to receive my order?</button>
                        </h5>
                    </div>
                    <div id="buyingeight" class="collapse" aria-labelledby="headingOne" data-parent="#accordionThree">
                        <div class="card-body">Since all shoes come to us for authentication first, it typically takes 7-10 business days for orders to deliver domestically. It takes 3-4 days to get to us, 1-2 days to authenticate and 3-4 days to ship to you. As soon as we authenticate your sneakers, we'll ship them out to you and send you a link to track your package via email.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#buyingnine" aria-expanded="true" aria-controls="buyingnine">I never received my order. What do I do?</button>
                        </h5>
                    </div>
                    <div id="buyingnine" class="collapse" aria-labelledby="headingOne" data-parent="#accordionThree">
                        <div class="card-body">Log in to your account, go to "Dashboard" and see if your order shipped. If we shipped your order, please contact us at support@nxtdrop.com.</div>
                    </div>
                </div>
            </div>
        </div>

        <div id="selling-nxtdrop" style="margin-bottom: 50px;"> 
            <h2>Selling on NXTDROP</h2>
            <div class="accordion" id="accordionFour">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#sellingone" aria-expanded="true" aria-controls="sellingone">How do you sell on NXTDROP?</button>
                        </h5>
                    </div>
                    <div id="sellingone" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionFour">
                        <div class="card-body">
                            <figure>
                                <img src="img/s1.png" alt="How To Sell?" style="width: 100%; margin: 10px 0;">
                                <figcaption style="color: #aaa; font-size: 12px;">Icon in the navigation bar.</figcaption>
                            </figure>

                            <figure>
                                <img src="img/s2.png" alt="How To Sell?" style="margin: 10px 0;">
                                <figcaption style="color: #aaa; font-size: 12px;">Menu Tab.</figcaption>
                            </figure>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#sellingtwo" aria-expanded="true" aria-controls="sellingtwo">What are the commission for selling on NXTDROP?</button>
                        </h5>
                    </div>
                    <div id="sellingtwo" class="collapse" aria-labelledby="headingOne" data-parent="#accordionFour">
                        <div class="card-body">The commission fee is 12%. The commission fee can decrease depending on your number of successful sales.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#sellingthree" aria-expanded="true" aria-controls="sellingthree">Can I cancel my sale?</button>
                        </h5>
                    </div>
                    <div id="sellingthree" class="collapse" aria-labelledby="headingOne" data-parent="#accordionFour">
                        <div class="card-body">Our goal is to provide the best customers experience possible to both our sellers and buyers. If you must cancel, please contact us at support@nxtdrop.com. There may be charges if you cancel a sale after you confirmed it.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#sellingeleven" aria-expanded="true" aria-controls="sellingeleven">As a seller, do I pay for shipping?</button>
                        </h5>
                    </div>
                    <div id="sellingeleven" class="collapse" aria-labelledby="headingOne" data-parent="#accordionFour">
                        <div class="card-body">Once you confirm an order, you'll have to ship us the sneakers at your own expense. We're currently working to provide free shipping or a drop-off location in your city.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#sellingfour" aria-expanded="true" aria-controls="sellingfour">When do I get paid?</button>
                        </h5>
                    </div>
                    <div id="sellingfour" class="collapse" aria-labelledby="headingOne" data-parent="#accordionFour">
                        <div class="card-body">You will get paid as soon as we receive and authentic the sneakers.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#sellingfive" aria-expanded="true" aria-controls="sellingfive">How do I cash out?</button>
                        </h5>
                    </div>
                    <div id="sellingfive" class="collapse" aria-labelledby="headingOne" data-parent="#accordionFour">
                        <div class="card-body">Your earnings will be deposited to your bank account automatically after we authentic the sneakers. Make sure that you enter the accurate information when settings up your seller account. Business days are Monday - Friday, excluding holidays and if you cash out after business hours, the first day would be the following business day. <br><br> Note: It takes two business days for the funds to show up on your account.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#sellingsix" aria-expanded="true" aria-controls="sellingsix">How do I list sneakers for sale?</button>
                        </h5>
                    </div>
                    <div id="sellingsix" class="collapse" aria-labelledby="headingOne" data-parent="#accordionFour">
                        <div class="card-body">Tap the <i class="fa fa-plus" aria-hidden="true"></i> button to list your sneakers. Search for the sneakers you want to sell in the page search bar, then enter the necessary information about the shoes you're selling.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#sellingseven" aria-expanded="true" aria-controls="sellingseven">My sneakers just sold. What do I do?</button>
                        </h5>
                    </div>
                    <div id="sellingseven" class="collapse" aria-labelledby="headingOne" data-parent="#accordionFour">
                        <div class="card-body">Congrats! First, confirm the order, then you will receive an email with the address to ship the sneakers. <br><br> Reminder: You have two business days to ship the shoes to us otherwise you might receive a $15 penalty.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#sellingnine" aria-expanded="true" aria-controls="sellingnine">What happens if my sneakers are found to be fake?</button>
                        </h5>
                    </div>
                    <div id="sellingnine" class="collapse" aria-labelledby="headingOne" data-parent="#accordionFour">
                        <div class="card-body">If the sneakers do not pass the verification process, we will refund the buyer the full amount, and you will have the option to get your sneakers back or let NXTDROP dispose of it. If you want NXTDROP to ship you the sneakers back, you will have to pay for the shipping costs.</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#sellingten" aria-expanded="true" aria-controls="sellingten">I accepted an offer, but I received an error. What happened?</button>
                        </h5>
                    </div>
                    <div id="sellingten" class="collapse" aria-labelledby="headingOne" data-parent="#accordionFour">
                        <div class="card-body">If you accepted an offer but received an error message, most times the buyer did not have enough money. We authorize payments once the buyer makes a purchase, but the funds may not be available at the time we are capturing them from the bank. If you encounter such a problem, do not worry. We probably know about it too because we keep track of those things. <br><br> Reminder: Never ship sneakers unless you receive a confirmation email telling you so.</div>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once('inc/footer.php'); ?>
    </body>
</html>