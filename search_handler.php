<?php
include 'components/connect.php';
// Check if the form was submitted with a search term.
if (isset($_POST['search_box'])) {
    $searchTerm = $_POST['search_box'];  ////// same thing as on search_page but pressing enter resets page without this code on search_page.php. /// fixed 
    $searchTerm = filter_var($searchTerm, FILTER_SANITIZE_STRING);     // Sanitize the search term to prevent SQL injection.

        // Prepare a SQL query to select products with names containing the search term.
    $select_products = $connect->prepare("SELECT * FROM `products` WHERE name LIKE :searchTerm");
        // Bind the sanitized search term to the prepared statement.
    $select_products->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $select_products->execute();

        // Check if there are products matching the search term.
    if ($select_products->rowCount() > 0) {
        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                <input type="hidden" name="image" value="<?= $fetch_products['image_01']; ?>">
                
                <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                
                <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" alt="" class="image">
                
                <div class="name"><?= $fetch_products['name']; ?></div>
                
                <div class="flex">
                    <div class="price"><span>Tk </span><?= $fetch_products['price']; ?><span>/-</span></div>
                    <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                </div>
                
                <input type="submit" value="add to cart" class="btn" name="add_to_cart" class="btn">
            </form>
            <?php
        }
    } else {
        echo '<p class="empty">No Products Found</p>';
    }
}
?>
