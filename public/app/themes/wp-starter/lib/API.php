<?php

namespace WPStarter;

use WP_REST_Response;
use WP_REST_Request;
use WP_Error;

class API {
  public function register() {
    register_rest_route('app/v1', '/posts', array(
      'methods' => 'GET',
      'callback' => function (WP_REST_Request $request) {
        $parameters = $request->get_params();
        $args = array(
          'posts_per_page' => 2,
          'offset' => 0,
        );

        if (isset($parameters['slug'])) {
          $args['name'] = $parameters['slug'];
        }

        if (isset($parameters['posts_per_page'])) {
          $args['posts_per_page'] = $parameters['posts_per_page'];
        }

        if (isset($parameters['page'])) {
          $args['offset'] = ($parameters['page'] - 1) * $args['posts_per_page'];
        }

        $posts = get_posts($args);
        $posts = array_map(function ($post) {
          $id = $post->ID;

          return array(
            'id' => $post->ID,
            'slug' => $post->post_name,
            'timestamp' => $post->post_date,
            'date' => get_the_time('j M Y', $id),
            'title' => $post->post_title,
            'excerpt' => $post->post_excerpt,
            'content' => apply_filters('the_content', $post->post_content),
          );
        }, $posts);

        return new WP_REST_Response($posts);
      },
    ));
  }
}
