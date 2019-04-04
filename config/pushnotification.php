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
		'apiKey' => 'AIzaSyB56Xh1A7HQDPQg_7HxrPTcSNnlpqYavc0',
	],
	'apn' => [
		'certificate' => __DIR__ . '/iosCertificates/woodleOneSignal.pem',
//		'certificate' => __DIR__ . '/iosCertificates/apn-prod.pem',
//		'certificate' => __DIR__ . '/iosCertificates/apn-dev.pem',
		'passPhrase' => '123456', //Optional
//      'passFile' => __DIR__ . '/iosCertificates/yourKey.pem', //Optional
		'dry_run' => false
	]
];