<?php 
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

include 'components/wishlist_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    
    <!--- Font Awesome Plug-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!--- CSS Link-->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<script> /// used to turn off form submission with restart page
     if ( window.history.replaceState ) {
     window.history.replaceState( null, null, window.location.href );
     }
    </script>
   
<?php 
  include 'components/user_header.php';
?>

<!--- Search form starts-->
<section class="search-form">
    <form action="" method="post">
        <input type="text" class="box" maxlength="100" placeholder="Search" required name="search_box" id="search_box">
        <button type="submit" class="box" id="search_btn"> <!-- Use the "box" class for styling -->
            <i class="fas fa-search"></i>
        </button>
    </form>
</section>
<!--- Search form Ends-->

<!---- form processing logic and database query--->
<section class="products" style="padding-top: 0; min-height: 100vh;">
    <div class="box-container">
    <!-- Results will be displayed here -->
    </div>
</section>

<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
<!-- Include the AJAX functionality script -->
<script src="js/search_ajax.js"></script>
</body>
</html>
