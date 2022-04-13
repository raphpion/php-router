<?php
/**
 * Route
 * 
 * * This class is used to creates routes for your Router.
 */
class Route {

  /** The path from the website URL or parent route */
  private $path;

  /** The view associated with the route */
  private $view;

  /** The view Title */
  private $title;
  
  /** The view parent route, MUST be unique */
  private $parent;

  /** The view children routes */
  private $children = [];

  /**
   * Constructor
   * 
   * @param Array the array of arguments. See documentation for info
   * @throws Exception if the route instantiation failed
   */
  public function __construct( $args ) {
    
    /** The 'path' and 'view' parameters are mandatory. */
    if ( !array_key_exists( 'path', $args ) || !array_key_exists( 'view', $args ) )
      throw new Exception('Route instantiation failed! Missing mandatory parameter.');

    $this->path = $args['path'];
    $this->view = $args['view'];

    /** 'title' defaults to empty string */
    if ( array_key_exists( 'title', $args ) )
      $this->title = $args['title'];
    else $this->title = '';

    $this->parent = NULL;

  }

  /** Simple getters */
  public function get_path() {
    if ( is_null( $this->parent ) ) return $this->path;
    else return $this->parent->get_path() . $this->path;
  }

  public function get_view() {
    if ( is_null( $this->parent ) ) return $this->view;
    else return $this->parent->get_view() . '/' . $this->view;
  }

  public function get_title() {
    if ( empty( $this->title ) ) return false;
    return $this->title;
  }

  public function get_parent() {
    if ( is_null( $this->parent ) ) return false;
    return $this->parent;
  }

  public function get_children() {
    if ( empty( $this->children ) ) return false;
    return $this->children;
  }
  
  /** Setters */
  private function set_parent( $route ) {
    $this->parent = $route;
  }

  /**
   * Add a child route to the route
   * 
   * @param Route the route to add
   * @throws Exception if the parameter's route already has a parent
   * @return Route the route you just added as child
   */
  public function add_child( $route ) {

    /** A route can't be child of multiple routes */
    if ( $route->get_parent() )
      throw new Exception('Unable to add child route as it already has a parent.');
    
    $route->set_parent( $this );
    array_push( $this->children, $route );

  }

}
