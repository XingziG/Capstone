<?php
/**
 * Created by PhpStorm.
 * User: xingzi
 * Date: 11/24/15
 * Time: 10:55 AM
 */

// This file contains the database access information.
// This file also establishes a connection to MySQL,
// selects the database, and sets the encoding.

// Set the database access information as constants:

DEFINE ('DB_USER', 'apple');
DEFINE ('DB_PASSWORD', 'monkey');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'forbes');

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to
MySQL: ' . mysqli_connect_error());

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');