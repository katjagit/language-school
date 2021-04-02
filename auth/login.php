<?php
declare(strict_types=1);
require '../parts/bootstrap.php';

$page_title = 'Einloggen';
$active = 'login';

$js_include_list = [
    'jquery/validate/jquery.validate.min.js',
    'jquery/validate/additional-methods.min.js',
    'jquery/validate/localization/messages_de.min.js',
    'form-validation.js'];

include PATH. 'parts/head.php';

if (request_is('post')) {

    $email = request('email');
    $password = request('password');

    if ($email === '') {
        $errors['email'] = 'Das Feld darf nicht leer sein';
    }

    if ($password === '') {
        $errors['password'] = 'Das Feld darf nicht leer sein';
    }

    if (!$errors) {
/*        $user_pdo = $database->prepare('SELECT * FROM `users` WHERE `email` = ?');
        $user_pdo->execute([$email]);
        $user = $user_pdo->fetch();
        var_dump($user);*/

        $user = db_raw_first(
            "SELECT * FROM `users` WHERE `email` = " . db_prepare($email)


        if (!$user) {
            $errors['email'] = 'Email oder Passwort ist nicht korrekt';
        }
    }

    if (!$errors) {
        if (!password_verify($password, $user['password'])) {
            $errors['email'] = 'Email oder Passwort ist nicht korrekt';
        }
    }

    if (!$errors) {
        login($user);
        redirect(BASE_URL.'pages/user-profile.php');

    }
}

?>
<header>
        <div class="hero_text">
        <h1>Ameldung</h1>
        </div>
</header> 
<main class="wrap85 margin_bottom">
<div class="margin_top_3em width30">
<form action="<?= BASE_URL.'auth/login.php' ?>" method="POST" id="login-form">
  <fieldset>
  <legend>Login</legend>
    <div>
        <?= error_for($errors, 'email') ?>
        <label for="email" class="inline-block">Email</label>
        <input type="email" class="width65" name="email" id="email" required>
    </div>

    <div>
        <?= error_for($errors, 'password') ?>
        <label for="password" class="inline-block">Passwort</label>
        <input type="password" class="width65" name="password" id="password" required>
    </div>

    <div>
        <button type="submit" class="submit_button block">Login</button>
    </div>
</fieldset>
</form>
<div class="text_center">
    Du hast noch keinen Account? Dann registriere dich <a href="<?= BASE_URL.'auth/register.php' ?>">hier</a>.
</div>
</div>

</main>
<?php 
include PATH. 'parts/footer.php';