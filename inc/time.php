<?php
    function getLocalIp() { return gethostbyname(trim(`hostname`)); }
    
    function getPostTime($data) {
        //$ip = getLocalIp();

        $ip = "68.82.13.180";
        $url = "http://ip-api.com/json/".$ip;
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);
        $date = new DateTime();
        $date->setTimeZone(new DateTimeZone($json_data['timezone']));
        $date2 = new DateTime($data);
        $date2->setTimeZone(new DateTimeZone($json_data['timezone']));
        $date = $date->format('Y-m-d H:i:s') . "\n";
        $date2 = $date2->format('Y-m-d H:i:s') . "\n";
        $diff = abs(strtotime($date2) - strtotime($date));
        
        if ($diff < 60) {
            return $diff . " s";
        }
        else if ($diff < 3600) {
            return floor($diff/60) . " m";
        }
        else if ($diff/(3600) < 24) {
            return floor($diff/3600) . " h";
        }
        else if (floor($diff/86400)  < 365) {
            return floor($diff/86400) . " d";
        }
        else {
            return floor(($diff/86400) / 365) . " y";
        }

    }
?>