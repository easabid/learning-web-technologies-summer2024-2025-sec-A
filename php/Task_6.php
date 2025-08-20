// <?php
//    $arr = [10, 20, 30, 40, 50];
//    $search = 30;
//    $found = false;

//    foreach($arr as $val){
//        if($val == $search){
//            $found = true;
//            break;
//        }
//    }

//    if($found){
//        echo $search." found in array";
//    }else{
//        echo $search." not found in array";
//    }
// ?>

<?php
   $arr = [10, 20, 30, 40, 50];
   $search = 30;
   $found = false;

   for($i=0; $i<count($arr); $i++){
       if($arr[$i] == $search){
           $found = true;
           break;
       }
   }

   if($found){
       echo $search." found in array";
   }else{
       echo $search." not found in array";
   }
?>
