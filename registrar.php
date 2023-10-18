<?php
//print_r($_POST);
if (empty($_POST["txtNombre"]) || empty($_POST["txtApellido"]) || empty($_POST["txtDni"]) || 
    empty($_POST["txtTelefono"]) || empty($_POST["txtDate"]) || empty($_POST["txtEspecialidad"]) 
    || empty($_POST["txtHorario"]) || empty($_POST["txtDoctor"])) {
    header('Location: index.php?mensaje=falta');
    exit();
}

include_once 'model/conexion.php';

$nombre = $_POST["txtNombre"];
$apellido = $_POST["txtApellido"];
$dni= $_POST["txtDni"];
$telefono = $_POST["txtTelefono"];
$date = $_POST["txtDate"];
$especialidad = $_POST["txtEspecialidad"];
$horario = $_POST["txtHorario"];
$doctor = $_POST["txtDoctor"];


// Conexion a la green api para enviar informacion

$url = 'https://api.green-api.com/waInstance7103866753/SendMessage/734bb30837f74615b4e5766c3cbb495a5e2d65d768404364b8';
$data = [
    // "51999999999@c.us",
    // "51".$persona->celular."@c.us",
    // "title" => "Clinica Vida", 
    "chatId" => "51".$telefono."@c.us",
    "message" =>  'Estimado(a) *'.strtoupper($nombre).' '.strtoupper($apellido).'*, se confirma el registro de su cita 📅 para el dia  *'.strtoupper($date).'* en el horario 🕒  *'.$horario.'*'. ' para la especialidad de *'. strtoupper($especialidad).'* con el doctor 👨‍⚕️ *'.strtoupper($doctor).'*. ' .'recuerda presentarte con tiempo a tus citas.'
];

$options = array(
    'http' => array(
        'method'  => 'POST',
        'content' => json_encode($data),
        'header' =>  "Content-Type: application/json\r\n" .
            "Accept: application/json\r\n"
    )
);



$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$response = json_decode($result);

$sentencia = $bd->prepare("INSERT INTO clinica.cita(nombre,apellido,dni,telefono,date,especialidad,horario,doctor) VALUES (?,?,?,?,?,?,?,?);");
$resultado = $sentencia->execute([$nombre, $apellido, $dni, $telefono, $date, $especialidad, $horario, $doctor]);

if ($resultado === TRUE) {
    header('Location: index.php?mensaje=registrado');
    exit();
} else {
    header('Location: index.php?mensaje=error');
    exit();
}


?>




