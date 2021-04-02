<?php
$courses = db_raw_select("SELECT * from `courses`");
$action = request('action') ?? '';

if (request_is('post')) {
    if ($action === 'create') {
        $name = e(trim(request('name')) ?? '');
        $description = e(trim(request('description')) ?? '');
        $topics = e(trim(request('topics')) ?? 0);
        $homeworks = e(trim(request('homeworks')) ?? 0);
        $tests = e(trim(request('tests')) ?? 0);

        // insert the defalut picture
        $img = '../medien/courses/bild1.jpg';
        $img_alt = 'Schreibtisch';

        if ($name === '') {
            $errors['empty-name'] = 'Bitte ausfüllen';
        }

        if ($description === '') {
            $errors['empty-description'] = 'Bitte ausfüllen';
        }

        if ($topics === '') {
            $errors['empty-topics'] = 'Bitte ausfüllen';
        } else {
            if (!is_numeric($topics)) {
                $errors['numeric-topics'] = 'Bitte nur Zahlen eintragen';
            }
        }

        if ($homeworks === '') {
            $errors['empty-homeworks'] = 'Bitte ausfüllen';
        } else {
            if (!is_numeric($homeworks)) {
                $errors['numeric-homeworks'] = 'Bitte nur Zahlen eintragen';
            }
        }

        if ($tests === '') {
            $errors['empty-tests'] = 'Bitte ausfüllen';
        } else {
            if (!is_numeric($tests)) {
                $errors['numeric-tests'] = 'Bitte nur Zahlen eintragen';
            }
        }

        if(!$errors) {
            $feedback = 'Der Kurs wurde angelegt';
            
            db_insert('courses', [
                'name' => $name,
                'description' => $description,
                'topics' => (int) $topics,
                'homeworks' => (int) $homeworks,
                'tests' => (int) $tests,
                'img' => $img,
                'img-tag' => $img_alt,
                'teacher-id' => auth_id()
            ]);

            // clean the form:
            $name = $description = $topics = $homeworks = $tests = $img = '';

        }
    }

    if ($action === 'delete') {
        $course_id = request('course-id') ?? 0;
        db_delete('course', $course_id);
        redirect(BASE_URL . 'pages/user-profile.php');
    }

    if ($action === 'edit') {
        $course_id = (int) request('course-id') ?? 0;
        $this_course = db_raw_first("SELECT * FROM `courses` WHERE `id` = $course_id");

    }

    if ($action === 'update') {

        $course_id = (int) request('course-id') ?? 0;
   

        $name = e(trim(request('name')) ?? '');
        $description = e(trim(request('description')) ?? '');
        $topics = e(trim(request('topics')) ?? 0);
        $homeworks = e(trim(request('homeworks')) ?? 0);
        $tests = e(trim(request('tests')) ?? 0);

        if ($name === '') {
            $errors['empty-name'] = 'Bitte ausfüllen';
        }

        if ($description === '') {
            $errors['empty-description'] = 'Bitte ausfüllen';
        }

        if ($topics === '') {
            $errors['empty-topics'] = 'Bitte ausfüllen';
        } else {
            if (!is_numeric($topics)) {
                $errors['numeric-topics'] = 'Bitte nur Zahlen eintragen';
            }
        }

        if ($homeworks === '') {
            $errors['empty-homeworks'] = 'Bitte ausfüllen';
        } else {
            if (!is_numeric($homeworks)) {
                $errors['numeric-homeworks'] = 'Bitte nur Zahlen eintragen';
            }
        }

        if ($tests === '') {
            $errors['empty-tests'] = 'Bitte ausfüllen';
        } else {
            if (!is_numeric($tests)) {
                $errors['numeric-tests'] = 'Bitte nur Zahlen eintragen';
            }
        }

        if(!$errors) {
            $feedback = 'Die Daten wurden aktualisiert';
            
            db_update('courses', $course_id, [
                'name' => $name,
                'description' => $description,
                'topics' => (int) $topics,
                'homeworks' => (int) $homeworks,
                'tests' => (int) $tests
            ]);

            $this_course = db_raw_first("SELECT * FROM `courses` WHERE `id` = $course_id");
            
        }

    }
}
    


?>

<div class="content">

    <?php if (($action === 'create-new' || $action === 'create') && request_is('post')) : ?>
        
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <h2>Neuer Kurs</h2>
        <?php if (isset($feedback)) : ?>
        <div class="feedback" id="feedback">
            <?= e($feedback) ?? '' ?>
        </div>
        <?php endif; ?>
        <div>
            <?= error_for($errors, 'empty-name') ?>
            <label for="name" class="inline-block">Kurstitel:</label>
            <input type="text" class="width65 inline-block" name="name" id="name" value="<?= $name ?? '' ?>" required>
        </div>
        
        <div>
            <?= error_for($errors, 'empty-description') ?>
            <label for="description" class="inline-block">Beschreibung:</label>
            <input type="text" class="width65 inline-block" id="description" name="description" value="<?= $description ?? '' ?>" required>
        </div>
        

        <div>
            <?= error_for($errors, 'empty-topics') ?>
            <?= error_for($errors, 'numeric-topics') ?>
            <label for="topics" class="inline-block">Zahl der Lektionen:</label>
            <input type="number" class="width65 inline-block" name="topics" id="topics" value="<?= $topics ?? '' ?>" required>
        </div>

        <div>
            <?= error_for($errors, 'empty-homeworks') ?>
            <?= error_for($errors, 'numeric-homeworks') ?>
            <label for="homeworks" class="inline-block">Zahl der Hausaufgaben:</label>
            <input type="number" class="width65 inline-block" name="homeworks" id="homeworks" value="<?= $homeworks ?? '' ?>" required>
        </div>

        <div>
            <?= error_for($errors, 'empty-tests') ?>
            <?= error_for($errors, 'numeric-tests') ?>
            <label for="tests" class="inline-block">Zahl der Tests:</label>
            <input type="number" class="width65 inline-block" name="tests" id="tests" value="<?= $tests ?? '' ?>" required>
        </div>

        <div>
            <label for="img" class="inline-block">Bild (optional)</label>
            <input type="file" class="width65 inline-block" name="img" id="tests" value="<?= $img ?? '' ?>">
        </div>

        <div> 
            <button type="submit" class="submit_button inline" name="action" value="create">Kurs anlegen</button>
            <button type="submit" class="submit_button inline" name="action" value="cancel">abbrechen</button>
            
        </div>

        </form>
    
    <?php elseif (($action === 'edit' || $action === 'update') && request_is('post')) : ?>

        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" id="edit-course">
        <h2>Kurs bearbeiten</h2>
        <?php if (isset($feedback)) : ?>
        <div class="feedback" id="feedback">
            <?= e($feedback) ?? '' ?>
        </div>
        <?php endif; ?>
        <div>
            <?= error_for($errors, 'empty-name') ?>
            <label for="name" class="inline-block">Kurstitel:</label>
            <input type="text" class="width65 inline-block" name="name" id="name" value="<?= $this_course['name'] ?? '' ?>" required>
        </div>
        
        <div>
            <?= error_for($errors, 'empty-description') ?>
            <label for="description" class="inline-block">Beschreibung:</label>
            <input type="text" class="width65 inline-block" id="description" name="description" value="<?= $this_course['description'] ?? '' ?>" required>
        </div>
        

        <div>
            <?= error_for($errors, 'empty-topics') ?>
            <?= error_for($errors, 'numeric-topics') ?>
            <label for="topics" class="inline-block">Zahl der Lektionen:</label>
            <input type="number" class="width65 inline-block" name="topics" id="topics" value="<?= $this_course['topics'] ?? '' ?>" required>
        </div>

        <div>
            <?= error_for($errors, 'empty-homeworks') ?>
            <?= error_for($errors, 'numeric-homeworks') ?>
            <label for="homeworks" class="inline-block">Zahl der Hausaufgaben:</label>
            <input type="number" class="width65 inline-block" name="homeworks" id="homeworks" value="<?= $this_course['homeworks'] ?? '' ?>" required>
        </div>

        <div>
            <?= error_for($errors, 'empty-tests') ?>
            <?= error_for($errors, 'numeric-tests') ?>
            <label for="tests" class="inline-block">Zahl der Tests:</label>
            <input type="number" class="width65 inline-block" name="tests" id="tests" value="<?= $this_course['tests'] ?? '' ?>" required>
        </div>

        <div> 
            <button type="submit" class="submit_button inline" name="action" value="update">speichern</button>
            <input type="hidden" name="course-id" value="<?= e($this_course['id']) ?>">
            <button type="submit" class="submit_button inline" name="action" value="cancel">abbrechen</button>
            
        </div>

        </form>


    <?php else : ?>

        <h2>Kurse verwalten</h2>
        
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <button class="submit_button block" name="action" value="create-new" type="submit"> Neuen Kurs anlegen</button>
        </form>
        <div id="courses" class="courses">
        <?php foreach ($courses as $each_course) : ?>
            <div class="container">
                <img src="<?= e($each_course['img'])?>" alt="<?= e($each_course['img-tag'])?>">
                <section>
                    <h3><?= e($each_course['name'])?></h3>
                    <p><?= e($each_course['description'])?></p>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <button type="submit" class="edit-button" name="action" value="edit">bearbeiten</button>
                    <button type="submit" class="delete-button" name="action" value="delete">löschen</button>
                    <input type="hidden" name="course-id" value="<?= e($each_course['id']) ?>">
                    </form>
                </section>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>