
# Web Blog

## Description

This is a web blog application that allows users to create, edit, and view blogs from other users.


## Feature

- **Add a Blog**: Users can add a blog with an image, title, and content.
- **Edit a Blog**: Users can edit the content, title, and image of their blogs.
- **View Posts**: Users can view blogs created by all users.
- **Edit Profile Page**: Users can change their username, email or password and view all the posts they have created.

## Technologies Used

- **PHP**: Adds logic to the HTML pages.
- **SQLite**: Stores user data and blog content in a database.
- **CSS**: Adds styling and layout to the web pages.
- **HTML**: Provides the structure of the web pages.

## Installation

1. Clone the repository:
   ```bash
   git clone git@github.com:maryam-amn/php_blog.git

2. Clone the repository:
   ```bash
   cd php_blog
3. Install Tailwind CSS dependencies :
    ```bash
     npm install
4. Compile Tailwind CSS: :
    ```bash
     npx tailwindcss build -o public/style-page/style.css  
5. Start a local PHP server: 
    ```bash
    php -S localhost:8000 -t public
6. Open the web blog application: 
    ```bash
    http://localhost:8080/index.php