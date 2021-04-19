<?php
declare(strict_types=1);
require '../parts/bootstrap.php';
require_once '../lib/classes/User.class.php';

$page_title = 'Registrierung';
$active = 'register';

$js_include_list = [
    'jquery/validate/jquery.validate.min.js',
    'jquery/validate/additional-methods.min.js',
    'jquery/validate/localization/messages_de.min.js',
    'form-validation.js'];

require PATH. 'parts/head.php';

if (request_is('post')) {

    $arg = [
        ':name' => request('name'),
        ':lastname' => request('lastname'),
        ':email' => request('email'),
        ':password' => request('password'),
        ':status' =>request('status')
    ];

    $password_confirmation = request('password_confirmation');

    if ($arg[':name'] === '') {
        $errors['name'] = 'Das Feld darf nicht leer sein';
    }

    if (!filter_var($arg[':email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Bitte eine gültige Email eingeben';
    }

    if ($arg[':email'] === '') {
        $errors['email'] = 'Das Feld darf nicht leer sein';
    }

    if ($arg[':password'] !== $password_confirmation) {
        $errors['password-confirmation'] = 'Die Passwörter stimmen nicht überein';
    }

    if (mb_strlen($arg[':password']) < 6) {
        $errors['password'] = 'Passwort muss mind. 5 Zeichen haben';
    }

    if ($arg[':password'] === '') {
        $errors['password'] = 'Das Feld darf nicht leer sein';
    }

    if ($arg[':status'] === '') {
        $errors['status'] = 'Bitte wählen Sie einen Punkt';
    }

    if (!$errors) {
        $sql = "SELECT * FROM `users` WHERE `email` = :email";
        $email = [':email' => $arg[':email']];
        $user = $db->selectFirstRow($sql, $email);

        if ($user) {
            $errors['email'] = 'Diese Email existiert bereits';
        }
    }

    if (!$errors) {
        $hash_password = array(':password' => password_hash($arg[':password'], PASSWORD_DEFAULT));
        $arg = array_replace($arg, $hash_password);

        $new_user = new User();
        $new_user->register($arg);

        redirect(BASE_URL.'auth/login.php');
    }
}

?>

<header>
        <div class="hero_text">
        <h1>Registierung</h1>
        </div>
</header> 
<main class="wrap85 margin_bottom">
<div class="margin_top_3em width30">

<form action="<?= BASE_URL.'auth/register.php' ?>" method="post">
<fieldset>
<legend>Schnelle Registierung</legend>
    <div>
        <?= error_for($errors, 'name') ?>
        <label for="name" class="inline-block">Vorname:</label>
        <input type="text" class="width65 inline-block" name="name" id="name" placeholder="Max" required>
    </div>
    
    <div>
        <?= error_for($errors, 'empty_lastname') ?>
        <label for="lastname" class="inline-block">Nachname:</label>
        <input type="text" class="width65 inline-block" id="lastname" name="lastname" placeholder="Mustermann" required>
    </div>
    

    <div>
        <?= error_for($errors, 'email') ?>
        <label for="email" class="inline-block">Email:</label>
        <input type="email" class="width65 inline-block" name="email" id="email" placeholder="email@test.de" required>
    </div>

    <div>
        <?= error_for($errors, 'password') ?>
        <label for="password" class="inline-block">Passwort</label>
        <input type="password" class="width65 inline-block" name="password" id="password" required>
    </div>

    <div>
        <?= error_for($errors, 'password-confirmation') ?>
        <label for="password_confirmation" class="inline-block">Passwort bestätigen</label>
        <input type="password" class="width65" name="password_confirmation" id="password_confirmation" required>
    </div>

    <div>
        <?= error_for($errors, 'status') ?>
        <input type="radio" name="status" value="user" id="user" required>
        <label for="user">Ich bin Schüler</label>
        <input type="radio" name="status" value="teacher" id="teacher" required>
        <label for="teacher">Ich bin Lehrer</label>
    </div>

    <div>
        <button type="submit" class="submit_button block">registrieren</button>
    </div>
</fieldset>
</form>

<div>
    Hast du schin einen Account? Dann kannst du dich <a href="<?= BASE_URL.'auth/login.php' ?>">hier anmelden</a>.
</div>
</div>
</main>
<?php 
include PATH. 'parts/footer.php';
