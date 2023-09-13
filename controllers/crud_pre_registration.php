<?php
//require_once "mail.php";
require_once "../model/query.php";

$database = new model_sql();
$carrerData = $database->show("careers"); // Obtener datos de carreras



$nam_pre = $_POST['name'];
$last_pre = $_POST['l_name'];
$phone_pre = $_POST['phone'];
$email_pre = $_POST['email'];
$date_pre = $_POST['date'];
$dni_pre = $_POST['dni'];
$carrer_pre = $_POST['carrer'];
$street_pre = $_POST['street'];
$gender_pre = $_POST['gender'];
$save_data = $_POST['save_data'];

if (isset($save_data)) {
    // Validar que los campos no estén vacíos
    if (empty($nam_pre) || empty($last_pre) || empty($phone_pre) || empty($email_pre) || empty($date_pre) || empty($dni_pre) || empty($carrer_pre) || empty($street_pre) || empty($gender_pre)) {
        // Al menos uno de los campos está vacío, muestra un mensaje de error.
        echo "Todos los campos son obligatorios. Por favor, llene todos los campos.";
    } else {
        // Verifica duplicados antes de intentar la inserción
        $checkforduplicated = $database->checkForDuplicates($dni_pre, $email_pre);
        if ($checkforduplicated !== false) {
            // Se encontraron duplicados, muestra el mensaje personalizado
            echo $checkforduplicated;
        } else {
            // No se encontraron duplicados, procede con la inserción
            $insert = $database->pre_registration($nam_pre, $last_pre, $phone_pre, $email_pre, $date_pre, $dni_pre, $carrer_pre, $street_pre, $gender_pre);

            if ($insert) {
                // Parte de envío de correo electrónico
                require_once 'mail.php';
            } else {
                echo "Hubo un error al guardar los datos en la base de datos.";
            }
        }
    }
}


?>