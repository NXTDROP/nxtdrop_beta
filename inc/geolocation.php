<?php
    function locationSetup($key) {
        include '../dbh.php';
        $apiKey = $key;
        $ip = "184.145.126.67"; //Client IP Address
        $location = getGeolocation($apiKey, $ip);
        $decodeLocation = json_decode($location, true);

        $uid = $_SESSION['uid'];
        if($decodeLocation['district'] != ""){
            $city = $decodeLocation['city'].'/'.$decodeLocation['district'];
        }
        else {
            $city = $decodeLocation['city'];
        }
        $state = $decodeLocation['state_prov'];
        $country = $decodeLocation['country_name'];
        $zip_code = $decodeLocation['zipcode'];
        $timezone_name = $decodeLocation['time_zone']['name'];
        $IP_address = $decodeLocation['ip'];
        $last_updated = date("Y-m-d H:i:s", time());

        $sql = "INSERT INTO loc_info (uid, city, state, country, zip_code, timezone_name, IP_address, last_updated) VALUES ('$uid', '$city', '$state', '$country', '$zip_code', '$timezone_name', '$IP_address', '$last_updated') ON DUPLICATE KEY UPDATE city = '$city', state = '$state', country = '$country', zip_code = '$zip_code', timezone_name = '$timezone_name', IP_address = '$IP_address', last_updated = '$last_updated'";
        mysqli_query($conn, $sql);
    }

    function getGeolocation($apiKey, $ip, $lang = "en", $fields = "*", $excludes = "") {
        $url = "https://api.ipgeolocation.io/ipgeo?apiKey=".$apiKey."&ip=".$ip."&lang=".$lang."&fields=".$fields."&excludes=".$excludes;
        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));

        return curl_exec($cURL);
    }
?>