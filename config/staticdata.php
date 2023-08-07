<?php

return [
    'informacion_personal' => [
        'generos' => [
            ['id' => 1, 'nombre' => 'Hombre'],
            ['id' => 2, 'nombre' => 'Mujer'],
            ['id' => 3, 'nombre' => 'Otro'],
        ],
        
        'tipos_sangre' => [
            ['id' => 1, 'nombre' => 'A+'],
            ['id' => 2, 'nombre' => 'A-'],
            ['id' => 3, 'nombre' => 'AB+'],
            ['id' => 4, 'nombre' => 'AB-'],
            ['id' => 5, 'nombre' => 'B+'],
            ['id' => 6, 'nombre' => 'B-'],
            ['id' => 7, 'nombre' => 'O+'],
            ['id' => 8, 'nombre' => 'O-']
        ],
    
        'estados_civiles' => [
            ['id' => 1, 'nombre' => 'Soltero/a'],
            ['id' => 2, 'nombre' => 'Casado/a'],
            ['id' => 3, 'nombre' => 'Viudo/a'],
            ['id' => 4, 'nombre' => 'Divorciado/a'],
            ['id' => 5, 'nombre' => 'Separado/a'],
            ['id' => 6, 'nombre' => 'Conviviente'],
            ['id' => 7, 'nombre' => 'Unión civil']
        ],
    ],

    'gestion_academica' => [
        'cuatrimestres' => [
            ['id' => 0, 'nombre' => '1er Cuatrimestre'],
            ['id' => 1, 'nombre' => '2do Cuatrimestre'],
            ['id' => 2, 'nombre' => '3er Cuatrimestre'],
            ['id' => 3, 'nombre' => '4to Cuatrimestre'],
            ['id' => 4, 'nombre' => '5to Cuatrimestre'],
            ['id' => 5, 'nombre' => '6to Cuatrimestre'],
            ['id' => 6, 'nombre' => '7mo Cuatrimestre'],
            ['id' => 7, 'nombre' => '8vo Cuatrimestre'],
            ['id' => 8, 'nombre' => '9no Cuatrimestre']
        ],
    ],

    'dates' => [
        'dias_semana' => [
            ['id' => 0, 'nombre' => 'Lunes'],
            ['id' => 1, 'nombre' => 'Mates'],
            ['id' => 2, 'nombre' => 'Miércoles'],
            ['id' => 3, 'nombre' => 'Jueves'],
            ['id' => 4, 'nombre' => 'Viernes'],
            ['id' => 5, 'nombre' => 'Sábado'],
            ['id' => 6, 'nombre' => 'Domingo']
        ],
    ],

    'estructura_academica' => [
        'tipos_aulas' => [
            ['id' => 0, 'nombre' => 'Salas'],
            ['id' => 1, 'nombre' => 'Laboratorios'],
            ['id' => 2, 'nombre' => 'Salón de clases']
        ],
    
        'edificios' => [
            ['id' => 0, 'nombre' => 'A'],
            ['id' => 1, 'nombre' => 'B'],
            ['id' => 2, 'nombre' => 'C'],
            ['id' => 3, 'nombre' => 'D (Biblioteca)'],
            ['id' => 4, 'nombre' => 'F (LT3 - CAPTA)'],
            ['id' => 5, 'nombre' => 'LT1'],
            ['id' => 6, 'nombre' => 'LT2'],
        ],
    ],
];