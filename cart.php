<?php 
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location:user_login.php'); 
    ///// page loads when user id is set aka logged in or stays in home page

}

if(isset($_POST['delete'])){
    $cart_id = $_POST['cart_id'];
    $delete_cart = $connect->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart->execute([$cart_id]);
    $message[] = 'Deleted from Cart';

}

if(isset($_GET['delete_all'])){
    $delete_all = $_POST['delete_all'];
    $delete_all_cart = $connect->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_all_cart->execute([$user_id]);
    header('location:cart.php');
   // $message[] = 'Emptied Cart';
}

if(isset($_POST['update_qty'])){
     $cart_id = $_POST['cart_id'];
     $qty = $_POST['qty'];
     $update_qty = $connect->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?" );
     $update_qty->execute([$qty,$cart_id]); 
     $message[] = 'Quantity Updated';   
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>
<body>
    <!--- Font Awesome Plug-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!--- CSS Link-->
    <link rel="stylesheet" href="css/style.css">

<?php 
  include 'components/user_header.php';
?>

<!-------- Cart section starts------>
<section class="products">

    <h1 class="heading">Cart</h1>

    <div class="box-container">

        <?php
        $total_price = 0;

        $select_cart = $connect->prepare("SELECT * FROM  `cart` WHERE 
        user_id =?");
        $select_cart->execute([$user_id]);

        if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC))
            {
                 //// use echo for demo price 
               
        ?>
         
        <form action="" method="post" class="box">

             <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">

            <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>"
            class="fas fa-eye"></a>
 
            <!-- Product Image -->
            <img class="image" src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="product_img">

         <div class="name"><?= $fetch_cart['name'];?></div>
         <div class="flex">
             <div class="price">Tk <span><?= $fetch_cart['price'];?></span>/-</div>

             <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity'];?>"
              onkeypress="if(this.value.length == 2) return false;">
             <button type="submit" class="fas fa-edit" name="update_qty"></button>
         </div>

         <div class="sub-total">Sub-Total: <span>Tk <?= $sub_total= ( $fetch_cart['price']
          * $fetch_cart['quantity']); ?>/-</span></div>

         <input type="submit" value="Delete Item" 
         onclick="return confirm('Delete This Item From Cart?');"
         name="delete" class="delete-btn">

        </form>

        <?php
           $total_price += $sub_total;
          }
            }else{
            
             echo '<p class="empty">Cart is Empty</p>';   
            }
        ?>
    </div>

    <div class="grand-total">
        <p>Total Price: <span>Tk <?= $total_price; ?>/-</span></p>
        <a href="shop.php" class="option-btn">Continue Shopping</a>
        <a href="cart.php?delete_all" class="delete-btn <?= ($total_price > 1)?'':'disabled'; ?>"
        onclick="return confirm('Clear everything from Cart?');">Clear Cart</a>
        <a href="checkout.php" class="btn <?= ($total_price > 1)?'':'disabled'; ?>">Proceed to Checkout</a>
    </div>

</section>


<!-------- Cart section ends------>















<?php include 'components/footer.php'; ?>

   <!----- JS Link -->
   <script src="js/script.js"></script> 


</body>
</html>