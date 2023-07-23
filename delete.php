
<?php
// استدعاء ملف الاتصال بقاعدة البيانات
include('db_connect.php');

// التحقق من إرسال النموذج
if(isset($_POST['submit'])) {
    // جلب البيانات المدخلة من النموذج
    $id_exp = $_POST['id_exp'];

    // حذف بيانات جدول expenses
    $query = "DELETE FROM expenses WHERE id_exp='$id_exp'";
    $result = mysqli_query($connection, $query);

    // التحقق من نتيجة الحذف وإظهار رسالة تأكيد
    if($result) {
        echo "تم حذف البيانات بنجاح";
    } else {
        echo "حدث خطأ أثناء حذف البيانات";
    }
}
?>