<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <title>Forgot Password</title>
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        form {
            width: 800px;
            margin: 0 auto;
            margin-top: 8rem;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            background-color: #cccccc;
            color:black;
            padding: 14px 20px;
            margin: 8px 0;
            border: 2px solid black ;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            opacity: 0.8;
        }
        .container {
            text-align: center;
        }
        .error {
            color:red;
        }
        /* Change styles for cancel button on extra small screens */
        @media screen and (max-width: 850px) {
            form {
                width: 350px;
                margin-top: 4rem;
            }
        }
    </style>
</head>
<body>

<form action="reset_password.php" method="post">
    <div class="container">
        <h2>Forgot Password</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <label for="trainer_name"><b>Trainer Name</b></label>
        <input type="text" placeholder="Enter Trainer Name" name="trainer_name" required>

        <label for="new_password"><b>New Password</b></label>
        <input type="password" placeholder="Enter New Password" name="new_password" required>
        
        <button type="submit" name="submit">Reset Password</button>
    </div>
</form>

</body>
</html>
