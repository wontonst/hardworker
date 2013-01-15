<?

$files = array('urls.txt','usrnames.txt','programs.txt','directory.txt','source.txt','package.txt');

foreach($files as $filename) {
    $file = fopen($filename,'r');

    $lines = 0;
    $array = array();
    while($line = fgets($file)) {
        $array[] = $line;
        $lines++;
    }
    $array[0] = ($lines-1)."\n";
    $file = fopen($filename,'w');
    fwrite($file,implode($array));

}

?>