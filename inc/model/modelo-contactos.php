<?php
//!Es porque la carga inicial de la pagina se habra hecho por GET por lo que no hay nada en POST hasta no enviar el formulario encapsula el bloque donde queres mostrar las variables de esta forma

// tambien podemso usar ($_SERVER["REQUEST_METHOD"] == "POST")
if ($_POST) {
    if ($_POST["accion"] == "crear") {
        //Creara un nuevo registro en la base de datos 

        //* eCHO RETORNA AL AP JS ES COMO SU RETURN POr lo uqe a mi tespexta atraves del post estamos enbiando los datos, pero como que  uingnora todo el codigo y solo le importa lo que muestran los echo  
        require_once("../funciones/bd.php");

        $nombre = filter_var(htmlspecialchars($_POST["nombre"]));
        $empresa = filter_var(htmlspecialchars($_POST["empresa"]));
        $telefono = filter_var(htmlspecialchars($_POST["telefono"]));
        try {
            //funcioens pareparadas/ le que tiene auto increment se ignora  --> los raritos los llamamds place holdes 
            $stmt = $conn->prepare("INSERT INTO contactos (nombre, empresa, telefono) VALUES (?, ? , ?)");
            //bind param ponemos los datos que se van a insertar, son en base al tipo de dat que almacenen en la base de datos ya sea de las variables y de la base de datos (esto ultimo peude ser faclacia9)
            $stmt->bind_param("sss", $nombre, $empresa, $telefono);

            //ejecutamos la funcion preparada 
            $stmt->execute();

            //* Para saber si se a realizado algun cmabio de un registro en la tabla de la base de datos 

            if ($stmt->affected_rows == 1) {
                $respuesta = array(
                    "respuesta" => "correcto",
                    //! Devuelve el id autogenerado que se utilizó en la última consulta

                    "datos" => array(
                        "nombre" => $nombre,
                        "empresa" => $empresa,
                        "telefono" => $telefono,
                        "id_insertado" => $stmt->insert_id,
                    )
                );
            }

            //cerar la fncion rpreparada y la conexion con la base  de datos 
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            //throw $th;
            $respuesta = array(
                'error' => $e->getMessage()
            );
        }
        echo json_encode($respuesta);
    }
}


// cuando se envie por xml por la url leugo reseviremos la respuesta

if ($_GET) {
    if ($_GET["accion"] == "borrar") {

        //Eliminando contactos de la base de datos 
        require_once("../funciones/bd.php");
        $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);

        try {
            //!Eliminar elelemento de labase de datos ---> DELETE AND UPDATE SIEMPRE EL WERE PORQUE SI NO SE PERDERAN DOOS LOS REGISTROS 
            //? sentencias preparadas, preparar consulta en la base de datos, la coneeccion de labase de datos ya se hizo 
            $stmt = $conn->prepare("DELETE FROM contactos WHERE idcontactos = ? ");
            $stmt->bind_param("i", $id);
            $stmt->execute(); // realiza la consulta a la base de datos 



            //? si es que hubo un cambio en la tabla de neustra base de datos 
            if ($stmt->affected_rows == 1) {
                $respuesta = array(
                    "respuesta" => "correcto"
                );
            }
            $stmt->close();
            $conn->close();
        } catch (\Throwable $th) {
            $respuesta = array(
                "error" => $th->getMessage()

            );
        }
        echo json_encode($respuesta);
    }
}


if ($_POST) {
    if ($_POST["accion"] == "editar") {
        //JSON enode es el nico  que nos permite debuguear neustro codigo 
        //incluir la coneccion de labase de atos 
        require_once("../funciones/bd.php");
        $nombre = filter_var(htmlspecialchars($_POST["nombre"]));
        $empresa = filter_var(htmlspecialchars($_POST["empresa"]));
        $telefono = filter_var(htmlspecialchars($_POST["telefono"]));
        $id = filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT);

        try {
            //? Aqui hacemos el update donde recive  todo defrente sin miedo al exito, no olvidar eL Place holder y MÁS el WHERE
            $stmt = $conn->prepare("UPDATE contactos SET nombre = ? , empresa = ? , telefono = ? WHERE idcontactos = ? ");
            $stmt->bind_param("sssi", $nombre, $empresa, $telefono, $id);
            //?ejecutamso la consulta de la sentencia preparada 
            $stmt->execute();


            //!Colocar respuesta, si y solo si se a realizado una modificicacion dentro de la tabla 

            if ($stmt->affected_rows == 1) {
                $respuesta = array(
                    "respuesta" => "correcto"
                );
            }else{
                $respuesta = array(
                    "respuesta" => "error"
    
                );
            }
            $stmt->close();
            $conn->close();
        } catch (\Throwable $th) {

            $respuesta = array(
                "respuesta" => $th->getMessage()

            );
        }

        //!JODER, no te olvides de enviar la respuesta, literalmente.

        echo json_encode($respuesta);
    }
}
