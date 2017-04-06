<?php

require 'lib/bootstrap.php';

new Timber\Timber();

Timber::$dirname = array(
  'views',
  'views/templates',
);

class Site extends TimberSite {
  function __construct() {
    WPStarter\Theme::customize();

    add_filter('timber_context', array($this, 'add_to_context'));
    add_filter('get_twig', array($this, 'add_to_twig'));
    add_filter('acf/settings/show_admin', '__return_false');

    add_action('init', 'WPStarter\PostTypes::register');
    add_action('init', 'WPStarter\Taxonomies::register');
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
