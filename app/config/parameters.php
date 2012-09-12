<?php
// app/config/parameters.php
$services_json = json_decode(getenv("VCAP_SERVICES"), true);
$mysql_config = $services_json["mysql-5.1"][0]["credentials"];

$username = $mysql_config["username"];
$password = $mysql_config["password"];
$hostname = $mysql_config["hostname"];
$port = $mysql_config["port"];
$db = $mysql_config["name"];

$container->setParameter('doctrine.dbal.host', $hostname);
$container->setParameter('doctrine.dbal.port', $port);
$container->setParameter('doctrine.dbal.user', $username);
$container->setParameter('doctrine.dbal.password', $password);
$container->setParameter('doctrine.dbal.dbname', $db);