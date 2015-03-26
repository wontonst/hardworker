<?
require_once('NetworkOperation.php');
require_once('FileOperation.php');

echo '****INITIALIZING trafXsweep CMake****'."\n";
while(true) {
    echo 'starting new cycle...';
    usleep(1000000);
    echo 'DONE'."\n";
    $array = array();
    $array[] = new NetworkOperation();
    $array [] = new FileOperation();
    shuffle($array);
    foreach($array as $v) {
        $v->run();
    }

}
?>