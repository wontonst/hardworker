<?
require_once('DataGenerator.php');
require_once('DataGrabber.php');

class FileOperation {
    private $state;
    function __construct() {
        $this->state = 0;
    }
    function run() {
        switch($this->state) {
        case -1:
            return;
        case 0:
            $this->open();
            $this->state++;
            break;
        case 1:
            $this->recursiveCopyFiles();
            $this->state = -1;
        }
        $this->run();
    }
    function open() {
        echo '***starting file i/o operations to hard drive '.DataGenerator::capitalLetter().':/'."\n";
        for($i = 0; $i != 7; $i++) {
            echo "\t";
            echo 'copying file '.DataGenerator::randomString().DataGenerator::randomArchive();
            echo '..........';
            usleep(rand(800000,1200000));
            echo 'done'."\n";
        }
    }
    function recursiveCopyFiles() {
        $it = rand(1,4);
        for($i = 0; $i < $it; $i++) {
            $directory = DataGenerator::directoryPath();
            echo 'checking directory '.$directory.'  ';
            $time = rand(800000,5100000);
            while(true) {
                if($time > 500000) {
                    usleep(500000);
                    $time-=500000;
                    echo '.';
                } else {
                    usleep($time);
                    break;
                }
            }
            echo "\n";
            $this->recursiveCopy($directory);
        }
    }
    function recursiveCopy($path) {
        $it = rand(0,4);
        for($i = 0; $i != $it; $i++) {
            echo "\t".'copying file '.$path.DataGenerator::randomFile()."\n";
            usleep(rand(400000,1400000));
        }
        $it = rand(0,2);
        if($it == 2) {
            $this->recursiveCopy($path.DataGrabber::grab('directory.txt').'/');
        }
    }
    function formatFiles() {
        $ext = DataGenerator::randomSource();
        for($i = 0; $i != 25; $i++) {
            $file = DataGrabber::grab('source.txt').$ext;
            echo 'formatting file '.$file."\n ***";
            echo (rand(0,1) == 0) ? 'no formatting required for ':'formatting completed for ';
            echo $file."\n";

        }
    }
}

//$fio = new FileOperation();
//$fio->formatFiles();

?>