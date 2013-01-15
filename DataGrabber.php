<?

class DataGrabber {

    /*
        static function grab($filename)
        {
            $lines = 0;
            $file = fopen($filename,'r');
            while($line = fgets($file))
            {
                $lines++;
            }
            fclose($file);
            $randindex = array();
            for($i = 0; $i != 10; $i++)
            {
                $randindex[] = rand(0,$lines);
            }
            $file = fopen($filename,'r');
            $returnarray = array();
            $linecount = 0;
    var_dump($randindex);
    while($line = fgets($file,10000000))
            {
                if(in_array($linecount,$randindex))
                {
                    $returnarray[] = trim($line);
                }
    $linecount++;
            }
            return $returnarray;
        }
    */

    public static function grab($filename) {
        $file = fopen($filename,'r');
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