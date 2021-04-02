<?php
declare(strict_types=1);
require '../parts/bootstrap.php';

include PATH. 'parts/head.php';

logout();
redirect(BASE_URL.'auth/login.php');
