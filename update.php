<?php
// استدعاء ملف الاتصال بقاعدة البيانات
include('db_connect.php');

// التحقق من إرسال النموذج
if(isset($_POST['updateid'])) {
    // جلب البيانات المدخلة من النموذج
    $id_exp = $_POST['id_exp'];
    $id_category = $_POST['id_category'];
    $id = $_POST['id'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $payment = $_POST['payment'];
    $comment = $_POST['comment'];

    // تحديث بيانات جدول expenses
    $query = "UPDATE expenses SET id_category='$id_category', id='$id', price='$price', date='$date', payment='$payment', comment='$comment' WHERE id_exp='$id_exp'";
    $result = mysqli_query($connection, $query);

    // التحقق من نتيجة التحديث وإظهار رسالة تأكيد
    if($result) {
        echo "تم تحديث البيانات بنجاح";
    } else {
        echo "حدث خطأ أثناء تحديث البيانات";
    }
}
?>