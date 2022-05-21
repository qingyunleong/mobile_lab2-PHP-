<?php
if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}

include_once("dbconnect.php");

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$password = sha1($_POST['password']);
$otp = rand(10000, 99999);
$encoded_string = $_POST['image'];

$sqlinsert = "INSERT INTO tbl_users (user_email,user_name,user_password,user_phone,user_address,otp) VALUES('$email','$name','$password','$phone','$address',$otp)";

if ($conn->query($sqlinsert) === TRUE) {
    $response = array('status' => 'success', 'data' => null);
    $decoded_string = base64_decode($encoded_string);
    $filename = mysqli_insert_id($conn);
    $path = '../images/profile/' . $filename . '.png';
    $is_written = file_put_contents($path, $decoded_string);

    sendEmail($email);
    sendJsonResponse($response);
} else {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
}

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

function sendEmail($email)
{
    //send email function here
}
?>
