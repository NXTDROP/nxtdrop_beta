<style>
.invite {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    display: none;
}

.invite_close {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
}

.invite_main {
    width: 25%;
    height: auto;
    background: #fff;
    z-index: 15;
    position: fixed;
    top: 35%;
    border-radius: 4px;
    left: 37.5%;
    display: none;
    padding-bottom: 5px;
}

.invite_main h2 {
    text-align: center;
    border-bottom: 1px solid #afafaf;
    padding: 10px 0;
}

.invite_content {
    background: #FAFAFA;
    padding: 10px;
}

.invite_content input {
    width: 75%;
    margin: 0 12.5%;
    padding: 5px;
    border: solid 1px #cccccc;
}

.invite_content button {
    width: 50%;
    margin: 10px 25%;
    color: #fff;
    background: #e8e8e8;
    border: none;
    font-size: 12px;
    padding: 5px;
    border: solid 1px #e8e8e8;
    -webkit-transition: background-color 0.5s ease-out;
    -moz-transition: background-color 0.5s ease-out;
    -o-transition: background-color 0.5s ease-out;
    transition: background-color 0.5s ease-out;
}

/*.invite_content button:hover {
    color: #aa0000;
    background-color: #fff;
}*/

.invite_content p {
    font-size: 10px;
}
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $(".close").click(function(){
            $(".invite").fadeOut();
            $(".invite_main").fadeOut();
        });

        $("#email").keyup(function() {
            var n = $(this).val().length;
            if (n > 10) {
                $("#invite").attr("disabled", false);
                $("#invite").css('background-color', '#aa0000');
                $("#invite").css('border-color', '#aa0000');
            }
            else {
                $("#invite").attr("disabled", true);
                $("#invite").css('background-color', '#e8e8e8');
                $("#invite").css('border-color', '#e8e8e8');
            }
        });

        $("#invite").mouseenter(function () {
            $("#invite").css('color', '#aa0000');
            $("#invite").css('background-color', '#fff');
        });

        $("#invite").mouseleave(function () {
            $("#invite").css('color', '#fff');
            $("#invite").css('background-color', '#aa0000');
        });

        $("#invite").click(function () {
            alert($("#email").val());
        });
    });
</script>
<div class="invite">
            <div class="invite_close close"></div>
            <div class="invite_main">
                <h2>Invite a Friend</h2>
                <div class="invite_content">
                    <input type="text" placeholder="Enter Email Address" id="email">
                    <button type="submit" name="invite" id="invite" disabled="true">Send Invitation</button>
                    <p><b>Important:</b> Receive $10 if the person creates an account.</p>
                </div>
            </div>
</div>