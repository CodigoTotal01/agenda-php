<?php include "inc/layout/header.php"; // si el código del fichero ya ha sido incluido, no se volverá a incluir,
include "inc/funciones/funciones.php"; //! incluyendo las funciones 
//iene desde index, esta valida}´cion de dtos lo convierte a un entero

if ($_GET) {
  $id = ( (int) $_GET["id"]) ;
  $id = filter_var($id, FILTER_VALIDATE_INT);

  if(!$id){
      die("Besa mi metalico trasero. By Bender");
  }
    $resultado = obtenerContacto($id);
//Funcion especial para obtener la finla de la consulta de labase de datos en un arrreglo  asociativo 
  $contacto = $resultado->fetch_assoc();   

}


?>



<div class="contenedor-barra">

    <div class="contenedor barra">
        <a href="index.php" class="btn volver">Volver</a>
        <h1>Editar Contacto</h1>
    </div>

</div>

<div class="bg-amarillo contenedor sombra">
    <!-- si las insersicones son por ajax se debe trabajar los datos en el mismo docuemnto  -->
    <form id="contacto" action="#">
        <legend>
            Edite el contacto
        </legend>
        <?php include "inc/layout/formulario.php" ?>;


    </form>

</div>
<?php include "inc/layout/footer.php"; // si el código del fichero ya ha sido incluido, no se volverá a incluir,
?>