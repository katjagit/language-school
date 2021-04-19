<?php
declare(strict_types=1);


function redirect(string $url, int $response_code = 302)
{
    header("Location: $url", true, $response_code);
    exit();
}
