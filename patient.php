
<?php
 /*



define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "android_api");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if(mysqli_connect_errno()){
    die ('unable to connect to database'. mysqli_connect_error());

}

$stmt = $conn-> prepare ("SELECT id, title, shortdesc, rating,price, image FROM products;" );
$stmt->execute();
$stmt->bind_result($id,$title,$shortdesc, $rating, $price, $image);

$product = array();

while($stmt->fetch()){
    $temp = array();
    $temp['id'] = $id;
    $temp['title'] = $title;
    $temp['shortdesc'] = $shortdesc;
    $temp['rating'] = $rating;
    $temp['image'] = $image;
array_push($product, $temp);
}
echo json_encode($product);
*/
define('DB_HOST', 'localhost');
//define('DB_USER', 'gobookco_android');
//define('DB_PASS', 'android');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'homeo_plus');
 
 //connecting to database and getting the connection object
 $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
 
 //Checking if any error occured while connecting
 if (mysqli_connect_errno()) {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 die();
 }
 else{
    //require_once 'DbConnect.php';
    //echo 'successful';
 }
 
 //creating a query
 //$stmt = $conn->prepare("SELECT order_product_id, order_id, product_id, name, model,quantity,price,total,tax,reward FROM oc27_order_product;");
 $stmt = $conn->prepare("SELECT first_Name FROM user;");
 //executing the query 
 $stmt->execute();
 
 //binding results to the query 
 $stmt->bind_result( $userName);
 $stmt->bind_result( $id);
 
 $product_name = array();
 
 //traversing through all the result 
 while($stmt->fetch()){
 $temp = array();
 $temp['user_Name'] = $userName; 
 $temp['id'] = $id; 
 /*$temp['model'] = $model; 
 $temp['quantity'] = $quantity; 
 $temp['price'] = $price; 
 $temp['total'] = $total; 
 $temp['tax'] = $tax; 
 $temp['reward'] = $reward; 
 $order_product_id, $order_id, $product_id, , $model, $quantity, $price, $total, $tax, $reward
 */
 array_push( $product_name, $temp);
 }
 //displaying the result in json format 
 $output = json_encode(['keys'=> $product_name]);
 echo $output;
?>