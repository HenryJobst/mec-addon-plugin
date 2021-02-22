<?php
/*
Title: Erweiterte Attribute (Meta: om_*)
Post Type: mec-events
*/

piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_sport'
    ,'label' => __('Type of sport', 'mec-addon-plugin')
    ,'description' => __('Type of sport', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Type of sport of this event. (OL, MTB-O, Crosslauf, ...)','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'text'
    )
  ));

piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_sportstype'
    ,'label' => __('Type', 'mec-addon-plugin')
    ,'description' => __('Type', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Type of this event. (Single, Relay, Team, ...)','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'text'
    )
  ));
  
piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_discipline'
    ,'label' => __('Discipline', 'mec-addon-plugin')
    ,'description' => __('Discipline', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Discipline of this event. (Sprint, Middle, Long, ...)','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'text'
    )
  ));

piklist('field', array(
    'type' => 'datepicker'
    ,'field' => 'om_date_register'
    ,'label' => __('Registration date', 'mec-addon-plugin')
    ,'description' => __('Registration date in form of 2021-01-31', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Registration date of this event.','mec-addon-plugin')
    ,'attributes' => array(
      'dateFormat' => 'yyyy-mm-dd'
    )
  ));

piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_classification'
    ,'label' => __('Classification', 'mec-addon-plugin')
    ,'description' => __('Classification of the event', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('E.g. short name of the classification. (LRL, DM, BRL, ...)','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text'
    )
  ));

piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link'
    ,'label' => __('Event Link', 'mec-addon-plugin')
    ,'description' => __('URL of the event', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Full URL of the page or file with the event.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text'
    )
    ,'validate' => array(
      array(
        'type' => 'url'
      )
    )
  ));

piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_announcement'
    ,'label' => __('Announcement', 'mec-addon-plugin')
    ,'description' => __('URL of the announcement', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Full URL of the page or file with the event announcement.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text'
    )
    ,'validate' => array(
      array(
        'type' => 'url'
      )
    )
  ));
  
piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_registration'
    ,'label' => __('Registration', 'mec-addon-plugin')
    ,'description' => __('URL of the registration', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Full URL of the page or file with the event registration.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text'
    )
    ,'validate' => array(
      array(
        'type' => 'url'
      )
    )
  ));
  
piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_results'
    ,'label' => __('Results', 'mec-addon-plugin')
    ,'description' => __('URL of the results', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Full URL of the page or file with the event results.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text'
    )
    ,'validate' => array(
      array(
        'type' => 'url'
      )
    )
  ));
  
piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_resultsplits'
    ,'label' => __('Results with splits', 'mec-addon-plugin')
    ,'description' => __('URL of the results with splits', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Full URL of the page or file with the event results with splits.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text'
    )
    ,'validate' => array(
      array(
        'type' => 'url'
      )
    )
  ));
  
piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_routegadget'
    ,'label' => __('RouteGadget', 'mec-addon-plugin')
    ,'description' => __('URL of the RouteGadget page for this event', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Full URL of the page with the RouteGadget page for this event.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text'
    )
    ,'validate' => array(
      array(
        'type' => 'url'
      )
    )
  ));
  
piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_startlist'
    ,'label' => __('Startlist', 'mec-addon-plugin')
    ,'description' => __('URL of the startlist', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Full URL of the page or file with the startlist.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
    ,'validate' => array(
      array(
        'type' => 'url'
      )
    )
  ));
  