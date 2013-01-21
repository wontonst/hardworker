<?

class DataGrabber {
    public static function grab($filename) {
        $file = fopen('res/'.$filename,'r');
        $lines = trim(fgets($file));
        $lines--;
        $index = rand(0,$lines);
        $currline = 0;

        while(true) {
            $line = fgets($file);
            if($currline == $index) {
                return trim($line);
            }
            $currline++;
        }
    }

}
//var_dump(DataGrabber::grab('urls.txt'));
/*
for($i = 0; $i != 10; $i++)
{
echo DataGrabber::grab('programs.txt')."\n";
}*/

?>