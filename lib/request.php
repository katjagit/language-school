<?php
declare(strict_types=1);

function request_method() : string
{
    return $_SERVER['REQUEST_METHOD'];
}


function request_is(string $method) : bool
{
    return strtolower(request_method()) === strtolower($method);
}

// Default Parameters

function request($key = null)
{
    return array_extract($_POST, $key);
}


function query($key = null)
{
    return array_extract($_GET, $key);
}


function array_extract(array $array, $key = null)
{
    if ($key === null) {
        return $array;
    }
    
    if (is_array($key)) {
        return array_intersect_key($array, array_flip($key));
    }

    return $array[$key] ?? '';
}
