<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a blog</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<div class="header">
    <div class="space-between">
    </div>
    <div class="page-ref">
        <a href="index.php">Home </a>
        <a href="Creation_post.php">Create a post</a>
        <a href="Edition_post.php">Edit a post</a>
        <a href="Detail_post.php"> View the details of a post</a>
    </div>
    <div class="register-header">
        <a href="Login.php">Login</a>
        <a href="Register.php">Get started</a>
    </div>
</div>
<div class="space-between-header-post"></div>
<section class="content">
    <h4>Create a post</h4>
    <p> Write the content of you new blog here </p>
    <form>
        <label>Post Title</label>
        <input type="text" placeholder="Enter post title">
        <label> Description</label>
        <input type="text" placeholder="Enter a description">
        <label>Post content</label>
        <textarea placeholder="Enter you content "></textarea>
        <button>Post the blog</button>
    </form>

</section>

</body>
</html>


