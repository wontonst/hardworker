<?
require_once('DataGenerator.php');

class NetworkOperation {
    public $debug;///<enables debugging mode

    private $state;
    private $bad;///<files that did not match the hash
    private $download;///<files downloaded too bechecked
    private $sockets;///<array of IPs
    function __construct() {
        $this->debug = false;
        $this->state = 0;
        $this->download = null;
        $this->bad = null;
        $this->sockets = array();
    }
    function run() {
        switch($this->state) {
        case -1:
            $this->close();
            return;
        case 0:
            $this->open();
            $this->state++;
            break;
        case 1:
            $this->download();
            $this->state = rand(1,2);
            break;
        case 2:
            $this->checkHash();
            if($this->bad == null) {
                $this->state = -1;
                echo 'network io operations successfully completed'."\n";
            } else $this->state = 3;
            break;
        case 3:
            $this->download();
            $this->state = 2;
        }
        $this->run();
    }
    function open() {
        echo 'connecting to master server at '.DataGenerator::ipv4().'/'.DataGenerator::ipv6()."\n";
        echo 'retrieving serverlist....'."\n";
        if(!$this->debug)usleep(rand(1000000,2000000));
        for($i = 0; $i != 45; $i++) {
            $s = DataGenerator::setw(NetworkOperation::IPPair(),40);
            $s2 = NetworkOperation::IPPair();
            echo $s.$s2."\n";
            if(!$this->debug)usleep(70000);
        }

        $ip4 = DataGenerator::ipv4();
        $ip6 = DataGenerator::ipv6();
        $this->sockets[] = $ip4;
        $this->sockets[]=$ip6;
        echo 'opening socket to remote host '.$ip4.'/'.$ip6.'....';
        if(!$this->debug)
            usleep(1000000);
        echo 'connection established!'."\n";
        echo 'obtaining associated addresses...'."\n";
        for($i = 1 ; $i != 9; $i++) {
            if(!$this->debug)
                usleep(rand(180000,440000));
            $v4 = DataGenerator::ipv4();
            $v6 = DataGenerator::ipv6();
            $this->sockets[] = $v4;
            $this->sockets[]=$v6;
            echo '       '.$v4.' / '.$v6."  ($i)\n";
        }
    }
    public function download() {
        if($this->download == null)
            $this->download = array();
        $ip4 = DataGenerator::ipv4();
        $ip6 = DataGenerator::ipv6();
        $this->sockets[] = $ip4;
        $this->sockets[]=$ip6;
        echo 'connecting to remote database at '."\n\t\t".$ip4."\n\t\t".$ip6."\n\t\t".'on port '.rand(2000,40000).'.....';
        if(!$this->debug)
            usleep(rand(800000,1200000));
        echo 'done'."\n";

        if($this->bad == null)
            for($i = 0; $i != 10; $i++) {
                $this->download[] = $temp = DataGenerator::randomFile();
                NetworkOperation::networkFileOperation($temp);
            }
        else
            for($i = 0; $i != count($this->bad); $i++) {
                $this->download[] = $temp = $this->bad[$i];
                $this->networkFileOperation($temp);
            }
        $this->bad = null;
    }
    public function checkHash() {
        $this->bad = array();
        echo 'beginning CHECKSUM verification!'."\n";
        for($i = 0; $i != count($this->download); $i++) {
            $passfail = rand(0,5);
            if($this->download == null) {
                echo 'CRITICAL ERROR: Could not locate downloaded files....'."\n";
                $filename = DataGenerator::randomString().DataGenerator::randomFile();
            } else $filename = $this->download[$i];
            echo 'comparing checksum for '.$filename."\n\t";
            if(!$this->debug)
                usleep(rand(400000,1300000));
            echo crc32($filename).' / '.md5($filename).' ('.(($passfail==1)?'FAILED!':'pass').")\n";
            if($passfail == 1) {
                echo "\t".'checksum test failed please redownload file from'."\n\t\t".DataGenerator::ipv4().'/'.DataGenerator::ipv6()."\n\t\t".DataGenerator::directoryPath()."$filename\n";
                $this->bad[] = $filename;
            }
        }
        $this->download = null;
        if(empty($this->bad)) {

            if($this->debug) {
                echo '$this->bad was deemed empty. Debug:'."\n";
                var_dump($this->bad);
                $this->bad= null;
            }
        } else echo '--REDOWNLOADING FAILED FILE--'."\n";

    }
    public function send() {
        echo 'connecting to remote database at '.DataGenerator::ipv4().' on port '.rand(2000,40000).'.....';
        if(!$this->debug)
            usleep(rand(400000,800000));
        echo 'done'."\n";
        echo 'beginning data transfer'."\n";
        for($i = 0; $i != 10; $i++) {
            $filename = DataGenerator::randomFile();
            $this->networkFileOperation($filename,'sending');
            /*
                        $size = rand(2000,8000);
                        $speed = rand(2000,3000);
                        $remaining = $size;
                        echo 'Sending file  '.DataGenerator::randomFile().' ('.rand(0,64).'/'.$size.') @ '.$speed.' kbps'."\n";
                        while(true) {
                            if($remaining > $speed)
                if(!$this->debug)
                		  usleep(1000000);
                            else {
            if(!$this->debug)
                                usleep(1000000*$remaining/$size);
                                break;
                            }
                            $remaining -= $speed;
                            echo '   ('.($size-$remaining).'/'.$size.')'."\n";
                        }
                        echo "\t".'DONE'."\n";
            */
        }
    }
    function close() {
        if(count($this->sockets) == 0) {
            echo 'No connections were established.';
            return;
        }
        for($i = 0; $i < count($this->sockets); $i+=2) {
            echo 'closing socket to '.$this->sockets[$i].' / '.$this->sockets[$i+1]."\n";
            if(!$this->debug)
                usleep(rand(100000,200000));
            echo 'freeing system resources...';
            if(!$this->debug)
                usleep(rand(1200000,1500000));
            echo 'done'."\n";
        }
    }



    /**
    @brief fakes a network upload/download operation
    */
    public function networkFileOperation($filename,$operation = 'downloading') {
        $size = rand(2000,8000);
        $speed = rand(2000,3000);
        $remaining = $size;
        $temp = $filename;
        echo $operation.' file '.$temp.' ('.rand(0,64).'/'.$size.') @ '.$speed.' kbps'."\n";
        while(true) {
            if($remaining > $speed) {
                if(!$this->debug)
                    usleep(1000000);
            } else {
                if(!$this->debug)
                    usleep(1000000*$remaining/$size);
                break;
            }
            $remaining -= $speed;
            echo '   ('.($size-$remaining).'/'.$size.')'."\n";
        }
        echo "\t".'DONE'."\n";
    }
    public static function IPPair() {
        return DataGenerator::ipv4().' '.DataGenerator::ipv6();
    }
}

$nio = new NetworkOperation();
//$nio->debug = true;
//$nio->debug = true;
//$nio->download();
//$nio->checkHash();
//$nio->send();
$nio->run();
?>