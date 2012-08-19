<?php

$counter = 0;

while ($counter < 100) {
   $foo = null;
   if($counter%3 == 0){
        $foo .= "fizz";
   }
   if($counter%5 == 0){
        $foo .= "buzz";
   }
   if($foo != null){
        echo $foo;
   }
   else{
   	    echo $counter;
   }
   echo '
';
   $counter++;
}

?>