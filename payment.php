<?php
include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:user_login.php');
}

if (isset($_POST['order'])) {
    // Your existing code for collecting order details goes here.

    

    // HTML for the payment form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">    
    </head>
    <body>
        <h1>Payment Information</h1>
        <form id="payment-form">
            <h2 class="heading">$125</h2>

            <div class="flex">
                <!-- Add input fields for card number, expiration date, and CVV -->
                <div class="inputBox">
                    <span>Card Number:</span>
                    <input id="card-number" type="text" placeholder="Enter card number" class="box" required>
                </div>
                <div class="inputBox">
                    <span>Expiration Month:</span>
                    <input id="exp-month" type="text" placeholder="MM" class="box" required>
                </div>
                <div class="inputBox">
                    <span>Expiration Year:</span>
                    <input id="exp-year" type="text" placeholder="YYYY" class="box" required>
                </div>
                <div class="inputBox">
                    <span>CVV:</span>
                    <input id="cvc" type="text" placeholder="CVV" class="box" required>
                </div>
            </div>

            <input type="submit" name="process_payment" class="btn" value="Pay Now">
        </form>

        <script src="https://js.stripe.com/v3/"></script>
        <script>
            var stripe = Stripe('YOUR_PUBLISHABLE_KEY'); // Replace with your own publishable key
            var elements = stripe.elements();

            var card = elements.create('card');
            card.mount('#card-number');

            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                stripe.createToken(card).then(function (result) {
                    if (result.error) {
                        // Handle errors (e.g., display an error message)
                        console.error(result.error.message);
                    } else {
                        // Send the token to your server for processing
                        fetch('charge.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                token: result.token.id,
                                // Include other order details here if needed
                            }),
                        })
                            .then(function (response) {
                                return response.json();
                            })
                            .then(function (data) {
                                if (data.status === 'success') {
                                    // Payment successful, handle the success
                                    alert('Payment Successful');
                                } else {
                                    // Payment failed, handle the error
                                    alert('Payment Failed: ' + data.message);
                                }
                            });
                    }
                });
            });
        </script>
    </body>
    </html>
    <?php
    
}


?>