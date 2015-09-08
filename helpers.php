<?php

function view($name, array $data = []) {
    static $engine = null;

    if ($engine === null) {
        $engine = new League\Plates\Engine(
            __DIR__ . "/templates"
        );
    }

    return $engine->render($name, $data);
}
