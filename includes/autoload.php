<?php

spl_autoload_register(function ($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class . '.php';
});
