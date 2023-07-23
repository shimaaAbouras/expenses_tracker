<?php
// معلومات الاتصال بقاعدة البيانات
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'expensetrecker';

// إنشاء اتصال بقاعدة البيانات
$connection = mysqli_connect($host, $username, $password, $database);

// التحقق من صحة الاتصال
if(!$connection) {
    die("فشل الاتصال: " . mysqli_connect_error());
}
?>