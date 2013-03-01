<?php	
	require_once 'resources/modules/Twig-1.12.2/lib/Twig/Autoloader.php';
	
	// register Twig
	Twig_Autoloader::register();
	
	$loader = new Twig_Loader_Filesystem($__TEMPLATES_PATH);
	$twig = new Twig_Environment($loader, array(
		'debug' => true,
		//'cache' => '../spital/compilation_cache',
	));
	
?>