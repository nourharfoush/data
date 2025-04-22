<?php
require_once 'config.php';

// تدمير جلسة المستخدم
session_destroy();

// إعادة التوجيه إلى صفحة تسجيل الدخول
header('Location: admin_login.php');
exit;
?> 