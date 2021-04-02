<?php

$user_id = request('id') ?? '';
$action = request('action') ?? '';

if (request_is('post')) {

    // UPDATE
    if ($action === 'update') {
        $name = request('name');
        $lastname = request('lastname');
        $email = request('email');

        if ($name === '') {
            $errors['name'] = 'Das Feld darf nicht leer sein';
        }

        if ($lastname === '') {
            $errors['lastname'] = 'Das Feld darf nicht leer sein';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Bitte eine gültige Email eingeben';
        }

        if ($email === '') {
            $errors['email'] = 'Das Feld darf nicht leer sein';
        }

        if (!$errors) {
            $feedback = 'Die Daten wurden aktualisiert';

            //User-Daten nochmal abfragen, sonst sind die Aktualisierungen erst beim zweiten Laden der Seite sichtbar.

            $user['name'] = $name;
            $user['lastname'] = $lastname;
            $user['email'] = $email;

            db_update('users', $user['id'], [
                'name' => $name,
                'lastname' => $lastname,
                'email' => $email
            ]);
        }
    }
}


?>
<div class="content">

    <?php if (($action === 'update-profile' || $action === 'update') && $user_id === $user['id']) : ?>

        <h2>Profil bearbeiten</h2>
        <?php if (isset($feedback)) : ?>
            <div class="feedback" id="feedback">
                <?= e($feedback) ?? '' ?>
            </div>
        <?php endif; ?>
        <form action="#" method="POST">

            <div>
                <?= error_for($errors, 'name') ?>
                <label for="name" class="inline-block">Vorname:</label>
                <input type="text" class="width65 inline-block" name="name" id="name" value="<?= e($user['name']) ?? '' ?>" required>
            </div>

            <div>
                <?= error_for($errors, 'lastname') ?>
                <label for="lastname" class="inline-block">Nachname:</label>
                <input type="text" class="width65 inline-block" id="lastname" name="lastname" value="<?= e($user['lastname']) ?? '' ?>" required>
            </div>


            <div>
                <?= error_for($errors, 'email') ?>
                <label for="email" class="inline-block">Email:</label>
                <input type="email" class="width65 inline-block" name="email" id="email" value="<?= e($user['email']) ?? '' ?>" required>
            </div>

            <div>
                <input type="hidden" name="id" id="id" value="<?= e($user['id']) ?>">
                <button type="submit" class="submit_button inline" name="action" value="update">speichern</button>
                <button class="submit_button inline" name="action" value="cancel">abbrechen</button>
            </div>

        </form>


    <?php else : ?>

        <div>
            <h2>Mein Profil</h2>
            <ul>
                <li><?= $user['name'] . ' ' . $user['lastname'] ?></li>
                <li><?= $user['email'] ?></li>
            </ul>
            <form action="#" method="POST">
                <button name="action" value="update-profile" type="submit" class="submit_button">Profil bearbeiten</button>
                <input type="hidden" name="id" value="<?= e($user['id']) ?>">
            </form>
        </div>

    <?php endif; ?>

</div>