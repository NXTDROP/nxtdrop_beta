<?php

    function usdTocad($usdPrice, $db, $display) {
        include($db);
        $getConversion = $conn->prepare("SELECT conversion FROM currency WHERE currencyCode = ?;");
        if(isset($_SESSION['country'])) {
            if($_SESSION['country'] == 'US') {
                if($display) {
                    return '$'.$usdPrice;
                } else {
                    return $usdPrice;
                }
            } elseif($_SESSION['country'] == 'CA') {
                $currency = 'CAD';
                $getConversion->bind_param('s', $currency);
                if($getConversion->execute()) {
                    $getConversion->bind_result($conversion);
                    $getConversion->fetch();
                    $newPrice = $usdPrice * $conversion;
                    $getConversion->close();
                    if($display) {
                        return 'C$'.ceil($newPrice);
                    } else {
                        return ceil($newPrice);
                    }
                } else {
                    if($display) {
                        return '$'.$usdPrice;
                    } else {
                        return $usdPrice;
                    }
                }
            } else {
                if($display) {
                    return '$'.$usdPrice;
                } else {
                    return $usdPrice;
                }
            }
        } else {
            if($display) {
                return '$'.$usdPrice;
            } else {
                return $usdPrice;
            }
        }
    }

    function cadTousd($cadPrice, $db, $display) {
        include($db);
        $getConversion = $conn->prepare("SELECT conversion FROM currency WHERE currencyCode = ?;");
        $currency = 'CAD';
        $getConversion->bind_param('s', $currency);
        if($getConversion->execute()) {
            $getConversion->bind_result($conversion);
            $getConversion->fetch();
            $newPrice = $cadPrice / $conversion;
            $getConversion->close();
            if($display) {
                return '$'.floor($newPrice);
            } else {
                return floor($newPrice);
            }
        } else {
            if($display) {
                return 'C$'.$cadPrice;
            } else {
                return $cadPrice;
            }
        }
    }

?>