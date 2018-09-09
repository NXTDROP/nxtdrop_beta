<style>
.login {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    display: none;
}

.login_close {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
}

.login_main {
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

.login_main h2 {
    text-align: center;
    padding: 15px 0;
    margin: 0;
    font-weight: 800;
    font-size: 25px;
    background: #aa0000;
    color: #fff;
    border-radius: 8px;
}

.login_content {
    background: #FAFAFA;
    padding: 10px;
    text-align: center;
    border-radius: 8px;
}

.login_content p {
    font-size: 25px;
    font-weight: 800;
    margin: 10px 0 15px 0;
}

.login_content strong {
    font-size: 26px;
}
</style>

<script>
    $(document).ready(function() {
        $(".close").click(function(){
            $(".login").fadeOut();
            $(".login_main").fadeOut();
        });
    });
</script>

<div class="login">
    <div class="login_close close"></div>
    <div class="login_main">
        <h2 id="login_title">Logging In...</h2>
        <div class="login_content">
            <p><i class="fas fa-circle-notch fa-spin fa-2x"></i></p>
        </div>
    </div>
</div>