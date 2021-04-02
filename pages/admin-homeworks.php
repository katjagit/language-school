<?php
declare(strict_types=1);
require '../parts/bootstrap.php';

$page_title = 'Homeworks';

include PATH. 'parts/head.php';

//$user_id = auth_id();
//$user_pdo = $database->prepare('SELECT * FROM `users` WHERE `id` = ?');
//$user_pdo->execute([$user_id]);
//$user = $user_pdo->fetch();

//$user = db_raw_first("SELECT * FROM `users` WHERE `id` = $user_id");

if ($user['status'] === 'user') {
  redirect(BASE_URL.'pages/user-profile.php');
}

$homeworks = db_raw_select("SELECT `homeworks`.*, `courses`.`name`, `users`.`name` AS 'username', `lectures`.`lecture-number` 
FROM `homeworks` LEFT JOIN `courses` ON `homeworks`.`course-id` = `courses`.`id` 
LEFT JOIN `users` ON `homeworks`.`user-id` = `users`.`id` LEFT JOIN `lectures` ON `homeworks`.`lecture-id` = `lectures`.`id`");

$feedbacks = db_raw_select("SELECT HF.*, `users`.`name` FROM `homework-feedbacks` AS HF LEFT JOIN `users` 
ON HF.`author` = `users`.`id` ORDER BY `homework-id`, `created-at` ");

$action = request('action') ?? '';

if ($action === 'send') {
    $feedback = request('feedback');
    $homework_id = request('homework-id');
    if (empty($feedback)) {
        $errors['empty-feedback'] = 'Das Feld darf nicht leer sein.';
    }

    if(!$errors){
        db_insert('homework-feedback', [
            'homework-id' => $homework_id,
            'text' => $feedback,
            'author' => $user_id
        ]);
    }


}

?>
<header>
        <div class="hero_text">
        <h1>Lehrer-Profil</h1>
        </div>
</header> 

<main class="user">
  <div class="sidebar">
    <img src="../medien/profile/profilbild.png" alt="Profilbild">
    <h3>Marta Lehrerin</h3>
    <ul>
        <li><a href="">Hausaugaben</a></li>
        <li><a href="">Profil bearbeiten</a></li>
        <li><a href="">Kurse verwalten</a></li>
    </ul>
  </div>
  <div class="content">
    <h2>Kurse, die ich betreue</h2>
    <p>Übersicht der Hausaufgaben</p>
    <div class="homeworks">
      <?php foreach ($homeworks as $homework) : ?>
        <p><?= $homework['created-at']?></p>
            <p><?= $homework['name'] ?></p>
            <p><?= $homework['lecture-number'] ?></p>
            <p><?= $homework['username'] ?></p>
            <p><?= $homework['text'] ?></p>
            <?php foreach ($feedbacks as $feedback) : ?>
                <?php if ($feedback['homework-id'] === $homework['id']) : ?>
                    <p><?= $feedback['created-at'] ?></p>
                    <p><?= $feedback['name'] ?></p>
                    <p><?= $feedback['text'] ?></p>
                <?php endif; ?>
                <?php endforeach; ?>
        <?php if ($action === 'answer' && $homework['id'] === ($_POST['homework-id'] ?? 0)) : ?>
              <div>
                  <form action="<?= BASE_URL. 'pages/admin-homeworks.php' ?>" method="POST">
                      <textarea name="feedback" id="feedback" cols="20" rows="10"></textarea>
                      <button name="action" value="send" type="submit">abschicken</button>
                      <button name="action" value="cancel" type="submit">abbrechen</button>
                      <input type="hidden" name="homework-id" value="<?= $homework['id'] ?>">
                  </form>
              </div>
        <?php else: ?>
            <form action="" method="post">
            <button type="submit" name="action" value="answer">antworten</button>
            <input type="hidden" name="homework-id" value="<?= $homework['id'] ?>">
            </form>
        <?php endif;?>
      <?php endforeach; ?>
      </div>
    </div>
     
</main>


<?php 
include PATH. 'parts/footer.php'; 