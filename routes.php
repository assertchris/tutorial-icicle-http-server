<?php

$router->addRoute("GET", "/home", function() {
    return view("home", [
        "name" => "Chris"
    ]);
});
