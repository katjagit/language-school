<?php
//if (auth_user()){
//    $user_id = auth_id();
//    $user_pdo = $database->prepare('SELECT * FROM `users` WHERE `id` = ?');
//    $user_pdo->execute([$user_id]);
//    $user = $user_pdo->fetch();
//    /*$id = auth_id();
//    $user = db_raw_first(
//        "SELECT `status` FROM `users` WHERE `id` = $id");*/
//    }
?>

<div class="hero">
    <div class="top_nav">
    <a class="logo" href="<?= BASE_URL. 'index.php' ?>"><img src="<?= BASE_URL. 'medien/home/logo.png'?>" alt="Logo"></a>
    
    <nav class="main_menu">
        <a href="#open" class="open" id="open"><img src="<?= BASE_URL. 'medien/home/open.png'?>" alt="Menü" style="width: 70px"></a>
        <a href="#" class="close" id="close"><img src="<?= BASE_URL. 'medien/home/close.png'?>" alt="schließen" style="width: 50px"></a>
        <ul>
            <li><a href="<?= BASE_URL. 'index.php' ?>"
            class="<?= $active === 'index' ? 'active' : '' ?>">Home</a></li>
            <li><a href="<?= BASE_URL. 'pages/courses.php' ?>"
            class="<?= $active === 'courses' ? 'active' : '' ?>">Kurse</a></li>
            <li><a href="<?= BASE_URL. 'pages/contact.php' ?>"
            class="<?= $active === 'contact' ? 'active' : '' ?>">Kontakt</a></li>

        <?php if (auth_user()) : ?>


            <li><a href="<?= BASE_URL. 'pages/user-profile.php' ?>" class="<?= $active === 'user-profile' ? 'active' : '' ?>">Mein Profil</a></li>
            <li><a href="<?= BASE_URL. 'auth/logout.php' ?>"
            class="<?= $active === 'logout' ? 'active' : '' ?>">Ausloggen</a></li>

        
        <?php else: ?>
            <li><a href="<?= BASE_URL. 'auth/register.php' ?>"
            class="<?= $active === 'register' ? 'active' : '' ?>">Registrieren</a></li>

            <li><a id='login' href="<?= BASE_URL. 'auth/login.php' ?>">Anmelden</a></li>
        <?php endif; ?>
        </ul>
    </nav>
    </div>
</div>