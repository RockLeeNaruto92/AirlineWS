<?php
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
?>
