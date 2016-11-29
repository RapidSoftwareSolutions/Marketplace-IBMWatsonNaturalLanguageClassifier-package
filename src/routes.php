<?php
$routes = [
    'createClassifier',
    'listClassifiers',
    'getClassifierInformation',
    'classify',
    'deleteClassifier',
    'metadata'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}

