<?php
session_start();
require_once '../model/query.php';
$database= new model_sql();

$get_students = $database->getSingleEstudents("estudents", $_SESSION['dni']);

$get_union_notes= $database->getNotesEstudents("notes", $_SESSION['dni'] );

$id_note_partial=$get_union_notes['id_note_partial'];


$stado = $get_union_notes['state'];

$id_student= $get_students['id_estudents'];

    
     if (isset($_GET['id'])) {
        $correlative = $_GET['id'];
        $get_union_correlatives = $database->get_Correlatives("subjects", $correlative);
        $id_student= $get_union_correlatives['id_estudents'];
       
        
       
           
    } 
    if (isset($_GET['correlative'])) {
        $correlative_2 = $_GET['correlative'];
    
        // Usa la variable almacenada en lugar de $_GET['id_subjects']
        $get_union_notes_partial = $database->get_id_correlatives("notes", $correlative_2, $id_student);
        $fk_student=$get_union_notes_partial['id_estudents'];
        $fk_subject=$get_union_notes_partial['correlative'];
        $notes_state=$get_union_notes_partial['state'];
        
        if ($notes_state== 1) {
           
            $insert_correlative= $database->insert_studedent_correlative($fk_student,$fk_subject);
            
        }
       
    }
    
    
    
    
    




?>