<?php
// تحقق من طريقة الطلب
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // استقبل البيانات المدخلة من المستخدم
  $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
  $payment = filter_input(INPUT_POST, 'payment', FILTER_SANITIZE_NUMBER_INT);
  $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
  $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

  // التحقق من صحة البيانات المدخلة
  if ($category && $payment && $price && $date && $comment) {
    // الاتصال بقاعدة البيانات
    $conn = new mysqli('localhost', 'root', '', 'expensetrecker');
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // احضار رقم المستخدم الذي قام بتسجيل الدخول
    session_start();
    $id = $_SESSION['id'];

    // إدراج البيانات في جدول expenses
    $query = "INSERT INTO expenses (id_category, id, price, Date, payment, comment) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iissss', $category, $id, $price, $date, $payment, $comment);
    if ($stmt->execute()) {
      header('Location: exp.php'); 
     
    } else {
      echo "Error while adding expense: " . $conn->error;
    }
    $stmt->close();

    $conn->close();
  } else {
    echo "Invalid input";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="Add_exp.css">
  <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel='stylesheet'>
  <title>Add Expense</title>
</head>
<body>
<div class="container my-5">
<div class="container">
    <div class ="topbar">
       <img id="logo" src="img/Finance app-amico.png" alt="logo" style="vertical-align:middle;">
       <nav>
          <h1 class ="logo">Tracking Expenses</h1>
          <ul> 
            <?php
          session_start(); 
        if(isset($_SESSION['id'])&& isset($_SESSION['Username'])){?> 
           <font color="white"> <h2>&emsp;&emsp;  Username: <?php echo $_SESSION['Username']; ?></h2></font> 
            <?php } else{header("Location:hombage.php");  
             exit();  }
              ?> 
              <li><a href="http://localhost/as5/signup.php">Sign Up</a></li>  |
            <li><a href="http://localhost/as5/login.php">Log In</a></li>  |                                         
            <li><a href="category.php">categories</a></li>   |
            <li><a href="http://localhost/as5/exp.php">expenses</a></li>     |
            <li><a href="logout.php">Log Out</a></li>
         </ul>      
       </nav>
     </div>
  <form method="post">
   <div class="form-group">
    <label>Category:</label>
    <select name="category" class="form-control">
      <?php
        // الاتصال بقاعدة البيانات
        $conn = new mysqli('localhost', 'root', '', 'expensetrecker');
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // احضار رقم المستخدم الذي قام بتسجيل الدخول
        session_start();
        $id = $_SESSION['id'];

        // استعلام لاحضار الفئات المرتبطة بالمستخدم الحالي
        $query = "SELECT id_category, name_category FROM category WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // عرض الفئات في النموذج
        while ($row = $result->fetch_assoc()) {
          echo "<option value=\"" . $row['id_category'] . "\">" . $row['name_category'] . "</option>";
        }

        $stmt->close();
        $conn->close();
      ?>
    </select><br>
      </div>
      <div class="form-group">
    <label>Payment:</label>
    <select name="payment" class="form-control">
      <option value="1">Check</option>
      <option value="2">Card</option>
      <option value="3">Cash</option>
    </select><br>
      </div>
      <div class="form-group">
    <label>Price:</label>
    <input type="number" class="form-control" name="price"><br>
      </div>
      <div class="form-group">
    <label>Date:</label>
    <input type="date" class="form-control" name="date"><br>
      </div>
      <div class="form-group">
    <label>Comment:</label>
    <input type="text"class="form-control" name="comment"><br>
      </div>
       <button type="submit" class="btn border-secondary" name="submit"> ADD </button>
  </form>
      </div>
</body>
</html>