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
                if($newPrice <= 1) {
                    return '$'.number_format($newPrice, 2);
                } else {
                    return '$'.floor($newPrice);
                }
            } else {
                if($newPrice < 1) {
                    return number_format($newPrice, 2);
                } else {
                    return floor($newPrice);
                }
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