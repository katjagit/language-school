<?php
declare(strict_types=1);

require '../parts/bootstrap.php';
require '../parts/contact-validation.php';

$page_title = 'Kontakt';
$active = 'contact';

$js_include_list = [
    'jquery/validate/jquery.validate.min.js',
    'jquery/validate/additional-methods.min.js',
    'jquery/validate/localization/messages_de.min.js',
    'form-validation.js'];

include PATH. 'parts/head.php';

?>


<header>
    <div class="hero_text">
    <h1>Wir bleiben im Kontakt</h1>
    </div>
</header> 
    <main class="wrap85 margin_bottom">
        <div class="width45" id="div-contact">
            <h2>Kontakt zu uns</h2>
            <p>Haben Sie Fragen oder brauchen Sie Hilfe? Kontanktieren Sie uns über dieses Kontaktformular, wir helfen Ihnen umgehen weiter.</p>
            <form action="<?= BASE_URL.'pages/contact.php#feedback'?>" method="POST" id="contact">
                <fieldset>
                    <legend>Ihre Angaben</legend>
                    <!-- FIRSTNAME -->
                    <?= error_for($errors, 'empty_firstname') ?>
                    <div>
                    <label for="firstname" class="req inline-block">Vorname:</label>
                    <input type="text" class="width75 inline-block" id="firstname" name="firstname" placeholder="Max" required value="<?= $firstname ?? '' ?>">
                    </div>
                    
                    <!-- LASTNAME -->
                    <?= error_for($errors, 'empty_lastname') ?>
                    <div>
                    <label for="lastname" class="req inline-block">Nachname:</label>
                    <input type="text" class="width75 inline-block" id="lastname" name="lastname" placeholder="Mustermann" required value="<?= $lastname ?? '' ?>">
                    </div>
                    
                    <!-- EMAIL -->
                    <?= error_for($errors, 'empty_email') ?>
                    <?= error_for($errors, 'email_invalid') ?>
                    <div>
                    <label for="email" class="req inline-block">Email:</label>
                    <input type="email" class="width75 inline-block" id="email" name="email" placeholder="name@site.de" required value="<?= $email ?? '' ?>">
                    </div>
                    
                    <!-- RADIO BUTTONS -->
                    <?= error_for($errors, 'empty_status') ?>
                    <div>
                    <input type="radio" name="status" id="user" value="user" required>
                    <label for="user" class="radio">Ich bin Schüler</label>
                    <input type="radio" name="status" id="teacher" value="teacher" required>
                    <label for="teacher" class="radio">Ich bin Lehrer</label>
                    </div>

                    <!-- OPTIONS -->
                    <?= error_for($errors, 'empty_subject') ?>
                    <div>
                    <label for="subject" id="label_subject" class="req">Wählen Sie den Grund:</label>
                    <select name="subject" id="subject" required>
                        <option value="" disabled selected>-- Bitte auswählen --</option>
                        <option 
                        <?php check_option($subject, 'kursberatung') ?>
                        value="kursberatung">Beratung zu den Kursen</option>
                        
                        <option
                        <?php check_option($subject, 'lehrerberatung') ?>
                        value="lehrerberatung">Beratung für Lehrer</option>

                        <option
                        <?php check_option($subject, 'support') ?>
                        value="support">Technische Hilfe</option>
                        <option
                        <?php check_option($subject, 'payquestion') ?>
                        value="payquestion">Fragen zur Bezahlung</option>
                    </select>
                    </div>
                    
                    <!-- TEXT AREA -->
                    <?= error_for($errors, 'empty_message') ?>
                    <div>
                    <label for="message" id="text_area" class="req">Beschreiben Sie Ihr Anliegen:</label><br>
                    <textarea name="message" id="message" required><?= $message ?? '' ?></textarea>
                    </div>
                    
                    <!-- CHECKBOX -->
                    <?= error_for($errors, 'empty_agb') ?>
                    <div>
                    <span class="req"></span>
                    <input class="checkbox" type="checkbox" name="datenschutz" value="yes" required>
                    <label for="datenschutz" class="label-checkbox">Ich akzeptiere die <a href="<?= BASE_URL.'pages/datenschutz.php'?>" >Datenschtzrichtlinien</a>.</label>
                    </div>
                    <!-- SUBMIT -->
                    <button type="submit" class="submit_button block">absenden</button>
                </fieldset>
            </form>
            <?php if (isset($feedback)) : ?>

        </div>
        <div class="feedback" id="feedback">
            <?= e($feedback) ?? '' ?>
        </div>
        <?php endif; ?>
        </div>
    </main>

    
<?php 
include PATH. 'parts/footer.php';