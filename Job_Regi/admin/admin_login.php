<?php

session_start();

$admin_username = "admin";
$admin_password = "1234";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
      body {
            font-family: 'Roboto', Arial, sans-serif;
            /* background: linear-gradient(to bottom right, #6a11cb, #2575fc); */
            background : white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        
        .login-container {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            padding: 30px 40px;
            box-sizing: border-box;
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            /* color: #2575fc; */
            color: #eb5406;
            font-size: 28px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        label{
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
            color: #333;
            margin-top :10px;
        }

        input, textarea, password {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            background: #f9f9f9;
            color: #333;
            transition: all 0.3s ease-in-out;
            box-sizing: border-box;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            background: #f9f9f9;
            color: #333;
            transition: all 0.3s ease-in-out;
            box-sizing: border-box;
        }

        input[type="submit"] {
            /* background: linear-gradient(to right, #6a11cb, #2575fc); */
            background : #eb5406;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease-in-out;
            border-radius: 50px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"]:hover {
            /* background: linear-gradient(to right, #2575fc, #6a11cb); */
            background: #272727;
            transform: scale(1.05);
            box-shadow: 0px 5px 15px rgba(37, 117, 252, 0.3);
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
        button{
            /* background: linear-gradient(to right, #6a11cb, #2575fc); */
            background: #eb5406;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
            width: 100%;
            box-sizing: border-box;
            margin-top: 15px;
        }
        button:hover{
            /* background: linear-gradient(to right, #2575fc, #6a11cb); */
            background:#272727;
            transform: scale(1.05);
            box-shadow: 0px 5px 15px rgba(37, 117, 252, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                width:80%;
                padding: 20px;
            }

            input[type="text"], input[type="password"] {
                font-size: 14px;
                padding: 8px;
            }

            input[type="submit"], button {
                font-size: 16px;
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                width:80%;
                padding: 15px;
            }

            input[type="text"], input[type="password"] {
                font-size: 12px;
                padding: 6px;
            }

            input[type="submit"], button {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>
        <form method="POST">
            <label for="username">Username<z style="color:red;">*</z></label>
            <input type="text" name="username" placeholder="Username" required>
            <label for="password">Password<z style="color:red;">*</z></label>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <button onclick = "window.location.href = '../index.html'">Home Page</button>
    </div>
</body>
</html>
