<?php
declare(strict_types=1);
require '../parts/bootstrap.php';

$page_title = 'Mein Profil';
$active = 'user-profile';

$js_include_list = [
  'jquery/validate/jquery.validate.min.js',
  'jquery/validate/additional-methods.min.js',
  'jquery/validate/localization/messages_de.min.js',
  'form-validation.js'];

include PATH. 'parts/head.php';

if (!auth_user()) {
  redirect(BASE_URL.'auth/login.php');
}

$user_id = auth_id();
$user_pdo = $database->prepare('SELECT * FROM `users` WHERE `id` = ?');
$user_pdo->execute([$user_id]);
$user = $user_pdo->fetch();

//$user = db_raw_first("SELECT * FROM `users` WHERE `id` =" . auth_id());

$order = query('order') ?? '';

?>
<header>
        <div class="hero_text">
        <h1>User-Profil</h1>
        </div>
</header> 

<main class="user">

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="sidebar-box">
    <img src="../medien/profile/profilbild.png" alt="Profilbild">
    <h2><?= $user['name'] . ' ' . $user['lastname'] ?></h2>
    
    <!-- This sees the User -->
    <?php if ($user['status'] === 'user'): ?>
      <ul>
          <li><a href="?order=my-courses">Meine Kurse</a></li>
          <li><a href="?order=edit-profile">Profil bearbeiten</a></li>
          <li><a href="?order=homeworks">Meine Hausaufgaben</a></li>
      </ul>
    <!-- This sees the Theacher -->
    <?php else: ?>
      <ul>
          <li><a href="?order=edit-profile">Profil bearbeiten</a></li>
          <li><a href="?order=admin-courses">Kurse verwalten</a></li>
          <li><a href="?order=admin-homeworks">Hausaufgaben verwalten</a></li>
      </ul>
    <?php endif; ?>
    </div>
  </div>

  <!-- Content for User -->

<?php 
  
  if ($user['status'] === 'user'){
    if($order === 'homeworks'){
      include PATH. 'parts/homeworks.php';
    } elseif($order === 'edit-profile'){
      include PATH. 'parts/edit-profile.php';
      } else {
        include PATH. 'parts/user-courses.php';
      } 
  }

  if ($user['status'] === 'teacher'){
    if($order === 'admin-homeworks'){
      include PATH. 'parts/admin-homeworks.php';
    } elseif($order === 'edit-profile'){
      include PATH. 'parts/edit-profile.php';
      } else {
        include PATH. 'parts/admin-courses.php';
      } 
  }

?>

</main>

<?php 
include PATH. 'parts/footer.php';