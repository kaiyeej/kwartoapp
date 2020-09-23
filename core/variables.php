<?php
/** Core Path **/
define("view","pages/");


/** Database connection **/

define("host","localhost");
define("username","u841218770_kwartoapp");
define("password","kwartoApp12345!");
define("database","u841218770_kwarto_app");
/** Auth **/

/*define("host","localhost");
define("username","root");
define("password","");
define("database","hotels");*/

define("table","tbl_users");
define("user_session_id","user_id");
define("hotel_session_id","hotel_id");
define("user_type_session_id","user_type");
define("passwordHashing",true); 
define("error_message","Your Credentials did not matched");

/** Function / Classes **/
 
//inside dir
define ("VALUE",serialize (array ("auth.php","my_functions.php")));
?>