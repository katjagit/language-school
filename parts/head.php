<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if (isset($page_title)) : ?>
    <title><?= $page_title?></title>
<?php else: ?>
    <title>Linguafan</title>
<?php endif; ?>
    <link rel="stylesheet" href="<?= BASE_URL. 'css/global.css'?>">
    <link rel="stylesheet" href="<?= BASE_URL. 'css/users-and-courses.css'?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    window.jQuery || document.write('<script src="../lib/js/jquery/jquery-3.5.1.js"><\/script>');
    </script>
    <?php if (isset($js_include_list)) : ?>
        <?php foreach ($js_include_list as $js_file_name) : ?>
            <script defer src="<?= BASE_URL. 'js/'. $js_file_name ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
</head>
<body>
<noscript>
    <b>&lt;noscript&gt;</b> Tag. Um das Benutzererlebnis zu verbessern benötigen Sie aktives JavaScript in Ihrem Browser.
</noscript>
    <?php include PATH.'parts/nav.php';