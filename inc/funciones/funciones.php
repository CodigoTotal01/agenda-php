<?php


function obtenerContactos(){
    include "bd.php";
//? concha 

    try {
        //realizando consulta
        return $conn->query("SELECT idcontactos, nombre, empresa, telefono FROM contactos"); //* si encuentra resultado biene como true 
        //de igual manera ya nso entrega el ocntenido de este es devcir solo basta con iterarlo y ya 
    } catch (Exception $th) {
        echo "Error! ". $th->getMessage();
        //si hay un eror que no haga nada 
        return false;
    }
}

//! Remenber, ajax permite el evitar actualizar la pagina par amostrar los  datos 

//* OBTIENE CONTACTO ATRVES DEL ID 

function obtenerContacto($id){
    include "bd.php";
//? concha 

    try {
        return $conn->query("SELECT idcontactos, nombre, empresa, telefono FROM contactos WHERE idcontactos = $id");
    } catch (Exception $th) {
        echo "Error! ". $th->getMessage();
      
        return false;
    }
}