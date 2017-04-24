<?php

require "vendor/autoload.php";

$config = [
    "host"     => "127.0.0.1:8889",
    "database" => "database",
    "username" => "root",
    "password" => "root",
    "charset"  => "utf8"
];

$results = (new QueryBuilder($config))
    ->setTable("testTable")
    ->setOptions("*")
    ->setInnerJoins("firstJoinTable", "joinAs", "joinColumn", "tableColumn")
    ->setLeftJoins("secondJoinTable", "joinAs", "joinColumn", "tableColumn")
    ->setRightJoins("thirdJoinTable", "joinAs", "joinColumn", "tableColumn", true)
    ->setOrder("orderKey", "DESC")
    ->setGroup("orderGroup")
    ->setLimit(5)
    ->getResults();

$createUser = (new QueryBuilder($config))
    ->setTable("users")
    ->save([
        "username" => "ugurkankya",
        "location" => "Germany"
    ]);

var_dump($createUser === true); // bool true //  
