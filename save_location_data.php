<?php
require('connection.php');


$label = mysqli_real_escape_string($con, $_POST['locationName']);
$latitude = mysqli_real_escape_string($con, $_POST['lat']);
$longitude = mysqli_real_escape_string($con, $_POST['lng']);
date_default_timezone_set('Asia/Yangon');
$added_on = date('Y-m-d h:i:s');

$res = mysqli_query($con, "SELECT * FROM `location_data` WHERE `label`='$label'");
$check = mysqli_num_rows($res);

if ($check > 0) {
    // Use a unique identifier like ID for updating
    mysqli_query($con, "UPDATE `location_data` SET `lat`='$latitude',`long`='$longitude',`date`='$added_on' WHERE `label`='$label'");
    echo "$label ,တပ်တည်နေရာပြင်ဆင်ခြင်းအောင်မြင်ပါသည်";
} else {
    mysqli_query($con, "INSERT INTO `location_data`( `label`, `lat`, `long`, `date`) VALUES ('$label','$latitude','$longitude','$added_on')");
    echo "$label ,တပ်တည်နေရာထည့်သွင်းခြင်းအောင်မြင်ပါသည်";
  
     // Remove spaces between characters in $label
     $label = str_replace(' ', '', $label);

     // Append the new data to the existing CSV file
     $filePath = __DIR__ . '/model.csv';
     $handle = fopen($filePath, 'a');
     $datafilePath = __DIR__ . '/map_data.csv';
     $datahandle = fopen($datafilePath, 'a');
 
     if ($handle === false) {
         die("Unable to open the file: $filePath");
     }
     if ($datahandle === false) {
        die("Unable to open the file: $filePath");
    }

     // Write the new data to the file
     fwrite($handle, "$label ရဲ့,တည်နေရာကို,-,ရှာပေး\n");
     fwrite($handle, "$label,တည်နေရာကို,-,ရှာပေး\n");
     fwrite($handle, "$label ရဲ့,နေရာကို,-,ရှာပေး\n");
     fwrite($handle, "$label,နေရာကို,-,ရှာပေး\n");
     fwrite($handle, "$label ရဲ့,နေရာ,-,ရှာပေး\n");
     fwrite($handle, "$label,နေရာ,-,ရှာပေး\n");
     fwrite($handle, "$label ရဲ့,နေရာ,-,ပြပေး\n");
     fwrite($handle, "$label ,နေရာ,-,ပြပေး\n");
     fwrite($handle, "$label ရဲ့,နေရာကို,-,ပြပေး\n");
     fwrite($handle, "$label ,နေရာကို,-,ပြပေး\n");
     fwrite($handle, "$label ကို,-,-,ရှာပေး\n");
     fwrite($handle, "$label ကို,-,-,ပြပေး\n");
     fwrite($handle, "$label ကို,-,-,ပြ\n");
     fwrite($handle, "$label,-,-,ပြ\n");
     fwrite($handle, "$label,-,-,ပြပေး\n");
     fwrite($handle, "$label,-,-,ရှာပေး\n");
     fwrite($handle, "$label ကို,-,-,ရှာ\n");
     fwrite($handle, "$label,-,-,ရှာ\n");
     fwrite($handle, "$label က,-,-,ဘယ်မှာလဲ\n");
     fwrite($handle, "$label,-,-,ဘယ်မှာလဲ\n");
     fwrite($datahandle, "$label,$label\n");
 
     fclose($handle);
     fclose($datahandle);
}
?>