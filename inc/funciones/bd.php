<?php
//credenciales de la vase de datos 
//! error pendejo ignorar
define("DB_USUARIO", "root");
define("DB_PASSSWORD", "root");
//en una empresa se usa la ip
define("DB_HOST", "localhost");
define("DB_NAME", "agendaphp");
define("DB_PUERTO", 3306);



//Toma 4 paremetros obligatoris y uno opcional, en las constantes se accede sn comillas ni el de dinerito 
//echo $conn->ping();
//!quinto es el puerto de msql
$conn = new mysqli(DB_HOST, DB_USUARIO, DB_PASSSWORD, DB_NAME, DB_PUERTO);
//para saber si hubo coneccion con la base de datos uno es que si 0 es igual a la cagaste (o no sale nada )
