Query Builder is a simple php pdo mysql database wrapper which supports the commonly used queries such as GROUP, ORDER, LIMIT and WHERE.

It also supports three join conditions (Inner Join, Left Join, Right Join) including Outer Joins.

The Query Builder has a great architecture of flexibility due it's flexibility it makes easy to extend the class with new functionalities.

Since the query builder uses prepared statements it's safe from sql injection and manual escaping isn't necessary.

Please note that you still need to escape any html input by yourself.

Installation & Setup

First switch to your project by using cd (cd /Applications/MAMP/htdocs).

After enter composer dump-autoload -o in the terminal and run the command.

This command will create the composer autoloader for autoloading.

Now take a look at the usage of the Query Builder.

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

    If you leave the options empty, it will fetch all the columns.

    For the left joins and right joins, if you pass the 5th parameter to true, outer join will be used.

    If you don't specify the order type ASC will be used.

    Query Builder supports fetching a single result too, just pass the first parameter to true and fetchOne method will be prefered.

    Now let's take a look at the save() method.

    $createUser = (new QueryBuilder($config))
                ->setTable("users")
                ->save([
                 "username" => "ugurkankya",
                 "location" => "Germany"
                ]);

                var_dump($createUser === true); // bool true //                
