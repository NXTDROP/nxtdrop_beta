<style>
.regis {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    display: none;
}

.regis_close {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
}

.regis_main {
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

.regis_main h2 {
    text-align: center;
    padding: 15px 0;
    margin: 0;
    font-weight: 800;
    font-size: 25px;
    background: #aa0000;
    color: #fff;
    border-radius: 8px;
}

.regis_content {
    background: #FAFAFA;
    padding: 10px;
    text-align: center;
    border-radius: 8px;
}

.regis_content p {
    font-size: 25px;
    font-weight: 800;
    margin: 10px 0 15px 0;
}

.regis_content strong {
    font-size: 26px;
}
</style>

<script>
    $(document).ready(function() {
        $(".close").click(function(){
            $(".regis").fadeOut();
            $(".regis_main").fadeOut();
        });
    });
</script>

<div class="regis">
    <div class="regis_close close"></div>
    <div class="regis_main">
        <h2 id="regis_title">Creating account...</h2>
        <div class="regis_content">
            <p><i class="fas fa-circle-notch fa-spin fa-2x"></i></p>
        </div>
    </div>
</div>