<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>
    <link rel="stylesheet" href="style-page/style.css">

</head>
<body>
<div class="header" >
    <div class="space-between">
    </div>
    <div class="page-ref">
        <a href="index.php" >Home </a>
        <a href="Creation_post.php">Create a post</a>
        <a href="Edition_post.php">Edit a post</a>
        <a href="Detail_post.php"> View the details of a post</a>
    </div>
    <div class="register-header">
        <a href="Login.php">Login</a>
        <a href="Register.php">Get started</a>
    </div>
</div>
<style>
    <?php include 'style-page/style_register.css'; ?>
</style>

<div class="header-to">
    <div class="background">
        <div id="login">

            <p>Create your account </p>

            <form>
                <div class="enter_information">
                    <label>Username</label>
                    <input type="text" placeholder="Enter your password">
                </div>

                <div class="enter_information">
                    <label>Email  </label>
                    <input type="email" placeholder="Enter you email or username">
                </div>

                <div class="enter_information">
                    <label>Passwords</label>
                    <input type="password" placeholder="Enter your password">
                </div>

                <div class="enter_information">
                    <label>Confirm your password</label>
                    <input type="password" placeholder="Enter your password">
                </div>

                <button>Register</button>

                <div class="t">
                    <a href="Login.php">Already have an account ?</a>

                </div>
            </form>

        </div>
    </div>


</div>
</body>
</html>

