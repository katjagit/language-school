<?php

require '../parts/bootstrap.php';

$page_title = 'Kurse';
$active = 'courses';

$js_include_list = ['courses.js'];

include PATH. 'parts/head.php';

$courses = $db->query('SELECT * FROM `courses` ORDER BY `id`');
?>

<header>
        <div class="hero_text">
        <h1>Online-Kurse</h1>
        <h2>Übersicht aller aktuellen Kurse</h2>
        </div>
</header> 
<main class="courses-width">
    <h2 id="h2-courses">Aktuelle Kurse</h2>
    <button id="button-a" class="sort-button">Anfäger</button>
    <button id="button-f" class="sort-button">Fortgeschrittene</button>
    <button id="button-all" class="sort-button">Alle</button>
    <div id="courses" class="courses">
    <?php foreach ($courses as $course) :?>
        <div class="container">
            <img src="<?= $course['img'] ?>" alt="<?= $course['img-alt'] ?>">
            <section>
                <h3><?= $course['name'] ?></h3>
                <p><?= $course['description'] ?></p>
                <?php $url = BASE_URL. 'pages/courses/lektion.php?' . http_build_query([
                        'course-id' => $course['id'],
                        'lecture-number' => 1
                    ]); ?>
                <form action="<?= $url ?>" method="POST">
                <button type="submit" name="action" value="course-start" class="courses-button">starten</button>
                <input type="hidden" name="course-id" value="<?= e($course['id']) ?>">
                </form>
                <p class="hidden level"><?= $course['level'] ?></p>
            </section>
        </div>
    <?php endforeach; ?>
    </div>
</main>

<?php 
include PATH. 'parts/footer.php';