<?php
session_start();
require 'Exceptions.php';
set_exception_handler('exceptionHandler');

if (isset($_POST['name'], $_POST['course'], $_POST['age'])) {

    $options =   [
        'name' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/^[a-zA-Z\s]+$/i',
            ]
        ],
        'course' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => [
                'regexp' => '/^[a-z0-9.,\s]+$/i',
            ]
        ],
        'age' => [
            'filter' => FILTER_VALIDATE_INT,
        ],
    ];

    $entryPost =  filter_input_array(INPUT_POST, $options);

    if ($entryPost['name'] === null || $entryPost['name'] === false) {
        throw genericStringException::validate('name', $_POST['name']);
    } else {
        $name = $entryPost['name'];
    }
    if ($entryPost['course'] === null || $entryPost['course'] === false) {
        throw genericStringException::validate('course', $_POST['course']);
    } else {
        $course = $entryPost['course'];
    }
    if ($entryPost['age'] === null) {
        throw notNumericException::validate($_POST['age']);
    } else {
        $age = (int)$entryPost['age'];
    }
    if ($age < 0 || $age > 120) {
        throw outOfRangeAgeException::validate($_POST['age']);
    } else {
        $age = (int)$entryPost['age'];
    }
    $dataCheck =  true;
} else {
    $dataCheck = false;
}

function getResult(): ?string
{
    global $dataCheck;
    if ($dataCheck) {
        global  $name;
        global $age;
        global $course;
        $_SESSION['result'] = '
<pre class="result">
    Nombre: ' . $name . '
    Edad: ' . $age . ' años
    Curso: ' . $course . '
</pre>';
    } else {
        $_SESSION['result'] = null;
    }

    return $_SESSION['result'];
}



/*
Ya sea un array asociativo de opciones, o el filtro que se aplicará a cada entrada, que puede ser un filtro 
de validación mediante el uso de una de las constantes FILTER_VALIDATE_* o un filtro de saneamiento mediante el uso 
de una de las constantes FILTER_SANITIZE_*. La array de opciones es un array asociativo donde la clave corresponde 
a una clave en la matriz de datos array y el valor asociado es el filtro a aplicar a esta entrada, 
o un array asociativo que describe cómo y qué filtro se debe aplicar a esta entrada. 
El array asociativo que describe cómo se debe aplicar un filtro debe contener la clave 'filter' 
cuyo valor asociado es el filtro a aplicar, que puede ser uno de las constantes FILTER_VALIDATE_*, FILTER_SANITIZE_*, FILTER_UNSAFE_RAW, o FILTER_CALLBACK. 

Opcionalmente, puede contener la clave 'flags', que especifica los indicadores que se aplican al filtro, 
y la clave 'options', que especifica las opciones que se aplican al filtro.

$definicion = [

    // Forma simple — solo el filtro
    'email' => FILTER_VALIDATE_EMAIL,

    // Forma completa — array con 3 claves posibles
    'edad' => [
        'filter'  => FILTER_VALIDATE_INT,   // obligatorio si usas array
        'flags'   => FILTER_REQUIRE_SCALAR, // opcional
        'options' => [                       // opcional
            'min_range' => 18,
            'max_range' => 99
        ]
    ],

    // Con flags y callback
    'nombre' => [
        'filter'  => FILTER_CALLBACK,
        'flags'   => FILTER_FORCE_ARRAY,
        'options' => 'ucwords'              // aquí va el callable
    ]
];

resultado ejemplo:
array(3) {
    ["nombre"] => string(4) "Juan"   // ✅ existe y válido
    ["email"]  => bool(false)        // ❌ existe pero inválido
    ["edad"]   => NULL               // ❌ no existe en POST
}

*/