<?php

function dump(array | object $data) : void
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

function dd(array | object $data) : void
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die;
}

function generateRandomString(int $length = 5) : string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
