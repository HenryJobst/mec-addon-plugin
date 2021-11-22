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
  ));

piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_winsplits'
    ,'label' => __('Split times in WinSplits Online', 'mec-addon-plugin')
    ,'description' => __('URL of the event in WinSplits Online', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('URL of the event in WinSplits Online to further analyze split times.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text'
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
  ));
  
piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_hygiene_concept'
    ,'label' => __('Hygiene Concept', 'mec-addon-plugin')
    ,'description' => __('URL of the hygiene concept', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Full URL of the page or file with the hygiene concept.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));

piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_technical_information'
    ,'label' => __('Technical Information', 'mec-addon-plugin')
    ,'description' => __('URL of the technical informations', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Full URL of the page or file with the technical informations.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));
  
piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_course_information'
    ,'label' => __('Course Informations', 'mec-addon-plugin')
    ,'description' => __('URL of the course informations', 'mec-addon-plugin')
    ,'value' => ''
    ,'help' => __('Full URL of the page or file with the course informations.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));

  piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_extra_1'
    ,'label' => __('Extra link 1', 'mec-addon-plugin')
    ,'description' => __('URL of the extra link 1', 'mec-addon-plugin')
    ,'value' => null
    ,'help' => __('Full URL of the page or file with extra informations 1.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));
  
  piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_symbol_extra_1'
    ,'label' => __('Extra symbol 1', 'mec-addon-plugin')
    ,'description' => __('Short text for the extra informations 1', 'mec-addon-plugin')
    ,'value' => null
    ,'help' => __('Short text for the extra informations 1.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));
  
  piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_title_extra_1'
    ,'label' => __('Extra title 1', 'mec-addon-plugin')
    ,'description' => __('Title for the extra informations 1', 'mec-addon-plugin')
    ,'value' => null
    ,'help' => __('Title text for the extra informations 1.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));
  
  piklist('field', array(
    'type' => 'radio'
    ,'field' => 'om_mode_extra_1'
    ,'label' => __('Extra mode 1', 'mec-addon-plugin')
    ,'description' => __('Mode for the extra informations 1', 'mec-addon-plugin')
    ,'choices' => array(
      '1' => __('Show only for events in past', 'mec-addon-plugin'),
      '2' => __('Show only for upcomming events', 'mec-addon-plugin'),
      '3' => __('Show for all events', 'mec-addon-plugin')
    )
    ,'help' => __('Mode for the extra informations 1.','mec-addon-plugin')
  ));
  
  piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_extra_2'
    ,'label' => __('Extra link 2', 'mec-addon-plugin')
    ,'description' => __('URL of the extra link 2', 'mec-addon-plugin')
    ,'value' => null
    ,'help' => __('Full URL of the page or file with extra informations 2.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));
  
  piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_symbol_extra_2'
    ,'label' => __('Extra symbol 2', 'mec-addon-plugin')
    ,'description' => __('Short text for the extra informations 2', 'mec-addon-plugin')
    ,'value' => null
    ,'help' => __('Short text for the extra informations 2.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));
  
  piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_title_extra_2'
    ,'label' => __('Extra title 2', 'mec-addon-plugin')
    ,'description' => __('Title for the extra informations 2', 'mec-addon-plugin')
    ,'value' => null
    ,'help' => __('Title text for the extra informations 2.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));
  
  piklist('field', array(
    'type' => 'radio'
    ,'field' => 'om_mode_extra_2'
    ,'label' => __('Extra mode 2', 'mec-addon-plugin')
    ,'description' => __('Mode for the extra informations 2', 'mec-addon-plugin')
    ,'choices' => array(
      '1' => __('Show only for events in past', 'mec-addon-plugin'),
      '2' => __('Show only for upcomming events', 'mec-addon-plugin'),
      '3' => __('Show for all events', 'mec-addon-plugin')
    )
    ,'help' => __('Mode for the extra informations 2.','mec-addon-plugin')
  ));
  
  piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_link_extra_3'
    ,'label' => __('Extra link 3', 'mec-addon-plugin')
    ,'description' => __('URL of the extra link 3', 'mec-addon-plugin')
    ,'value' => null
    ,'help' => __('Full URL of the page or file with extra informations 3.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));
  
  piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_symbol_extra_3'
    ,'label' => __('Extra symbol 3', 'mec-addon-plugin')
    ,'description' => __('Short text for the extra informations 3', 'mec-addon-plugin')
    ,'value' => null
    ,'help' => __('Short text for the extra informations 3.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));
  
  piklist('field', array(
    'type' => 'text'
    ,'field' => 'om_title_extra_3'
    ,'label' => __('Extra title 3', 'mec-addon-plugin')
    ,'description' => __('Title for the extra informations 3', 'mec-addon-plugin')
    ,'value' => null
    ,'help' => __('Title text for the extra informations 3.','mec-addon-plugin')
    ,'attributes' => array(
      'class' => 'regular-text',
    )
  ));
  
  piklist('field', array(
    'type' => 'radio'
    ,'field' => 'om_mode_extra_3'
    ,'label' => __('Extra mode 3', 'mec-addon-plugin')
    ,'description' => __('Mode for the extra informations 3', 'mec-addon-plugin')
    ,'choices' => array(
      '1' => __('Show only for events in past', 'mec-addon-plugin'),
      '2' => __('Show only for upcomming events', 'mec-addon-plugin'),
      '3' => __('Show for all events', 'mec-addon-plugin')
    )
    ,'help' => __('Mode for the extra informations 3.','mec-addon-plugin')
  ));