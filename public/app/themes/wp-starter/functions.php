<?php

new Timber\Timber();

Timber::$dirname = array('templates', 'views');

class Site extends TimberSite {
  function __construct() {
    add_theme_support('custom-logo');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption'
    ));

    add_filter('timber_context', array($this, 'add_to_context'));
    add_filter('get_twig', array($this, 'add_to_twig'));
    add_filter('acf/settings/show_admin', '__return_false');
    add_filter('wpseo_metabox_prio', '__return_false');

    add_action('init', array($this, 'register_post_types'));
    add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));

    parent::__construct();
  }

  function add_to_context($context) {
    $context['site'] = $this;
    $context['site']->logo = new TimberImage(get_theme_mod('custom_logo'));
    $context['menu'] = new TimberMenu();

    return $context;
  }

  function add_to_twig($twig) {
    $twig->addExtension(new Twig_Extension_StringLoader());

    return $twig;
  }

	function register_post_types() {}

  function enqueue_assets() {
    // wp_enqueue_style(
    //   'main.css',
    //   get_template_directory_uri() . '/dist/styles/main.css'
    // );

    // wp_enqueue_script(
    //   'main.js',
    //   get_template_directory_uri() . '/dist/scripts/main.js',
    //   array(),
    //   filemtime(get_stylesheet_directory() . '/dist/scripts/main.js'),
    //   true
    // );
  }
}

new Site();
