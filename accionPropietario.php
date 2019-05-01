

<?php
session_start();
include('includes/gestionBD.php');
if(isset($_SESSION["form"])){
    $form["NombreAp"] = $_POST['NombreAp'];
    $form["Dni"] = $_POST['Dni'];
    $form["Telefono"] = $_POST['Telefono'];
    $form["Email"] = $_POST['Email'];

    $_SESSION['form'] = $form;
}else{
    header('Location: altaPropietario.php');
}
$conexion=crearConexionBD();

insertarPropietario($conexion, $form);
$IdP = getIdPropietario($conexion, $form["Dni"]);
$IdC = $_SESSION["IdC"];
unset($_SESSION["form"]);
insertarPertenencia($conexion, $IdP, $IdC);

cerrarConexionBD($conexion);



function insertarPropietario($conexion, $propietario){
    try{
        $stmn = $conexion -> prepare("INSERT INTO Propietarios (NombreAp, Dni, Telefono, Email) VALUES (:NombreAp, :Dni, :Telefono, :Email)");
        $stmn -> bindParam(':NombreAp', $propietario["NombreAp"]);
        $stmn -> bindParam(':Dni', $propietario["Dni"]);
        $stmn -> bindParam(':Telefono', $propietario["Telefono"]);
        $stmn -> bindParam(':Email', $propietario["Email"]);
        $stmn -> execute();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function getIdPropietario($conexion, $dni){
    try{
        $stmn = $conexion -> prepare("SELECT IdP FROM Propietarios WHERE dni=:dni");
        $stmn -> bindParam(':dni', $dni);
        $stmn -> execute();
        return $stmn -> fetchColumn();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}

function insertarPertenencia($conexion, $IdP, $IdC){
    try{
        $stmn = $conexion -> prepare("INSERT INTO Pertenece (IdP, IdC) VALUES (:idp, :idc)");
        $stmn -> bindParam(':idp', $IdP);
        $stmn -> bindParam(':idc', $IdC);
        $stmn -> execute();
    }catch(PDOException $e){
        $_SESSION["excepcion"] = $e -> getMessage();
        header("Location: excepcion.php");
    }
}
?>