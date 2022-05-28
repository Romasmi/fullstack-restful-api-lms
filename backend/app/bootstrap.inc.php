<?php

session_start();

require_once '../config/common.php';
require_once 'Database/Database.php';
require_once 'Database/Seeder/Seeder.php';
require_once 'Database/Seeder/UserSeeder.php';
require_once 'Database/Seeder/GroupSeeder.php';
require_once 'Database/Seeder/StudentSeeder.php';
require_once 'Model/User.php';
require_once 'Model/Group.php';
require_once 'Model/Student.php';
require_once 'Controller/Controller.php';
require_once 'Controller/UserController.php';
require_once 'Controller/StudentController.php';
require_once 'Middleware/CheckAuthMiddleware.php';