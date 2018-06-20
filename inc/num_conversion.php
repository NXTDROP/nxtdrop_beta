<?php
    function likes($num) {
        if ($num < 1000 && $num >= 0) {
            return $num;
        }
        else if ($num >= 1000 && $num < 1000000) {
            $new_num = round($num / 1000, 1);
            return $new_num.'k';
        }
        else if ($num > 1000000) {
            $new_num = round($num / 1000000, 1);
            return $new_num.'M';
        }
        else {
            return 0;
        }
    }
?>