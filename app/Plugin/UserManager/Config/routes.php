<?php

    Router::connect("/users", array("plugin" => "customer_manager", "controller" => "users", "action" => "action"));
    
?>