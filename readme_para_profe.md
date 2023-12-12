tarea 1: 
que al momento de crear el usuario se le mande un mail al aspirante, que ya paso a ser un estudiante y se le cree un perfil con una contraseña aleatoria que luego debera cambiar

_copia de datos de preinscripción a estudiantes registrados y creación de cuentas de usuario para los estudiantes

_cuentas de usuario para los estudiantes enviando un mail al momento de la preincripcion y al momento de dar de alta

_generador de contraseña aleatoria al momento de dar de alta

_traer los datos del estudiante y mostrarlos en el perfil

archivos usados primer tarea:

controller_
crud_pre_registered_controller.php
mail_create_new_user_student.php

query_
function insertStudent
function create_account_student

views_
dashboard-student.php



tarea 2: que el estudiante pueda ver sus notas,  si aprobo los parciales o recuperatorios o integrador, segun sea el caso, pueda incribirse a la materia correlativa del año entrante

_se creo una base de datos llamado notes que tiene notas precargadas con las materia de la carrera.

_importante! al entrar al perfil va a encontrar los datos vacios debera cambiar en el phpmysql en la tabla de notes poner su id del alumno para que se muestren esas notas precargadas solo funcionara con la carrera de analisis de sistemas

_ala hora de inscribirse se inscribe inserta los datos pero no los muestra por pantalla en el perfil del alumno. si no que, ay que ir ala base de datos en la parte de students_subjects. se va a dar cuenta porque los nuevos ingresos van a tener el año 2025 no llegue con el tiempo para que me lo muestre por el front

archivos usados segunda tarea:

controller_
crud_dashboard_student.php

query_
public function getSingleEstudents
public function getNotesEstudents
public function get_Correlatives
public function get_id_correlatives
public function insert_studedent_correlative

views_
dashboard-student.php
singup_subject.php


posdata: la base de datos me volvio loco

link trello https://trello.com/b/9e12ZvuU/final-de-practicas