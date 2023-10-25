<?php include("../template/cabecera.php"); ?>
<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

$contraseña="sistema";

echo $txtID."<br/>";
echo $txtNombre."<br/>";
echo $txtImagen."<br/>";
echo $accion."<br/>";

include ("../config/bd.php");

switch($accion){
    
    case "Agregar":
       //INSERT INTO "Libros" ("id", "nombre", "imagen) VALUES (NULL, "Libro de php",)
        $sentenciaSQL= $conexion->prepare(" INSERT INTO entradas (Nombre,Imagen ) VALUES (:Nombre,:Imagen);");
        $sentencia->bindParam(":nombre",$txtNombre);
        $sentenciaSQL->execute();

        $fecha=new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

        $tmpImagen=$_FILES["txtImagen"]["tmp_name"]

        if($tmpImagen="")(
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo)
        )

        $sentenciaSQL->bindParam(":imagen",$nombreArchivo);
        $sentenciaSQL->execute();
        break;

    case "Modificar":

        $sentenciaSQL= $conexion->prepare("SELECT FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(":nombre",$txtNombre);
        $sentenciaSQL->bindParam(":id",$txtID);
        $sentenciaSQL->execute();

       if($txtImagen=""){
        $sentenciaSQL= $conexion->prepare("SELECT FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(":imagen",$txtImagen);
        $sentenciaSQL->bindParam(":id",$txtID);
        $sentenciaSQL->execute();
       }

        break;

    case "Cancelar":
        echo "Presionado boton Cancelar";
        break;

        case "Seleccionar":
            $sentenciaSQL= $conexion->prepare("SELECT FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(":id",$txtID)
            $sentenciaSQL->execute();
            $Listaentradas=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre=$librp["nombre"];
        $txtImagen=$libro["imagen"];

            //echo "Presionado boton Seleccionar";
            break;

            case "Borrar":
                $sentenciaSQL= $conexion->prepare("DELETE FROM libros WHERE id=:id");
                $sentenciaSQL-ZbinParam(":id",$txtID);
                $sentenciaSQL->execute();
                //echo "Presionado boton Borrar";
                break;

}

$sentenciaSQL= $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$Listaentradas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos de entrada
        </div>

        <div class="card-body">

        <form method="POST" enctype="multipart/form-data">

    <div class = "form-group">
    <label for="txtID">ID:</label>
    <input type="text" required class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
    </div>

    <div class = "form-group">
    <label for="txtNombre">Nombre:</label>
    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre de la entrada ">
    </div>

    <div class = "form-group">
    <label for="txtNombre">Imagen:</label>

    <br/>

    <?php if($txtImagen!=""){  ?>

        <img class="img-trumbnail rounded" src="../../img/<?php echo $txtImagen;?>" width="50" alt="" srcset="">
        


    <?php }  ?>



    <input type="file" class="form-control"  name="txtImagen" id="txtImagen" placeholder="imagen ">
    </div>

        <div class="btn-group" role="group" aria-label="">
            <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"";?> value="Agregar" class="btn btn-success">Comprar</button>
            <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"";?> value="Modificar" class="btn btn-warning">Modificar entrada</button>
            <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":"";?> value="Cancelar" class="btn btn-info">Cancelar</button>
        </div>

    </form>
        </div>
    </div>



    
    

</div>
<div class="col-md-7">
    
<table class=" table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($Listaentradas as $entrada) { ?>    
            <tr>
                <td><?php echo $entrada["ID"]; ?></td>
                <td><?php echo $entrada["Nombre"]; ?></td>
                <td>
                    
                    <img class="img-trumbnail rounded" src="../../img/<?php echo $entrada["Imagen"]; ?>" width="50" alt="" srcset="">
        <th>
        <form method="post">

<input type="hidden" name="txtID" id="txtID" value="<?php echo $entrada["ID"]; ?>" />

<input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>

<input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>


</form>
        </th>
        <?php } ?>
    </tbody>
</table>
    

<?php include("../template/pie.php"); ?>