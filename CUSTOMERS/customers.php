<?php
if (!$conn =  mysqli_connect("localhost", "root", "", "bank")) {
  die("the connection failed");
}
$query = "select * from customers";
$result = mysqli_query($conn, $query);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $email_1 = $_POST['email1'];
  $email_2 = $_POST['email2'];
  $mony = $_POST['pala'];
  $sql0 = "SELECT `balance` FROM `customers` WHERE `customers` . `email` = '$email_1'";
  $do0 = mysqli_query($conn, $sql0);
  $vu = mysqli_fetch_assoc($do0);
  if ($vu['balance'] < $mony) {
    echo " <script type='text/javascript'>alert('Error: You dont have enough money')</script>";
  } else {
    $sql = "UPDATE `customers` SET `balance` = balance - $mony WHERE `customers` . `email` = '$email_1'";
    $do = mysqli_query($conn, $sql);
    $sql1 = "UPDATE `customers` SET `balance` = balance + $mony WHERE `customers` . `email` = '$email_2'";
    $do1 = mysqli_query($conn, $sql1);
    mysqli_close($conn);
    header('Location: ./customers.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link href="CSS/icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="CSS/c_style.css" />
  <title>CUSTOMERS</title>
</head>

<body>
  <!-- ----------------------------------------- -->
  <div class="overlay">
    <div class="login">
      <div class="header">
        <h1>money</h1>
        <i class="fas fa-times" onclick="toggleLogin()"></i>
      </div>
      <div class="body">
        <form action="./customers.php" class="form" method="post">
          <p>from: </p>
          <input type="email" placeholder="E-mail" name="email1" />
          <p>to: </p>
          <input type="email" placeholder="E-mail" name="email2" />
          <p>palance: </p>
          <input type="text" placeholder="palace" name="pala" />
          <div class="footer">
            <button type="submit">Submit<?php header("./customers.php"); ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ----------------------------------------- -->
  <nav>
    <div class="logo">
      <div class="balls">
        <div class="one"></div>
        <div class="two"></div>
        <div class="three"></div>
      </div>
      <a class="nav-bar" href="./index.html">The Basic Bank</a>
    </div>
    <div class="HC">
      <ul class="ul-HC">
        <li>
          <a class="nav-link" href="./index.html">HOME</a>
        </li>
        <li>
          <a class="nav-link" href="./index.html">ABOUT US</a>
        </li>
        <li>
          <a class="nav-link" href="./index.html">CONTACT US</a>
        </li>
        <li>
          <a class="nav-link" href="CUSTOMERS/customers.html">CUSTOMERS</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- ----------------------------------------- -->
  <div class="btns">
    <div class="botm">
      <button class="btn" onclick="toggleLogin()">TRANSFER MONY</button>
    </div>
    <div class="seetra">
      <button class="seebtn" onclick="toggleLogi1()">SEE TRANSFERS</button>
    </div>
  </div>
  <!-- ----------------------------------------- -->
  <div class="thetable">
    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Email</th>
          <th>Balance</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($rows = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?php echo $rows['id']; ?></td>
            <td><?php echo $rows['name']; ?></td>
            <td><?php echo $rows['email']; ?></td>
            <td><?php echo $rows['balance'] . "$"; ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  <!-- ----------------------------------------- -->
</body>
<script>
  function toggleLogin() {
    document.querySelector(".overlay").classList.toggle("open");
  }
  function toggleLogin1() {
    document.querySelector(".active").classList.toggle("open");
  }
</script>

</html>