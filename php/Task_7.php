<?php

echo "<table border='1' cellpadding='10' cellspacing='0'>";

// Pattern 1 (Stars) 
echo "<tr><td>";
for($i=1; $i<=3; $i++){
    for($j=1; $j<=$i; $j++){
        echo "* ";
    }
    echo "<br>";
}
echo "</td>";

// Pattern 2 (Numbers)
echo "<td>";
for($i=3; $i>=1; $i--){
    for($j=1; $j<=$i; $j++){
        echo $j." ";
    }
    echo "<br>";
}
echo "</td>";

// Pattern 3 (Letters)
echo "<td>";
$ch = 'A';
for($i=1; $i<=3; $i++){
    for($j=1; $j<=$i; $j++){
        echo $ch." ";
        $ch++;
    }
    echo "<br>";
}
echo "</td></tr>";
echo "</table>";
?>
