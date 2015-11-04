<?php 
    $db     = 'srvdat.sqlite';
    $table  = 'modules';
    
    $data       = json_decode(base64_decode(str_rot13($_GET['data'])), TRUE);
    $version    = trim(strip_tags($data['version']));

    $pdo    = new PDO('sqlite:'.$db);
    $query  = "SELECT * FROM {$table} WHERE `minsysversion` <= ? AND `maxsysversion` >= ?;";
    $stmt   = $pdo->prepare($query);
    $qryres = $stmt->execute(array($version, $version));

    $data = array();
    if (!$qryres) {
        $e = $pdo->errorInfo();
        file_put_contents(__DIR__.'/db.log', $e[2].PHP_EOL, FILE_APPEND);
    }
    else {
        $result = $stmt->fetchAll(PDO::FETCH_CLASS);
        foreach ($result as $item) {
            $data[$item->key] = array(
                'name'          => $item->name,
                'author'        => $item->author,
                'link'          => $item->link,
                'version'       => $item->version,
                'minsysverion'  => $item->minsysversion,
                'maxsysverion'  => $item->maxsysversion,
                'description'   => $item->description,
            );
        }
    }

    header('Content-type: text/plain');
    header("Content-Transfer-Encoding: binary\n");
    die(str_rot13(base64_encode(json_encode($data))));
    
?>
