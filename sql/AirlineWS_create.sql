-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2015-12-01 16:04:07.589


DROP airline_ws IF EXISTS;
CREATE DATABASE airline_ws;
USE airline_ws;

-- tables
-- Table airline_info
CREATE TABLE airline_info (
    airline_id varchar(10)  NOT NULL,
    airline_name varchar(45)  NOT NULL,
    airline_phone varchar(45)  NOT NULL,
    airline_website varchar(45)  NOT NULL,
    airline_email varchar(45)  NOT NULL,
    airline_type varchar(45)  NOT NULL,
    flight_info_flight_id varchar(20)  NOT NULL,
    CONSTRAINT airline_info_pk PRIMARY KEY (airline_id)
);

-- Table contract_info
CREATE TABLE contract_info (
    contract_id int  NOT NULL,
    flight_id varchar(20)  NOT NULL,
    company_name varchar(45)  NOT NULL,
    customer_cmt varchar(45)  NOT NULL,
    company_phone varchar(45)  NOT NULL,
    company_address varchar(45)  NOT NULL,
    normal_seat int  NOT NULL,
    vip_seat int  NOT NULL,
    contract_create_date date  NOT NULL,
    contract_changeable_date date  NOT NULL,
    payment_method varchar(45)  NOT NULL,
    requirement varchar(90)  NOT NULL,
    status int  NOT NULL,
    changed_count int  NOT NULL,
    total_money int  NOT NULL,
    flight_info_flight_id varchar(20)  NOT NULL,
    CONSTRAINT contract_info_pk PRIMARY KEY (contract_id)
);

-- Table flight_info
CREATE TABLE flight_info (
    flight_id varchar(20)  NOT NULL,
    airline_id varchar(10)  NOT NULL,
    flight_start_time time  NOT NULL,
    flight_end_time time  NOT NULL,
    flight_starting_point varchar(45)  NOT NULL,
    flight_destination varchar(45)  NOT NULL,
    flight_type int  NOT NULL,
    total_seat int  NOT NULL,
    normal_seat_available int  NOT NULL,
    vip_seat_avaiable int  NOT NULL,
    vip_cost int  NOT NULL,
    normal_cost int  NOT NULL,
    booking_deadline int  NOT NULL,
    flight_back_day time  NOT NULL,
    flight_start_date date  NOT NULL,
    CONSTRAINT flight_info_pk PRIMARY KEY (flight_id)
);





-- foreign keys
-- Reference:  airline_info_flight_info (table: airline_info)


ALTER TABLE airline_info ADD CONSTRAINT airline_info_flight_info FOREIGN KEY airline_info_flight_info (flight_info_flight_id)
    REFERENCES flight_info (flight_id);
-- Reference:  contract_info_flight_info (table: contract_info)


ALTER TABLE contract_info ADD CONSTRAINT contract_info_flight_info FOREIGN KEY contract_info_flight_info (flight_info_flight_id)
    REFERENCES flight_info (flight_id);



-- End of file.

