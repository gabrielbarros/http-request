<?php
spl_autoload_register(function($class) {
    require '../src/' . str_replace('\\', '/', $class) . '.php';
});
