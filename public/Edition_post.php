<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Post</title>
    <link rel="stylesheet" href="style-page/style.css">

</head>
<body>
<div class="header">
    <div class="space-between">
    </div>
    <div class="page-ref">
        <a href="index.php">Home </a>
        <a href="Creation_post.php">Create a blog</a>
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
    <h4>Edit a blog</h4>
    <p> Write the new content of your blog here </p>
    <form>
        <label>Post Title</label>
        <input type="text" placeholder="Enter post title">
        <label>Post number</label>
        <input type="number" placeholder="Enter post number">
        <label> Image </label>
        <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg"/>
        <label>Post content</label>
        <textarea placeholder="Enter you content "></textarea>
        <button>Post the blog</button>

    </form>

</section>

</body>
</html>
