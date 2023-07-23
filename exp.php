<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-U-compatible" content="IE=edge">
   <meta name="viewport"content="width=device-width ,initial-scale=1.0">
   <link rel="stylesheet" href="Add_exp.css">
   <link rel='stylesheet' href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    <title>Expense Tracker</title>
</head> 
<body>

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
               <li><a href="signup.php">Sign Up</a></li>  |
            <li><a href="login.php">Log In</a></li>  |                                         
            <li><a href="category.php">categories</a></li>   |
            <li><a href="exp.php">expenses</a></li>     |
            <li><a href="logout.php">Log Out</a></li>
         </ul>      
       </nav>
     </div>
   
    <a href="Add_exp.php" class="btn border-secondary">ADD Expenses</a>
        <table class="table">
       <thead>
           <tr>
                <th scope="col">.N</th>
              <th scope="col">Price</th>
              <th scope="col">Date</th>
               <th scope="col">Comment</th>
               <th scope="col">Payment</th>
               <th scope="col">Category Name</th>
               <th scope="col">Category Type</th>
               <th scope="col">Category Amount</th>
               <th scope="col" >Action</th>
          </tr>
      </thead>
      <tbody>
         <?php 

// اتصال بقاعدة البيانات
$conn = new mysqli('localhost', 'root', '', 'expensetrecker');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// استعلام SELECT
$sql = "SELECT expenses.id_exp, expenses.price, expenses.date, expenses.comment, expenses.payment, category.name_category, category.type, category.amount, users.username
        FROM expenses
        INNER JOIN category ON expenses.id_category = category.id_category
        INNER JOIN users ON expenses.id = users.id";

$result = $conn->query($sql);

// فحص وجود البيانات
if ($result->num_rows > 0) {
  // عرض البيانات في جدول HTML
  while ($row = $result->fetch_assoc()) {
           $id_exp=$row["id_exp"];
           $price=$row["price"];
           $date=$row["date"];
           $comment=$row["comment"];
           $payment=$row["payment"];
           $name_category=$row["name_category"];
           $type=$row["type"]; 
           $amount=$row["amount"];
            echo '<tr>
           <td>'.$id_exp.'</td>
           <td>'.$price.'</td>
          <td>'.$date.'</td>
       <td>'.$comment.'</td>
       <td>'.$payment.'</td>
       <td>'.$name_category.'</td>
       <td>'.$type.'</td>
       <td>'.$amount.'</td>
       <td >
      <a href="Add_exp.php?updateid='.$id_exp.'"class="btn border-danger">update</a>
       
      <a href="delete.php?deleteid='.$id_exp.'"class="btn border-danger">Delete</a>
       </td>
       </tr>';
       }
       
       
       } else {
  echo "No results found.";
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>