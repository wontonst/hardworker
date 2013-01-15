<?

require_once('DataGrabber.php');

class DataGenerator {

    static function ipv4() {
        return (rand(1,255).'.'.rand(1,255).'.'.rand(1,255).'.'.rand(1,255));
    }
    static function ipv6() {
        return (dechex(rand(1,65535)).':'.dechex(rand(1,65535)).':'.dechex(rand(1,65535)).':'.dechex(rand(1,65535)));
    }
    static function randomString() {
        $file ='';
        $size = rand(4,10);
        for($i = 0; $i != $size; $i++) {
            $char = rand(48,107);
            if($char > 82) {
                $char += 14;
            } else if($char >57) {
                $char += 7;
            }
            $file.=chr($char);
        }
        return $file;
    }
    public static function randomArchive() {
        $file ='';
        $rand = rand(0,3);
        switch($rand) {
        case 0:
            $file.='.rar';
            break;
        case 1:
            $file.='.zip';
            break;
        case 2:
            $file.='.tar.gz';
            break;
        case 3:
            $file.='.7z';
            break;
        }
        return $file;
    }
    public static function randomPicture() {
        $file ='';
        $rand = rand(0,3);
        switch($rand) {
        case 0:
            $file.='.jpg';
            break;
        case 1:
            $file.='.png';
            break;
        case 2:
            $file.='.tiff';
            break;
        case 3:
            $file.='.bmp';
            break;
        }
        return $file;

    }
    public static function randomVideo() {
        $file ='';
        $rand = rand(0,2);
        switch($rand) {
        case 0:
            $file.='.mpg';
            break;
        case 1:
            $file.='.wmv';
            break;
        case 2:
            $file.='.avi';
            break;
        }
        return $file;

    }
    public static function randomAudio() {
        $file ='';
        $rand = rand(0,4);
        switch($rand) {
        case 0:
            $file.='.mp3';
            break;
        case 1:
            $file.='.m4a';
            break;
        case 2:
            $file.='.flac';
            break;
        case 3:
            $file.='.ogg';
            break;
        case 4:
            $file .='.wav';
            break;
        }
        return $file;

    }
    public static function randomSource() {
        $file='';
        $rand = rand(0,4);
        switch($rand) {
        case 0:
            $file.='.java';
            break;
        case 1:
            $file.='.c';
            break;
        case 2:
            $file.='.cpp';
            break;
        case 3:
            $file.='.php';
            break;
        case 4:
            $file .='.pl';
            break;
        }
        return $file;

    }
    public static function randomFile() {
        switch(rand(0,3)) {
        case 0:
            return DataGenerator::randomString().DataGenerator::randomArchive();
        case 1:
            return DataGenerator::randomString().DataGenerator::randomPicture();
        case 2:
            return DataGenerator::randomString().DataGenerator::randomSource();
        case 3:
            return DataGenerator::randomString().DataGenerator::randomVideo();
        }
    }
    public static function url() {
        $file = (rand(0,1) == 0) ? 'https://' : 'http://';
        if(rand(0,1) == 0) $file .= 'www.';

        if(rand(0,1) == 0) { //add subdomain
            switch(rand(0,4)) {
            case 0:
                $file.='mail.';
                break;
            case 1:
                $file.='data.';
                break;
            case 2:
                $file.='img.';
                break;
            case 3:
                $file.='quotes.';
                break;
            case 4:
                $file.='security.';
                break;
            }
        }
        $file .= DataGrabber::grab('urls.txt');
        switch(rand(0,4)) {
        case 0:
        case 1:
            $file .='.com';
            break;
        case 2:
            $file .='.net';
            break;
        case 3:
            $file .='.edu';
            break;
        case 4:
            $file .='.co';
            break;
        }
        return $file;
    }
    public static function directoryPath() {
        $path ='';
        switch(rand(0,2)) {
        case 0:
            $path .= '/home/';
            $path.=DataGrabber::grab('usrnames.txt').'/';
            break;
        case 1:
            $path .= '/bin/';
            $path .=DataGrabber::grab('programs.txt').'/';
            break;
        case 2:
            $path .='/etc/';
            $path .= (rand(0,1) == 0) ? DataGrabber::grab('programs.txt') : DataGrabber::grab('usrnames.txt');
            $path .='/';
            break;
        }
        for($i = rand(0,2); $i != 2; $i++) {
            $path .=DataGrabber::grab('directory.txt').'/';
        }
        return $path;
    }
    public static function capitalLetter() {
        return chr(rand(65,90));
    }
}


/*
for($i = 0; $i != 10; $i++)
{
    echo DataGenerator::randomFile()."\n";
}*/

?>