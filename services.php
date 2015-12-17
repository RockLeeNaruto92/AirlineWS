<?php
ini_set('display_errors',1);
require_once "config/database.php";
require_once "lib/nusoap/nusoap.php";
require_once "function.php";

// config server's services
$server = new soap_server;
$server->configureWSDL("airlines", "urn:airlines");

// regist function
// addNewAirlineAgency
$server->register("addNewAirlineAgency",
  array("code" => "xsd:string", "name" => "xsd:string", "website" => "xsd:string"), //input params
  array("return" => "xsd:integer"), // output
  "urn:airlines", // namespace
  "urn:airlines#addNewAirlineAgency",
  "rpc",
  "encoded",
  "Add new airlines agency"
  );

// addNewFlight
$server->register("addNewFlight",
  array("id" => "xsd:string", "airline_id" => "xsd:string", "start_time" => "xsd:string", "end_time" => "xsd:string",
    "starting_point" => "xsd:string", "destination" => "xsd:string", "total_seats" => "xsd:integer", "cost" => "xsd:integer"), // input params
  array("return" => "xsd:integer"), // output
  "urn:airlines", // namespace
  "urn:airlines#addNewFlight",
  "rpc",
  "encoded",
  "Add new flight"
  );

// isFlightExisted
$server->register("isFlightExisted",
  array("id" => "xsd:string"), // input params
  array("return" => "xsd:integer"), // output
  "urn:airlines", // namespace
  "urn:airlines#isFlightExisted",
  "rpc",
  "encoded",
  "Check flight is existed or not"
  );

// findFlight
$server->register("findFlight",
  array("id" => "xsd:string"), // input params
  array("return" => "xsd:string"), // output
  "urn:airlines", // namespace
  "urn:airlines#findFlight",
  "rpc",
  "encoded",
  "Find a flight with id"
  );

// addNewContract
$server->register("addNewContract",
  array("flight_id" => "xsd:string", "customer_id_number" => "xsd:string",
    "company_name" => "xsd:string", "company_phone" => "xsd:string",
    "company_address" => "xsd:string", "booking_seats" => "xsd:integer",
    "payment_method" => "xsd:string"), // input params
  array("return" => "xsd:integer"), // output
  "urn:airlines", // namespace
  "urn:airlines#addNewContract",
  "rpc",
  "encoded",
  "Add new contract"
  );

// checkSeatAvailable
$server->register("checkSeatAvailable",
  array("id" => "xsd:string"), // input params
  array("return" => "xsd:integer"), // output
  "urn:airlines", // namespace
  "urn:airlines#checkSeatAvailable",
  "rpc",
  "encoded",
  "Check a flight with flight_id have available seats or not"
  );

// getAllFlights
$server->register("getAllFlights",
  array(), // input params
  array("return" => "xsd:string"), // output
  "urn:airlines", // namespace
  "urn:airlines#getAllFlights",
  "rpc",
  "encoded",
  "Get all flights"
  );
// deploy services
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";
$server->service($HTTP_RAW_POST_DATA);
?>
