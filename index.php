<?php

if($_GET['inspect']){

    $files = array_reverse(scandir('./request'));

    echo '<div style="padding:100px; padding-top:30px;">';
    echo '<h1>Request Check</h1>';
    echo '<hr>';
    echo '<h3>List of request</h3>';
    foreach ($files as $foo) {
        
        if(strstr($foo, '.json')){

            echo '<a href="request/'.$foo.'" target="_blank">' . $foo . '</a><br>';
            
            if($_GET['delete']){
                unlink('./request/'.$foo);
            }
        }

    }
    if($_GET['delete']){
        header("Location: index.php?inspect=true");
    }
    echo '</div>';
    echo '<a href="index.php?inspect=true&delete=true" style="position:absolute; top:5px; right:5px;">Delete All Request</a>';
    exit;
}

$file_handle = fopen('./request/' . time().'.json', 'w');
fwrite($file_handle, "POST: ". json_encode($_POST) . "\r\n");
fwrite($file_handle, "---------------------------------\r\n");
fwrite($file_handle, "GET: ". json_encode($_GET) . "\r\n");
fwrite($file_handle, "---------------------------------\r\n");
fwrite($file_handle, "BODY: " . file_get_contents('php://input') . "\r\n");
fclose($file_handle);
echo 'OK';