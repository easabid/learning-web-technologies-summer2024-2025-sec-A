<?php
// ---- Declare the exact 2D array shown ----
$arr = [
    [1, 2, 3, 'A'],
    [1, 2, 'B', 'C'],
    [1, 'D', 'E', 'F']
];

// Compute max columns to render a 3x4 grid for the left panel
$maxCols = 0;
foreach ($arr as $r) { $maxCols = max($maxCols, count($r)); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<style>
  body{font-family: Arial, sans-serif;}
  .outer{border-collapse: collapse; margin: 12px 0;}
  .outer, .outer th, .outer td{border:1px solid #000;}
  .outer th, .outer td{padding:10px; vertical-align: top;}

  .decl{border-collapse: collapse; margin: 4px 0;}
  .decl td{border:1px solid #000; padding:8px 12px; text-align:center; min-width:28px}

  .shapes-box{background:#eee; padding:10px;}
  .shapes-table{border-collapse: collapse;}
  .shapes-table td{vertical-align: top; padding:4px 12px;}
  .line{white-space: nowrap;}
</style>
</head>
<body>


<table class="outer">
  <tr>
    <th>The array to declare</th>
    <th>Shapes to print</th>
  </tr>
  <tr>
    <!-- Left grey box -->
    <td>
      <table class="decl">
        <?php for ($i = 0; $i < count($arr); $i++): ?>
          <tr>
            <?php for ($j = 0; $j < $maxCols; $j++): ?>
              <td><?php echo isset($arr[$i][$j]) ? $arr[$i][$j] : '&nbsp;'; ?></td>
            <?php endfor; ?>
          </tr>
        <?php endfor; ?>
      </table>
    </td>

    <!-- Right grey box  -->
    <td>
      <div class="shapes-box">
        <table class="shapes-table">
          <tr>
            <td>
              <?php
              for ($i = 0; $i < count($arr); $i++) {
                  $line = [];
                  for ($j = 0; $j < count($arr[$i]); $j++) {
                      // stop the row when we hit a non-integer (to match 1 2 3 / 12 / 1)
                      if (isset($arr[$i][$j]) && is_int($arr[$i][$j])) {
                          $line[] = $arr[$i][$j];
                      } else {
                          break;
                      }
                  }
                  echo '<div class="line">'.implode(' ', $line).'</div>';
              }
              ?>
            </td>

            <!-- Letters -->
            <td>
              <?php
              for ($i = 0; $i < count($arr); $i++) {
                  $line = [];
                  for ($j = 0; $j < count($arr[$i]); $j++) {
                      if (isset($arr[$i][$j]) && is_string($arr[$i][$j])) {
                          $line[] = $arr[$i][$j];
                      }
                  }
                  echo '<div class="line">'.implode(' ', $line).'</div>';
              }
              ?>
            </td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
</table>

</body>
</html>
