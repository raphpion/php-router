<?php
/**
 * Router
 * 
 * * This class uses static methods so you don't have to instantiate it.
 * * It also includes the Route class so you only need to import the Router. 
 */
class Router {

  /** The path extracted from the URL */
  private static $path;

  /** The Router's default route, when path is unrecognized */
  private static $default_route;

  /** The array of routes */
  private static $routes = [];

  /** Get the path from the current URL */
  public static function path_from_url() {
    Router::$path = str_replace( HOME_URL, '', parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
  }

  /** Simple getters */
  public static function get_path() {
    return Router::$path;
  }

  public static function get_routes() {
    return Router::$routes;
  }

  public static function get_title() {
    return Router::get_route()->get_title();
  }

  /** Get the current root instance from the current path */
  public static function get_route() {
    foreach (Router::$routes as $route)
      if ($route->get_path() == Router::$path) return $route;
    return Router::$default_route;
  }

  /** Echoers */
  public static function the_view() {
    require ABSPATH . '/views/' . Router::get_route()->get_view() . '.php';
  }

  public static function the_title() {
    if ( Router::get_title() ) {
      echo Router::get_title();
      return true;
    }
    return false;
  }

  /** 
   * Register a route in the router 
   * 
   * @return Route the route you just registered
   */
  public static function register_route( $route ) {
    array_push( Router::$routes, $route );
    return $route;
  }

  /** Register the default route in the router */
  public static function register_default_route( $route ) {
    Router::$default_route = $route;
  }
  
}

/** Extract the path from the URL when the router is included */
Router::path_from_url();

/**
 * Route instantiation
 * 
 * * This is where you create your routes. If you have a view type
 * * that has an archive as well as inner views, you can use the
 * * Route->addChild(Route $route) method; i.e: /products/{product_ID}
 * * is a child of the /products route).
 * 
 */
require __DIR__ . '/router/route.php';

/** You can instantiate routes as you register them */
Router::register_default_route( new Route( array(
  'path'  => '*',
  'view'  => '404',
  'title' => '404 - Not found',
  )));

Router::register_route( new Route( array(
  'path'  => '/',
  'view'  => 'home',
  'title' => 'Home',
  )));

/** Or instantiate them first if you want to specify hierarchy */
$parentRoute = new Route( array(
  'path'  => '/parent',
  'view'  => 'parent',
  'title' => 'Parent',
  ));
$childRoute = new Route( array(
  'path'  => '/child',
  'view'  => 'child',
  'title' => 'Child',
  ));
$parentRoute->add_child( $childRoute );

/** Then register the newly instantiated routes */
Router::register_route( $parentRoute );
Router::register_route( $childRoute );

//TODO  parametric route (i.e: /parent/child/{CHILD_NAME})