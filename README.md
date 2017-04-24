Query Builder is a simple php pdo mysql database wrapper which supports the commonly used queries such as GROUP, ORDER, LIMIT and WHERE.

It also supports three join conditions (Inner Join, Left Join, Right Join) including Outer Joins.

The Query Builder has a great architecture of flexibility due it's flexibility it makes easy to extend the class with new functionalities.

Since the query builder uses prepared statements it's safe from sql injection and manual escaping isn't necessary.

Please note that you still need to escape any html input by yourself.

Installation & Setup

First switch to your project by using cd (cd /Applications/MAMP/htdocs).

After enter composer dump-autoload -o in the terminal and run the command.

This command will create the composer autoloader for autoloading.

For the usage you may take a look at usage.php
