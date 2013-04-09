<?php
$row = 1;

$files = 100;
$titles = array('frame.number','frame.time_relative','frame.time_delta','frame.len','ipv6.src','ipv6.dst','ipv6.plen','tcp.len','tcp.seq','tcp.ack','tcp.flags','tcp.flags.syn','tcp.flags.ack','tcp.flags.reset','tcp.flags.urg','tcp.flags.push','tcp.flags.fin','tcp','icmpv6.nd.ns.target_address','icmpv6.nd.na.target_address');
$summary = array(0 => $titles); //this will create the summary sheet

//columns to get average values for
$avgCols = array(1,2,3,6,7); 
//columns to get sum values for
$sumCols = array(13);

//columns to get straight value for (will overide previos row)
$keepCols = array(4, 5,17,18, 19);

//fill the summary with 20 cols X 50 rows of 0's
for($i = 1; $i < 50; $i++){
    $summary[$i][0] = $i; 
    for($y = 1; $y < 20; $y++) {
       $summary[$i][$y] = 0; 
    }
}

for($i = 0; $i < $files; $i++)
{
    $tmp = $i;
    $tmp++;
    $fname = $tmp . ".csv";
    
    $thisSum = array();
    
    if (($handle = fopen($fname, "r")) !== FALSE) {
        $count = 0;
        $row = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          if($count != 0) {
                $num = count($data);
             
                for ($c=1; $c <= $num; $c++) {
                   
                   //if($c == 1 || $c == 2) {
                   if(in_array($c, $avgCols) || in_array($c, $sumCols)) {
                        $val = floatval($data[$c]);
                        $summary[$row][$c] += $val;
                    
                   }
                   
                   if(in_array($c, $keepCols)) {
                        $summary[$row][$c] = $data[$c];
                   }
                }
               
            }
            $count++;
            $row++;
        }
        fclose($handle);
        //print_r($thisSum);
        //$summary[$i] = $thisSum;
        $row = 0;
        $count = 0;
        $num = 0;
        //echo "\n";
        
    }
}

/* 
    get the average for each field
*/

for($i = 0; $i < 50; $i++){
    for($y = 0; $y < 20; $y++) {
      if($i != 0 && $y != 0) {
        if(in_array($y, $avgCols)) {
            $summary[$i][$y] = ($summary[$i][$y] / $files);
        }
      }  
    }
}


$fp = fopen('summary.csv', 'w');

foreach ($summary as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);
echo "Done\n";
?>
