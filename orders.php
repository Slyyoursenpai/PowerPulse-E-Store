<?php 
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';

    header('location:home.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
</head>
<body>
    <!--- Font Awesome Plug-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!--- CSS Link-->
    <link rel="stylesheet" href="css/style.css">

<?php 
  include 'components/user_header.php';
?>

 <!--- order section starts--->

 <section class="show-orders">

        <h1 class="heading">Your Orders</h1>

        <div class="box-container">

        <?php
                $show_orders = $connect -> prepare("SELECT * FROM `orders` WHERE user_id = ?");
                $show_orders->execute([$user_id]);

                if($show_orders->rowCount()>0){
                 while($fetch_orders = $show_orders->fetch(PDO::FETCH_ASSOC)){
               
        ?>

        <div class="box">
          <p> User ID: <span><?= $fetch_orders['user_id'];?></span> </p>
          <p> Name: <span><?= $fetch_orders['name'];?></span> </p>
          <p> Number: <span><?= $fetch_orders['number'];?></span> </p>
          <p> E-mail: <span><?= $fetch_orders['email'];?></span> </p>
          <p> Address: <span><?= $fetch_orders['address'];?></span> </p>
          <p> Your Orders: <span><?= $fetch_orders['total_products']; ?></span> </p>
          <p> Total Price: <span><?= $fetch_orders['total_price']; ?></span> </p>
          <p> Payment Method: <span><?= $fetch_orders['method']; ?></span> </p>
          <p> Payment Status: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){
            echo 'red';
          } else {
            echo 'green';
          } ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
 
        </div>

        <?php
            }
                }else{
                  echo '<p class="empty">No Orders Placed</p>';
                }
        
        ?>

        </div>

 </section>

 <!--- order section Ends--->


<?php include 'components/footer.php'; ?>

   <!----- JS Link -->
   <script src="js/script.js"></script> 


</body>
</html>