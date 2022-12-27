<?php
include "inc/layout/header.php";
require "inc/funciones/funciones.php";
?>
<!-- inicio de estructura del documento -->
<div class="contenedor-barra">

    <h1>Agenda de Contactos</h1>

</div>

<div class="bg-amarillo contenedor sombra">
    <!-- si las insersicones son por ajax se debe trabajar los datos en el mismo docuemnto  -->
    <form id="contacto" action="registro.php">
        <legend>
            Añada un contacto <span> Todos los campos son obligatorios</span>
        </legend>
        <!-- cuando trabajes con flexbox debemos contar simpre con un contenedor  -->
        <?php include "inc/layout/formulario.php"; ?>
    </form>
</div>


<div class="bg-blanco contenedor sombra contactos">
    <div class="contenedor-contactos">
        <h2>
            Contactos
        </h2>
        <input type="text"  id="buscar" class="buscador sombra" placeholder="Buscar Contactos...">
        <p class="total-contactos"><span></span> Contactos</p>
        <div class="contenedor-tabla">
            <table id="listado-contactos" class="listado-contactos">
                <!-- td significa datos de tabla.  Todo entre y son el contenido de la celda de la tabla.<td></td>encabezado -->
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Empresa</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>


                <!-- CUERPO DE LA TABLA  -->
                <tbody>
                    
                <?php $contactos = obtenerContactos();        
                //*para saber si hay datos en nuestra base de datos ->  ["num_rows"]=> int(3), accedemos el valor de este objeto
                if($contactos->num_rows){
                    foreach($contactos as $contacto):?>

              
                 <tr>
                        <td><?php echo $contacto["nombre"];?></td>
                        <td><?php echo $contacto["empresa"];?></td>
                        <td><?php echo $contacto["telefono"];?></td>
                        <td>
                            <a class="btn-editar btn" href="editar.php?id=<?php echo $contacto["idcontactos"];?>">
                                <i class="fa-solid fa-square-pen"></i>
                            </a>
                            <!-- puedes crear tus neuvos atributos nombre="balor# -->
                            <button data-id="<?php echo $contacto["idcontactos"];?>" type="button" class="btn-borrar btn">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach;} ?>


                </tbody>

            </table>
        </div>
    </div>
</div>

<?php
include "inc/layout/footer.php";
?>