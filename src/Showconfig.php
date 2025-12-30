 <?php
class Showconfig
 {
   function __construct()
   {
      $cfg = json_decode(file_get_contents(CONFIG_FILE),true);
      
      echo "Attributo:valor <hr>";
      foreach ($cfg as $k => $v) {
        echo trim( $k ).":".trim( (string) $v )."<br>";
      } 
   }  
 }