<?php

namespace WPStarter;

class ACF {
  public static function register() {
    acf_add_local_field_group(array(
      'key' => 'extra',
      'title' => 'Extra',
      'fields' => array (
        array (
          'key' => 'extra_field_1',
          'label' => 'Link',
          'name' => 'link',
          'type' => 'url',
        ),
      ),
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'post',
          ),
        ),
      ),
    ));
  }
}

