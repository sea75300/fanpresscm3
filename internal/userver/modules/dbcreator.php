<?php

include "modulelist3.php";

$table = 'modules';

$db_file = 'srvdat.sqlite';

if (!is_writable($db_file)) {
    die('db file not writable!');
}

$db_sql = 'DROP TABLE IF EXISTS "modules";
CREATE TABLE "modules" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "key" text NOT NULL,
  "name" text NOT NULL,
  "author" text NOT NULL,
  "link" text NOT NULL,
  "version" text NOT NULL,
  "minsysversion" text NOT NULL,
  "maxsysversion" text NOT NULL,
  "description" blob NOT NULL
);

CREATE UNIQUE INDEX "modules_key_version" ON "modules" ("key", "version");';

$pdo = new PDO('sqlite:'.$db_file);

if (!filesize(__DIR__.'/'.$db_file)) {
	$pdo->exec($db_sql);
}

/* @var $result PDOStatement */
$result = $pdo->query('SELECT key, version, minsysversion FROM modules ORDER BY key');
$rows = $result->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    print "{$row['key']} :: {$row['version']} (min. {$row['minsysversion']})<br>";
}

print "<br>";

foreach($modulesServer as $key => $data) {

	$val = array(
            $key,
            $data['name'],
            $data['author'],
            $data['link'],
            $data['version'],
            $data['minsysverion'],
            $data['maxsysverion'],
            $data['description']
	);

	$query  = 'INSERT INTO `'.$table.'` (key, name, author, link, version, minsysversion, maxsysversion, description)';
	$query .= ' VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

	$statement = $pdo->prepare($query);

	print 'KEY: '.$key.' => ';

	if (!$statement->execute($val)) {

		$err = $statement->errorInfo();
		print 'ERROR: '.print_r($err, true).'<br><br>';
		continue;
	};

	print ' OK<br><br>';
}

?>
