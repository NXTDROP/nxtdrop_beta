<?php    
    function getPostTime($data) {
        date_default_timezone_set("UTC");

        /*$json = file_get_contents("https://api.ipify.org/?format=json");
        $json_data = json_decode($json, true);
        $ip = $json_data['ip'];
        $url = "http://ip-api.com/json/".$ip;
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);*/
        $date = new DateTime();
        $date->setTimeZone(new DateTimeZone('America/New_York')); //$json_data['timezone'])
        $date2 = new DateTime($data);
        $date2->setTimeZone(new DateTimeZone('America/New_York')); //$json_data['timezone'])
        $new_date = $date->format('Y-m-d H:i:s') . "\n";
        $new_date2 = $date2->format('Y-m-d H:i:s') . "\n";
        $diff = strtotime($new_date) - strtotime($new_date2);
        
        if ($diff > 0) {
            if ($diff > 0 && $diff < 60) {
                return $diff . " s";
            }
            else if ($diff < 3600) {
                return floor($diff/60) . " m";
            }
            else if ($diff/(3600) < 24) {
                return floor($diff/3600) . " h";
            }
            else if (floor($diff/86400)  < 7) {
                return floor($diff/86400) . " d";
            }
            else {
                if (intval($new_date) == intval($new_date2)) {
                    return $date2->format('M j');
                }
                else {
                    return $date2->format('j M Y');
                }        
            }
        }
        else {
            return "now";
        }

    }
?>