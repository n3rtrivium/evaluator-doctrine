<?php

use N3rtrivium\EvaluatorDoctrine\App;

require_once "../bootstrap.php";

$app = new App($entityManager);
$app->handle();