<!-- En este caso empreaaremos el operador ternario para determinara donde nos encontramos -->

<div class="campos">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" placeholder="Nombre Contacto" id="nombre" value="<?php echo (isset($contacto["nombre"])) ? $contacto["nombre"] : ''; ?>">
    </div>
    <div class="campo">
        <label for="empresa">Empresa:</label>
        <input type="text" placeholder="Nombre Empresa" id="empresa" value="<?php echo (isset($contacto["empresa"])) ? $contacto["empresa"] : ''; ?>">
    </div>
    <div class="campo">
        <label for="telefono">Telefono:</label>
        <input type="tel" placeholder="Telefono Contacto" id="telefono"  value="<?php echo (isset($contacto["telefono"]))? $contacto["telefono"] : ''; ?>" >
    </div>
</div>

<div class="campo enviar">

<?php 
//! Basta conque excista uno de estos leementos para cambiar y modficar el texto del boton logicamente en cdonde nos enconttremsos 
$textoBtn =(isset($contacto["telefono"])) ? "Guardar" : "Añadir";
$accion = (isset($contacto["telefono"])) ? "editar" : "crear";

?>
    <input type="hidden" id="accion" value="<?php echo $accion?>">

    <?php 
    if(isset($contacto["idcontactos"])){?>
    <input type="hidden" id="id" value="<?php echo $contacto["idcontactos"]; ?>">
    <?php } ?>
    <input type="submit" value="<?php echo $textoBtn; ?>">
</div>