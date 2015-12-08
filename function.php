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
  $query = "INSERT INTO flights(id, airline_id, start_time, end_time, starting_point, destination, total_seats, cost)";
  $query .= "VALUES('$id', '$airline_id', '$start_time', '$end_time', '$starting_point', '$destination', $total_seats, $cost)";

  $result = $db->query($query);
  unset($db);
  if ($result) return -1; // OK
  else return 12; // "error_message" => "Error on execution query."
}

// checking
function isFlightExisted($id = NULL){
  if (isEmpty($id)) return 0; // "error_message" => "Id is not present."

  $db = new DatabaseConfig;
  $existed = $db->existed("flights", "id", $id);
  unset($db);
  if ($existed) return -1; // OK
  else return 1; // "error_message" => "ID is not existed in database"
}
?>
