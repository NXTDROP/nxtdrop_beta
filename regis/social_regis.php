<style>
.social_regis {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    display: none;
}

.social_regis_close {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
}

.social_regis_main {
    width: 40%;
    height: auto;
    background: #fff;
    z-index: 15;
    position: fixed;
    top: 30%;
    left: 30%;
    padding-bottom: 5px;
    border-radius: 8px;
    display: none;
}

.social_regis_main h2 {
    text-align: center;
    padding: 15px 0;
    margin: 0;
    font-weight: 800;
    font-size: 25px;
    background: #aa0000;
    color: #fff;
    border-radius: 8px;
}

.social_regis_content {
    background: #FAFAFA;
    padding: 10px;
    text-align: center;
    border-radius: 8px;
}

.social_regis_content p {
    font-size: 25px;
    font-weight: 800;
    margin: 10px 0 15px 0;
}

.social_regis_content strong {
    font-size: 26px;
}
</style>

<script>
    $(document).ready(function() {

    });
</script>

<div class="social_regis">
    <div class="social_regis_close close"></div>
    <div class="social_regis_main">
        <h2 id="social_regis_title"></h2>
        <div class="social_regis_content">
            <input type="text" name="username" id="social_username" placeholder="Username [Required]"><br>
            <select class="country_select" id="social_country" required>
                <option selected>Select Country [REQUIRED]</option>
                <option value="CA">CANADA</option>
                <option value="US">UNITED STATES</option>
            </select>
            <input type="text" name="invite" id="social_invite_code" placeholder="Have an invite code?"><br>
            <button type="submit" name="submit" id="social_submit">Create Account</button><br>
            <p id="agreement" style="margin-top: 10px; font-weight: 500;">By creating an account, you agree to our <a href="terms" target="_blank">Terms of Use</a>, <a href="privacy" target="_blank">Privacy Policy</a> and the <a href="https://stripe.com/us/connect-account/legal" target="_blank">Stripe Connected Account Agreement</a>.<p>
            <p id="social_form-message" style="font-size: 12px; font-weight: 500;"></p>
        </div>
    </div>
</div>