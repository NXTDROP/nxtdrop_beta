<?php
    if($activate) {
        if($confEmailError) {
            echo "<p class='error'>This user doesn't exist!</p>";
        }
        elseif (!$confEmailError) {
            echo "<p class='success'>A password recovery e-mail has been sent to you!</p>";
        }
    }
?>