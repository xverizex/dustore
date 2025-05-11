<?php

function use_pack($server_type){
    if($server_type == "PRODUCTION"){
        return ['localhost', 'dustore', 'leo', 'LeoBigLokkWasHere!'];
    } else if ($server_type == "LOCAL") {
        return ['localhost', 'dustore', 'root', ''];
    }
}