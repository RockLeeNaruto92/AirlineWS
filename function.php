<?php
require_once "config/database.php";

function isEmpty($variable){
  return $variable == NULL || strlen($variable) == 0;
}

function isValidTimeFormat($time){
  return strtotime($time) != NULL;
}

// OK
function addNewAirlineAgency($code = NULL, $name = NULL, $website = NULL){
  if ($name == NULL || strlen($name) == 0)
    return 1; // "error_message" => "Name is not present.";
  if ($website == NULL || strlen($name) == 0)
    return 2; // "error_message" => "Website is not present."
  if ($code == NULL || strlen($code) == 0)
    return 3; // "error_message" => "ID is not present."

  $db = new DatabaseConfig;
  // Check code exist?
  if ($db->existed("airlines", "id", $code)){
    unset($db);
    return 4; // "error_message" => "ID is existed.")
  }

  $query = "INSERT INTO airlines(id, name, website) VALUES ('" . $code . "', '" . $name . "', '" . $website . "')";
  $result = $db->query($query);
  unset($db);

  if($result) return -1; // ok
  else return 0; // "error_message" => "Error on interact with database."
}

// OK
function addNewFlight($id = NULL, $airline_id = NULL, $start_time = NULL, $end_time = NULL,
  $starting_point = NULL, $destination = NULL, $total_seats = NULL, $cost = NULL){

  // check start_time
  if (isEmpty($start_time)) return 4; // "error_message" => "Start time is not present."
  if (!isValidTimeFormat($start_time)) return 5; // "error_message" => "Start time have invalid format."

  // check end_time
  if (isEmpty($end_time)) return 6; // "error_message" => "End time is not present."
  if (!isValidTimeFormat($end_time)) return 7; // "error_message" => "End time have invalid format."

  // check starting_point
  if (isEmpty($starting_point)) return 8; // "error_message" => "Starting point is not present."

  // check destination
  if (isEmpty($destination)) return 9; // "error_message" => "Destination is not present."

  // check total_seats
  if ($total_seats == 0) return 10; // "error_message" => "Total seats is 0."

  // check cost
  if ($cost == 0) return 11; // "error_message" => "Cost is 0."

  // check airline is existed?
  if (isEmpty($airline_id)) return 0; // "error_message" => "Airline id is not present."
  $db = new DatabaseConfig;
  if (!$db->existed("airlines", "id", $airline_id)){
    unset($db);
    return 1; // "error_message" => "Airline id is not existed."
  }

  // check id
  if (isEmpty($id)){
    unset($db);
    return 2; // "error_message" => "Flight is not present."
  }
  if ($db->existed("flights", "id", $id)){
    unset($db);
    return 3; // "error_message" => "Flight is existed."
  }

  // When all check is ok
  $query = "INSERT INTO flights(id, airline_id, start_time, end_time, starting_point, destination, total_seats, available_seats, cost)";
  $query .= "VALUES('$id', '$airline_id', '$start_time', '$end_time', '$starting_point', '$destination', $total_seats, $total_seats, $cost)";

  $result = $db->query($query);
  unset($db);
  if ($result) return -1; // OK
  else return 12; // "error_message" => "Error on execution query."
}

// ok
function isFlightExisted($id = NULL){
  if (isEmpty($id)) return 0; // "error_message" => "Id is not present."

  $db = new DatabaseConfig;
  $existed = $db->existed("flights", "id", $id);
  unset($db);
  if ($existed) return -1; // OK
  else return 1; // "error_message" => "ID is not existed in database"
}

// ok
function findFlight($id = NULL){
  if (isEmpty($id)) return "Id is not present"; // "error_message" => "Id is not present."

  $db = new DatabaseConfig;
  $query = "SELECT * FROM flights WHERE id = '$id'";
  $result = $db->query($query);
  unset($db);

  if (mysql_num_rows($result) == 0) return "Id is not existed in database"; // "error_message" => "Id is not existed in database"
  else {
    $row = mysql_fetch_array($result);
    $data = array();

    foreach (DatabaseConfig::$FLIGHTS as $flight)
      $data[$flight] = $row[$flight];

    return json_encode($data); // OK
  }
}

// ok
function addNewContract($flight_id = NULL, $customer_id_number = NULL,
  $company_name = NULL, $company_phone = NULL, $company_address = NULL,
  $booking_seats = 0, $payment_method = NULL){
  // Check customer_id_number
  if (isEmpty($customer_id_number)) return 0; // "error_message" => "Customer id number is not present"

  // Check company_name
  if (isEmpty($company_name)) return 1; // "error_message" => "Company name is not present"

  // Check company_phone
  if (isEmpty($company_phone)) return 2; // "error_message" => "Company phone is not present"

  // Check booking seats
  if ($booking_seats == 0) return 3; // "error_message" => "Booking seats number must be greater than 0"

  // Check payment method
  if (isEmpty($payment_method)) return 4; // "error_message" => "Payment method is not present"

  // Check flight_id
  if (isEmpty($flight_id)) return 5; // "error_message" => "Flight id is not present"

  $db = new DatabaseConfig;
  $result = $db->existed("flights", "id", $flight_id);
  if (!$result){
    unset($db);
    return 6; // "error_message" => "Flight id is not existed in databse"
  }

  // Check booking_seat is available
  if ($result["available_seats"] < $booking_seats){
    unset($db);
    return 7; // "error_message" => "Availabe seats is not enough"
  }
  $available_seats = $result["available_seats"] - $booking_seats;
  $total_money = $booking_seats * $result["cost"];

  $query = "INSERT INTO contracts(flight_id, customer_id_number, company_name, company_phone, company_address, booking_seats, payment_method, total_money)";
  $query .= "VALUES('$flight_id', '$customer_id_number', '$company_name', '$company_phone', '$company_address', '$booking_seats', '$payment_method', '$total_money')";

  $result = $db->query($query);
  if (!$result){
    unset($db);
    return 8; // "error_message" => "Error on execution query"
  }

  $query = "UPDATE flights SET available_seats = $available_seats WHERE id = '$flight_id'";
  $result = $db->query($query);
  unset($db);

  if ($result) return -1; // OK
  else return 8; // "error_message" => "Error on execution query"
}

// checking
function checkSeatAvailable($flight_id = NULL){
  if (isEmpty($flight_id)) return 0; // "error_message" => "Flight id is not present"

  $db = new DatabaseConfig;
  $result = $db->existed("flights", "id", $flight_id);
  unset($db);

  if (!$result) return 1; // "error_message" => "Flight id is not existed in database"
  return -1; // OK
}
?>
