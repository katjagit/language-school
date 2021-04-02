<?php
declare(strict_types=1);


function html_escape(string $string, string $encoding = 'UTF-8') : string
{
    return htmlspecialchars($string, ENT_QUOTES, $encoding);
}


function e($string) : string
{
    return html_escape((string) $string);
}


function error_for(
    array $errors,
    string $fieldname,
    string $format = '<div class="error_form">%s</div>'
) : string
{
    if (isset($errors[$fieldname])) {
        return sprintf($format, $errors[$fieldname]);
    }

    return '';
}
