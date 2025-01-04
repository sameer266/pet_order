<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Pet Pal</title>
    <style>
        /* Global Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-image: url('photos/background.webp');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        h1 {
            font-size: 48px;
            color: white;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
        }

        /* Container for the buttons */
        .container {
            background-color: rgba(255, 255, 255, 0.53); /* Semi-transparent white background */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            display: inline-block;
        }

        /* Button Container */
        .button-container {
            margin-top: 20px;
        }

        /* Button Styles */
        .login-button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 18px;
            text-decoration: none;
            color: white;
            background-color: #4caf50;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .login-button:hover {
            background-color: #45a049;
            transform: translateY(-3px); /* Lift effect */
        }

        .login-button:active {
            background-color: #388e3c;
            transform: translateY(0); /* Clicked effect */
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            h1 {
                font-size: 36px;
            }

            .login-button {
                font-size: 16px;
                padding: 12px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Pet Pal</h1>
        <div class="button-container">
            <a href="customer/customer_login.php" class="login-button">Login as Customer</a>
        </div>
        <div class="button-container">
            <a href="admin/index.php" class="login-button">Login as Admin</a>
        </div>
    </div>
</body>
</html>
