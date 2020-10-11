<?php 
	return array(
		0 => array(
            '^(v\/.*|)$' => array(
				'controller' => 'Main',
				'action' => 'Standart',
				'from_client' => true,
				'path_param' => 1,
				'control_AC' => array(
					'ADMIN' => true,
					'WORK' => true
				),
				'val'=> array('who' => 'ItsMeMario')
			)            
		),
		1 => array(
			'ADMIN' => '/',
			'WORK' => '/'
		),
	);