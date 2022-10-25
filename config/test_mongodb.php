<?php
$mongo = require __DIR__ . '/mongodb.php';
// test database! Important not to run tests on production or development databases
$mongo['defaultDatabaseName'] = getenv('MONGO_INITDB_DATABASE_TEST');

return $mongo;