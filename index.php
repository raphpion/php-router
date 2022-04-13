<?php
/**
 * Index
 * 
 * This is the file where all your http requests will be redirected to.
 * You can segment its content into multiple files but for the sake of
 * simplicity, this base file will have everything included in there.
 */

/**
 * Project's constants definitions
 * 
 * * You could put these definitions in a config.php file and include it
 * * along the functions. If you want to put your private API keys in here
 * * and don't want to publish them on a repository, you could add the 
 * * config.php file to .gitignore and create a config-sample.php file, 
 * * which has the same options but with empty values. Then, before you
 * * import your config.php file, check if it exists and if it doesn't, you
 * * can clone the sample file.
 */
/** Absolute path — from your computer's root to this directory */
define( 'ABSPATH', __DIR__ );

/** The URL we will be using to access your website */
define( 'HOME_URL', 'http://php-router' );

/** The website's title */
define( 'WEBSITE_TITLE', 'PHP router');

/**
 * Functions to hook up our site with the Router
 * 
 * * Our Router doesn't need to know how our website uses its methods
 * * and vice-versa. We will separate the latter with the following
 * * functions so one does not rely on the other.
 */
require ABSPATH . '/controllers/router.php';

/** Get the page title */
function the_title() {
  if ( Router::the_title() ) echo ' | ';
  echo WEBSITE_TITLE;
}

/** Get the view from the router */
function the_view() {
  Router::the_view();
}

/**
 * The website's content
 * 
 * * A good practice would be to divide your website's content into
 * * multiple components. I like going with:
 * *   -  Header  DOCTYPE, html and body opening, head, navbar and hero
 * *   -  Main    The content
 * *   -  Footer  Footer, scripts, body and html closing
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php the_title() ?></title>
</head>
<body>
  <header></header>
  <main>
    <?php the_view() ?>
  </main>
  <footer></footer>
</body>
</html>