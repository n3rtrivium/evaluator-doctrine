<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

require_once "vendor/autoload.php";

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/src'), $isDevMode);

$entityManager = false;
$parametesContent = @file_get_contents(__DIR__.'/parameters.yml');
if ($parametesContent == false) {
	printf("Unable to read %s\nCopy and modify parameters.yml.dist!\n", __DIR__.'/parameters.yml');
} else {
	$yaml = new Parser();
	$parametes = array();
	try {
		$parametes = $yaml->parse($parametesContent);
	} catch (ParseException $e) {
		printf("Unable to parse the YAML string: %s\n", $e->getMessage());
	}
	
	if (!array_key_exists('connection', $parametes)) {
		printf("Unable to find connection in parameters.yml\n");
	} else {
		// obtaining the entity manager
		$entityManager = EntityManager::create($parametes['connection'], $config);
	}
}

if (!$entityManager) {
	die("Entity manager not created!\n");
}
