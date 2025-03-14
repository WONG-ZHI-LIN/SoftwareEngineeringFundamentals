<?php
 include 'page_login.php';
 require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Purchase</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #thank-you-page {
            text-align: center;
        }

        #thank-you-page h1 {
            color: #4CAF50; /* Green color for the heading */
        }

        #thank-you-page p {
            margin: 10px 0;
        }

        #thank-you-page a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50; /* Green color for the button */
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
    <!-- Link to your icon library or add inline SVG -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
    <div id="thank-you-page">
        <i class="fas fa-check-circle fa-5x" style="color: #4CAF50;"></i>
        <h1>Thank You for Your Purchase!</h1>
        <p>We appreciate your business. Your order has been successfully processed.</p>
        <p>If you have any questions or concerns, please contact our customer support.</p>
        <a href="index.php">Continue Shopping</a>
    </div>
</body>
</html>
