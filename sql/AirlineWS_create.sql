-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2015-12-02 04:12:40.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS airline_ws;
CREATE DATABASE airline_ws CHARACTER SET utf8 COLLATE utf8_general_ci;
USE airline_ws;

-- tables
-- Table airlines
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE airlines (
    id varchar(10)  NOT NULL,
    name varchar(45)  NOT NULL,
    website varchar(45)  NOT NULL,
    CONSTRAINT airlines_pk PRIMARY KEY (id)
)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Table contracts
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE contracts (
    id int  NOT NULL AUTO_INCREMENT,
    flight_id varchar(20)  NOT NULL,
    customer_id_number varchar(45)  NOT NULL,
    company_name varchar(45)  NOT NULL,
    company_phone varchar(45)  NOT NULL,
    company_address varchar(45)  NULL,
    booking_seats int  NOT NULL,
    payment_method varchar(45)  NOT NULL,
    total_money int  NOT NULL,
    CONSTRAINT contracts_pk PRIMARY KEY (id)
)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Table flights
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE flights (
    id varchar(20)  NOT NULL,
    airline_id varchar(10)  NOT NULL,
    start_time time  NOT NULL,
    end_time time  NOT NULL,
    starting_point varchar(45)  NOT NULL,
    destination varchar(45)  NOT NULL,
    total_seats int  NOT NULL,
    available_seats int NOT NULL,
    cost int  NOT NULL,
    CONSTRAINT flights_pk PRIMARY KEY (id)
)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;





-- foreign keys
-- Reference:  contract_flight (table: contracts)


ALTER TABLE contracts ADD CONSTRAINT contract_flight FOREIGN KEY contract_flight (flight_id)
    REFERENCES flights (id);
-- Reference:  flight_airline (table: flights)


ALTER TABLE flights ADD CONSTRAINT flight_airline FOREIGN KEY flight_airline (airline_id)
    REFERENCES airlines (id);



-- End of file.

