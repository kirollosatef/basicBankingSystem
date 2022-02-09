<?php
if (!$conn =  mysqli_connect("localhost", "root", "", "bank")) {
  die("the connection failed");
}
$query = "select * from customers";
$result = mysqli_query($conn, $query);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if ($email_1 = $_POST['email1'] && $email_1 != 0 &&
    $email_2 = $_POST['email2'] && $email_2 != 0 &&
    $mony = $_POST['pala'] && $mony != 0
  ) {
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
      $ins = "INSERT INTO `transfers` (`id`, `from`, `to`, `balance`) VALUES (NULL, '$email_1', '$email_2', '$mony');";
      $doins = mysqli_query($conn, $ins);
    }
  } elseif ($memname = $_POST["memnamee"] && $memname != 0 &&
    $mememail = $_POST["mememail"] && $mememail != 0 &&
    $mempala = $_POST["mempala"] && $mempala != 0
  ) {
    $addmeem = "INSERT INTO `customers` (`id`, `name`, `email`, `balance`) VALUES (NULL, '$memname', '$mememail', '$mempala');";
    $doaddmeem = mysqli_query($conn, $addmeem);
  }
  mysqli_close($conn);
  header('Location: ./customers.php');
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
        <h1>transfer</h1>
        <i class="fas fa-times" onclick="toggleLogin()">✖</i>
      </div>
      <div class="body">
        <form action="./customers.php" class="form" method="post">
          <div class="p-in">
            <p>from: </p>
            <input type="email" placeholder="E-mail" name="email1" />
          </div>
          <div class="p-in">
            <p>to: </p>
            <input type="email" placeholder="E-mail" name="email2" />
          </div>
          <div class="p-in">
            <p>palance: </p>
            <input type="text" placeholder="palace" name="pala" />
          </div>
          <div class="footer">
            <button type="submit">Submit<?php header("./customers.php"); ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ----------------------------------------- -->
  <div class="addmempop">
    <div class="login">
      <div class="header">
        <h1>ADD</h1>
        <i class="fas fa-times" onclick="toggadd()">✖</i>
      </div>
      <div class="body">
        <form action="./customers.php" class="form" method="post">
          <div class="p-in">
            <p>name: </p>
            <input type="text" placeholder="name" name="memnamee" />
          </div>
          <div class="p-in">
            <p>Email: </p>
            <input type="email" placeholder="E-mail" name="mememail" />
          </div>
          <div class="p-in">
            <p>palance: </p>
            <input type="text" placeholder="palace" name="mempala" />
          </div>
          <div class="footer">
            <button type="submit">Submit<?php header("./customers.php"); ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- ----------------------------------------- -->
  <div class="active">
    <div class="see">
      <div class="hed">
        <i class="fas fa-times" onclick="togglesee()">✖</i>
        <h1>TRANSFERS</h1>
      </div>
      <?php
      $transfers = "select * FROM transfers";
      $doitpls = mysqli_query($conn, $transfers);
      while ($tan = mysqli_fetch_assoc($doitpls)) {
      ?>
        <ul>
          <?php
          echo "<li>" . $tan['from'] . " send to " . $tan['to'] . "<span> => " . $tan['balance'] . "$</span>" . "</li>";
          ?>
        </ul>
      <?php
      }
      ?>
    </div>
  </div>
  <!-- ----------------------------------------- -->
  <nav>
    <div class=" logo">
      <div class="balls">
        <div class="one"></div>
        <div class="two"></div>
        <div class="three"></div>
      </div>
      <a class="nav-bar" href="../index.html">The Basic Bank</a>
    </div>
    <div class="HC">
      <ul class="ul-HC">
        <li>
          <a class="nav-link" href="../index.html">HOME</a>
        </li>
        <li>
          <a class="nav-link" href="../index.html">ABOUT US</a>
        </li>
        <li>
          <a class="nav-link" href="../index.html">CONTACT US</a>
        </li>
        <li>
          <a class="nav-link" href="./customers.html">CUSTOMERS</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- ----------------------------------------- -->
  <div class="h1-mark">
    <h1 class="title">B A N K I N G</h1>
    <div class="mark"></div>
  </div>
  <!-- ----------------------------------------- -->
  <div class="btns">
    <div class="addmem">
      <button class="addmembtn" onclick="toggadd()">ADD MEMBER</button>
    </div>
    <div class="botm">
      <button class="btn" onclick="toggleLogin()">TRANSFER MONY</button>
    </div>
    <div class="seetra">
      <button class="seebtn" onclick="togglesee()">SEE TRANSFERS</button>
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
      <tfoot>
        <tr>
          <td colspan="3" class="total">TOTAL</td>
          <td><?php
              $fn = "SELECT balance FROM customers";
              $dofn = mysqli_query($conn, $fn);
              $total = 0;
              while ($n1 = mysqli_fetch_assoc($dofn)) {
                $total += $n1['balance'];
              }
              echo $total;
              ?>$</td>
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- ----------------------------------------- -->
</body>
<script>
  function toggleLogin() {
    document.querySelector(".overlay").classList.toggle("open");
  }

  function togglesee() {
    document.querySelector(".active").classList.toggle("whatsee");
  }

  function toggadd() {
    document.querySelector(".addmempop").classList.toggle("add");
  }
</script>

</html>