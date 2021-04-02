<?php 
$courses = db_raw_select(
    "SELECT `user-course-relations`.*, `courses`.* FROM `user-course-relations` LEFT JOIN `courses` ON `user-course-relations`.`course-id` = `courses`.`id` WHERE `user-id` = {$user['id']}"
    );
?>
<div class="content">
    <h2>Meine Kurse</h2>

    <div id="courses" class="courses">
      <?php foreach ($courses as $started_courses) : ?>
        <div class="container">
            <img src="<?= e($started_courses['img'])?>" alt="<?= e($started_courses['img-alt'])?>">
            <section>
                <h3><?= e($started_courses['name'])?></h3>
                <p><?= e($started_courses['description'])?></p>
                <?php $url = BASE_URL. 'pages/courses/lektion.php?' . http_build_query([
                        'course-id' => $started_courses['id'],
                        'lecture-number' => 1
                    ]); ?>
                <form action="<?= $url ?>" method="POST">
                <button type="submit" name="action" value="course-start" class="courses-button">Kurs fortsetzen</button>
                <input type="hidden" name="course-id" value="<?= e($started_courses['id']) ?>">
                </form>
                <p class="hidden level"><?= e($started_courses['level'])?></p>
            </section>
        </div>
      <?php endforeach; ?>
      </div>
    </div>


</div>