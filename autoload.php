<?php

function my_autoloader($className)
{
    require __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
}