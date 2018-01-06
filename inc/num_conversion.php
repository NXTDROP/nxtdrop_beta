<?php
    function likes($num) {
        if ($num < 1000) {
            return $num;
        }
        else if ($num >= 1000 && $num < 1000000) {
            $new_num = round($num / 1000, 1);
            return $new_num.'k';
        }
        else {
            $new_num = round($num / 1000000, 1);
            return $new_num.'M';
        }
    }
?>