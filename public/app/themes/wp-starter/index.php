<?php

$context = Timber::get_context();
$context['posts'] = Timber::get_posts(array(
  'post_type' => 'post'
));

Timber::render('index.twig', $context);
