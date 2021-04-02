<?php 
$lectures_list = db_raw_select("SELECT `lecture-number` FROM `lectures` WHERE `course-id` = $course_id");
?>
<nav>
    <ul>
        <?php foreach ($lectures_list as $lectures) : ?>
            <?php $url = BASE_URL. 'pages/courses/lektion.php?' . http_build_query([
                    'course-id' => $course_id,
                    'lecture-number' => $lectures['lecture-number']
                ]); 
            ?>
        <li><a href="<?= $url ?>">Lektion <?= $lectures['lecture-number'] ?></a></li>
        <?php endforeach;?>
    </ul>
</nav>