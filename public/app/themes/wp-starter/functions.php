<?php

new Timber\Timber();

// Timber::$cache = true;
Timber::$dirname = array(
  'views',
  'views/templates',
);

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

    add_action('init', 'WPStarter\PostTypes::register');
    add_action('init', 'WPStarter\PostTypes::register');
    add_action('rest_api_init', 'WPStarter\API::register');
    add_action('acf/init', 'WPStarter\ACF::register');
    add_action('wp_enqueue_scripts', 'WPStarter\Assets::load');

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
}

new Site();
