<?php

namespace WPStarter;

use WP_REST_Response;
use WP_REST_Request;
use WP_Query;
use WP_Error;

class API {
  public static function register() {
    register_rest_route('app/v1', '/posts', array(
      'methods' => 'GET',
      'callback' => function (WP_REST_Request $request) {
        $parameters = $request->get_params();
        $wp_query = new WP_Query();
        $args = array();

        if (isset($parameters['slug'])) {
          $args['name'] = $parameters['slug'];
        }

        if (isset($parameters['per_page'])) {
          $args['posts_per_page'] = $parameters['per_page'];
        }

        if (isset($parameters['page'])) {
          $args['offset'] = ($parameters['page'] - 1) * $args['posts_per_page'];
        }

        $posts = $wp_query->query($args);
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
        $total_posts = $wp_query->found_posts;
        $total_pages = ceil($total_posts / (int)$wp_query->query_vars['posts_per_page']);

        $response = new WP_REST_Response($posts);
        $response->header('X-WP-Total', (int) $total_posts);
		    $response->header('X-WP-TotalPages', (int) $total_pages);

        return $response;
      },
      'args' => array(
				'per_page' => array(
					'default' => 10,
					'sanitize_callback' => 'absint',
				),
				'page' => array(
					'default' => 1,
					'sanitize_callback' => 'absint',
				),
				'slug' => array(
					'default' => null,
					'sanitize_callback' => 'sanitize_title',
				)
			),
    ));
  }
}
