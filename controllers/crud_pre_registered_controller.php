<?php
require_once '../model/query.php';

$database = new model_sql();

// Verifica si se envió el formulario de búsqueda
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegúrate de que se haya enviado un valor para 'search'
    if (isset($_POST['search'])) {
        // Obtiene el término de búsqueda ingresado por el usuario
        $searchTerm = $_POST['search_name'];
        $searchResults = $database->search_pre_register($searchTerm);

        // Incluye la vista HTML pasando los resultados de la búsqueda
        require_once '../views/views_crud_pre_registered.php';
        exit; // Detiene la ejecución del script después de mostrar los resultados
    }

    // ... (código anterior)

if (isset($_POST['copy'])) {
    $id = $_POST['copy'];
    $get_user = $database->getSingleShow("pre_registration", $id);

    // Verifica si se encontró el usuario
    if ($get_user) {
        $name = $get_user['name'];
        $last_name = $get_user['last_name'];
        $phone = $get_user['phone'];
        $email = $get_user['mail'];
        $date = $get_user['date'];
        $dni = $get_user['dni'];
        $career = $get_user['carrer'];
        $heigth_street = $get_user['heigth_street'];
        $gender = $get_user['gender'];
        $generatedPassword = generateRandomPassword(8);
        $hash_password = password_hash($generatedPassword, PASSWORD_DEFAULT);

        // Divide la dirección en dirección y altura
        $space_position = strrpos($heigth_street, ' ');
        $direction = ($space_position !== false) ? substr($heigth_street, 0, $space_position) : $heigth_street;
        $height = ($space_position !== false) ? substr($heigth_street, $space_position + 1) : '';

        $currentYear = date('Y');
        $currentMonth = date('m');

        if ($currentMonth >= 10) {
            $academicYearStart = $currentYear + 1;
        } else {
            $academicYearStart = $currentYear;
        }

        // Obtiene el ID de la carrera y el género
        $steal_id_career = $database->getCareerIDByName($career);
        $steal_id_gender = $database->getGenderIDByName($gender);

        // Inserta al estudiante y obtiene su ID
        $insert = $database->insertStudent($name, $last_name, $direction, $height, $dni, $email, $phone, $academicYearStart, $steal_id_career, $date, $steal_id_gender);

        if ($insert) {
            $studentId = $database->getLastInsertId();
            $delete_transfer = $database->delete_preinscription($id);
            $careerId = $database->getCareerIdByStudentId($studentId);

            // Obtiene las materias asociadas a la carrera del estudiante
            $subjects = $database->getSubjectsByCareerId($careerId);

            // Inserta cada materia asociada al estudiante
            foreach ($subjects as $subjectId) {
                $schoolYear = $academicYearStart;
                $inserted = $database->insert_student_subject($studentId, $subjectId, $schoolYear);
            }

            // Llamada a create_account_student fuera del bloque
            $inserted_student = $database->create_account_student($name, $dni, $hash_password, $email);

            if ($inserted_student) {
                // Envía el correo y realiza las acciones necesarias aquí
                require_once 'mail_create_new_user_student.php';

                // Redirige a la página de dashboard de administrador con un parámetro de mensaje de éxito en la URL
                header("Location: ../views/views_internal_users.php?creado=correcto");
                exit(); // Asegura que no se ejecuten más instrucciones después de la redirección
            } else {
                echo "Error en la inserción: No se pudo crear la cuenta.";
            }
        }
    }
}

// ... (código posterior)

    
}
function generateRandomPassword($length = 8) {
    // Characters to be used for generating the password
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';

    // Generate the random password
    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $password .= $characters[$index];
    }

    return $password;
}

// Si no se envió el formulario de búsqueda o no se encontraron resultados, muestra la página normal
$show_pre_register = $database->show_state("pre_registration");
require_once '../views/views_crud_pre_registered.php';
?>
