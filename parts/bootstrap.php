<?php
const PATH = '/Applications/MAMP/htdocs/language-school/';
const BASE_URL = 'http://localhost:8888/language-school/';

require_once PATH.'lib/authentication.php';
require_once PATH.'lib/database.php';
require_once PATH.'lib/request.php';
require_once PATH.'lib/response.php';
require_once PATH.'lib/session.php';
require_once PATH.'lib/view.php';
require_once PATH.'lib/classes/Db.class.php';

$db = new Db();

session_start();

$errors = [];


