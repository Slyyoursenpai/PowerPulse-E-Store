<?php 
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location:home.php');
 ///// page loads when user id is set aka logged in or stays in home page
}

include 'components/wishlist_cart.php';

if(isset($_POST['delete'])){
    $wishlist_id = $_POST['wishlist_id'];
    $delete_wishlist = $connect->prepare("DELETE FROM `wishlist` WHERE id = ?");
    $delete_wishlist->execute([$wishlist_id]);
    $message[] = 'Deleted from Wishlist';

}

if(isset($_GET['delete_all'])){
    $delete_all = $_POST['delete_all'];
    $delete_all_wishlist = $connect->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_all_wishlist->execute([$user_id]);
    header('location:wishlist.php');
   // $message[] = 'Emptied Wishlist';
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
</head>
<body>
    <!--- Font Awesome Plug-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!--- CSS Link-->
    <link rel="stylesheet" href="css/style.css">

<?php 
  include 'components/user_header.php';
?>

<!-------- wishlist section starts------>
<section class="products">

    <h1 class="heading">Wishlisted Products</h1>

    <div class="box-container">

        <?php
        $total_price = 0;

        $select_wishlist = $connect->prepare("SELECT * FROM  `wishlist` WHERE 
        user_id =?");
        $select_wishlist->execute([$user_id]);

        if($select_wishlist->rowCount() > 0){
            while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC))
            {
                 //// use echo for demo price 
               $total_price += $fetch_wishlist['price'];
        ?>
         
        <form action="" method="post" class="box">

             <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
             <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
             <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
             <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
             <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">


              
            <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>"
            class="fas fa-eye"></a>
 
            <!-- Product Image -->
            <img class="image" src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="product_img">

         <div class="name"><?= $fetch_wishlist['name'];?></div>
         <div class="flex">
             <div class="price">Tk <span><?= $fetch_wishlist['price'];?></span>/-</div>

             <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">

         </div>

         <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
         <input type="submit" value="Delete Item" 
         onclick="return confirm('Delete This Item From Wishlist?');"
         name="delete" class="delete-btn">

        </form>

        <?php
          }
            }else{
            
             echo '<p class="empty">Wishlist is Empty</p>';   
            }
        ?>
    </div>

    <div class="grand-total">
        <p>Total Price: <span>Tk <?= $total_price; ?>/-</span></p>

        <a href="shop.php" class="option-btn">Continue Shopping</a>
        <a href="wishlist.php?delete_all" class="delete-btn <?= ($total_price > 1)?'':'disabled'; ?>"
        onclick="return confirm('Clear everything from Wishlist?');">Clear Wishlist</a>
    </div>

</section>


<!-------- wishlist section ends------>


<?php include 'components/footer.php'; ?>

   <!----- JS Link -->
   <script src="js/script.js"></script> 


</body>
</html>