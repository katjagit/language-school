<?php
declare(strict_types=1);
require '../../parts/bootstrap.php';
$active = 'lecture';
include PATH. 'parts/head.php';


if (!auth_user()) {
  redirect(BASE_URL.'auth/login.php');
}

/// If the user has clicked the button "start", the first lecture page will open, new entry in DB that the course is
///  started
$lecture_number = query('lecture-number');
$course_id = query('course-id');

$lecture_info = db_raw_first("SELECT `lectures`.*, `courses`.`name` FROM `lectures` LEFT JOIN `courses` 
ON `lectures`.`course-id` = `courses`.`id` WHERE `course-id` = $course_id AND `lecture-number` = $lecture_number");

if(request_is('post')) {

  $user = $_SESSION['_user'];

  if ($user['status'] === 'user') {
    $action = request('action');
    if($action === 'course-start') {

        $course_id = request('course-id');
        $relation = db_raw_first("SELECT * FROM `user-course-relations` WHERE `user-id` = ".auth_id()." 
        AND `course-id` = $course_id");
        if (empty($relation)){
            db_insert('user-course-relations', [
                'user-id' => auth_id(),
                'course-id' => $course_id
              ]);
        }
    }
    if($action === 'create') {
        $comment = request('comment');

        if ($comment === '') {
            $errors['comment'] = "Sie können keine leeren Kommentare schreiben.";
        }
    
        if (!$errors) {

            db_insert('homeworks', [
                'user-id' => auth_id(),
                'course-id' => $course_id,
                'lecture-id' => $lecture_info['id'],
                'text' => $comment
            ]);
        }
    }
    
  }
}

$homeworks = db_raw_first("SELECT * FROM `homeworks` WHERE `user-id` = ".auth_id()." 
AND `lecture-id` = {$lecture_info['id']}");


// http_build_query()

if (request_is('get')) {

    $relation = db_raw_first("SELECT * FROM `user-course-relations` WHERE `user-id` = ".auth_id()." 
    AND `course-id` = $course_id");

    if(empty($relation)) {
        redirect(BASE_URL.'auth/register.php');
    }
}



?>
<header>
        <div class="hero_text">
        <h1><?=e($lecture_info['name'])?></h1>
        </div>
</header>
<main class="user">
  <div class="content">
    <h2>Lektion <?=e($lecture_info['lecture-number']) ?></h2>
    <p><?= $lecture_info['content'] ?></p>

  <?php if (!empty($lecture_info['task'])) : ?>
    <div class="task">
        <h2>Hausaufgabe</h2>
        <?php if (!empty($homeworks)) : ?>
            <p style="color: green"><?= e($lecture_info['task']) ?></p>
            <p>
                <?= $homeworks['text'] ?>
            </p>
            <p style="font-size: 0.7em;"> Erstellt am: <?= $homeworks['created-at'] ?> | Bearbeitet am:
                <?= $homeworks['updated-at'] ?></p>

            
        <?php else : ?>
        <?php $url = BASE_URL. 'pages/courses/lektion.php?' . http_build_query([
                        'course-id' => $course_id,
                        'lecture-number' => $lecture_number
                    ]); ?>
        <form action="<?= $url ?>" method="POST">
            <label for="comment"><?= e($lecture_info['task']) ?></label>
            <div>
            <textarea name="comment" id="comment" cols="40" rows="4"></textarea>
            </div>
            <button type="submit" name="action" value="create">abschicken</button>
        </form>
        <?php endif; ?>
    </div>
  <?php endif; ?>
  </div>
<div class="sidebar">
  <?php include PATH. 'pages/courses/parts/nav.php' ?>
</div>
</main>
<?php 
include PATH. 'parts/footer.php';