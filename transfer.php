<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bank Services</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">    
  <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
  <h2 align="center">Transaction Successful!!
    <br><br><br>
    <a href="index.html"><--Go Back Home</a>
    
  </h2>
</body>
</html>
  
<?php
session_start();
$server="localhost";
$username="root";
$password="";
$con=mysqli_connect($server,$username,$password,"qxp");
if(!$con){
    die("Connection failed");
} 


$flag=false;

if (isset($_POST['transfer']))
{
$sender=$_SESSION['sender'];
$receiver=$_POST["reciever"];
$amount=$_POST["amount"];}

$sql = "SELECT Balance FROM customer WHERE name='$sender'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
 if($amount>$row["Balance"] or $row["Balance"]-$amount<100){
    echo "<script>swal( 'Transaction Denied','Insufficient Balance!','error' ).then(function() { window. location = 'view.php'; });;</script>";
   
 }
else{
    $sql = "UPDATE `customer` SET Balance=(Balance-$amount) WHERE Name='$sender'";
    

if ($con->query($sql) === TRUE) {
  $flag=true;
} else {
  echo "Error in updating record: " . $conn->error;
}
 }
 
  }
} else {
  echo "0 results";
} 

if($flag==true){
$sql = "UPDATE `customer` SET Balance=(Balance+$amount) WHERE name='$receiver'";

if ($con->query($sql) === TRUE) {
  $flag=true;  
  
} else {
  echo "Error in updating record: " . $con->error;
}
}
if($flag==true){
    $sql = "SELECT * from customer where name='$sender'";
    $result = $con-> query($sql);
    while($row = $result->fetch_assoc())
     {
         $s_acc=$row['Acc_Number'];
 }
 $sql = "SELECT * from customer where name='$receiver'";
 $result = $con-> query($sql);
while($row = $result->fetch_assoc())
  {
      $r_acc=$row['Acc_Number'];
}        
$sql = "INSERT INTO `transfer`(s_name,s_acc_no,r_name,r_acc_no,amount) VALUES ('$sender','$s_acc','$receiver','$r_acc','$amount')";
if ($con->query($sql) === TRUE) {
} else 
{
  echo "Error updating record: " . $con->error;
}
}

if($flag==true){
echo "<script>swal('Money sent', 'Your transaction was successful','success').then(function() { window. location = 'View.php'; });;</script>";
}
elseif($flag==false)
{
    echo "<script>
        $('#text2').show()
     </script>";
}
?>