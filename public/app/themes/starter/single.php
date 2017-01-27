<?php

$post = new TimberPost();
$context = Timber::get_context();

$context['post'] = $post;
$context['disqus'] = Timber::get_sidebar('disqus.twig', $context);

Timber::render('single.twig', $context);
