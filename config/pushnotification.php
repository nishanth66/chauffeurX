<?php

return [
	'gcm' => [
		'priority' => 'normal',
		'dry_run' => false,
		'apiKey' => 'My_ApiKey',
	],
	'fcm' => [
		'priority' => 'normal',
		'dry_run' => false,
		'apiKey' => 'AIzaSyB9ImUqic1fX-09kGXljfgOUu0WaOwwEnk',
	],
	'apn' => [
		'certificate' => __DIR__ . '/iosCertificates/woodleup.pem',
//		'certificate' => __DIR__ . '/iosCertificates/woodleOneSignal.pem',
//		'certificate' => __DIR__ . '/iosCertificates/apn-prod.pem',
//		'certificate' => __DIR__ . '/iosCertificates/apn-dev.pem',
//		'passPhrase' => '123456', //Optional
//      'passFile' => __DIR__ . '/iosCertificates/yourKey.pem', //Optional
		'dry_run' => false
	]
];
