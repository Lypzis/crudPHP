<?php
// INIT
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "2a-config.php";
require PATH_LIB . "2b-lib-address.php";
$abLib = new Address();
$pass = true;
$message = "";
$data = null;

// HANDLE AJAX REQUEST
// makes server side ready to process user requests
// - User requests will be posted vi AJAX to this script
// - It is nothing but a simple script to accept and process CRUD actions on the address book database.
// - $_POST['req'] will be sent to this process script, followed by the required parameters.
// For example, to create a new address book entry we have to post a $_POST['rea']="create",
// followed by $_POST['address']="Somewhere".
if (isset($_POST['req'])) { switch ($_POST['req']) {
  default:
    $pass = false;
    $message = "Invalid Request";
    break;

  case "create":
    $pass = $abLib->create($_POST['address']);
    $message = $pass ? "Entry Created" : $abLib->error;
    break;

  case "read":
    $pass = true;
    $data = $abLib->read();
    break;

  case "update":
    $pass = $abLib->update($_POST['address'], $_POST['id']);
    $message = $pass ? "Entry Updated" : $abLib->error;
    break;

  case "delete":
    $pass = $abLib->delete($_POST['id']);
    $message = $pass ? "Entry Deleted" : $abLib->error;
    break;
}}

// SERVER RESPONSE
// The server will return a JSON encoded response array as follow:
// - Status: the status of the process.
// - Message: the system message, if any.
// - Data: The requested data, an address book entry, for example.
echo json_encode([
  "status" => $pass,
  "message" => $message,
  "data" => $data
]);
?>