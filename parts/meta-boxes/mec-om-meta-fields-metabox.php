<?php
/*
Title: Erweiterte Attribute
Post Type: mec-events
*/

piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_classification'
    ,'label' => __('Classification', 'mec-addon-plugin')
    ,'description' => __('Field Description', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('This is help text.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'text'
    )
  ));