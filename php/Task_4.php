<?php
   $a = 12;
   $b = 25;
   $c = 7;

   if($a >= $b && $a >= $c){
       echo "Largest number is: ".$a;
   }else if($b >= $a && $b >= $c){
       echo "Largest number is: ".$b;
   }else{
       echo "Largest number is: ".$c;
   }
?>
