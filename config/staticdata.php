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
        'turnos' => [
            ['id' => 1, 'nombre' => 'Matutino'],
            ['id' => 2, 'nombre' => 'Vespertino']
        ],
        'cuatrimestres' => [
            ['id' => 1, 'nombre' => '1er Cuatrimestre'],
            ['id' => 2, 'nombre' => '2do Cuatrimestre'],
            ['id' => 3, 'nombre' => '3er Cuatrimestre'],
            ['id' => 4, 'nombre' => '4to Cuatrimestre'],
            ['id' => 5, 'nombre' => '5to Cuatrimestre'],
            ['id' => 6, 'nombre' => '6to Cuatrimestre'],
            ['id' => 7, 'nombre' => '7mo Cuatrimestre'],
            ['id' => 8, 'nombre' => '8vo Cuatrimestre'],
            ['id' => 9, 'nombre' => '9no Cuatrimestre']
        ],
    ],

    'dates' => [
        'horario_matutino' => [
            '07:00-07:50',
            '07:50-08:40',
            '08:40-09:30',
            '09:30-10:20',
            '10:20-11:10',
            '11:10-12:00',
            '12:00-12:50',
            '12:50-13:40'
        ],
        'horario_vespertino' => [
            '14:00-14:50',
            '14:50-15:40',
            '15:40-16:30',
            '16:30-17:20',
            '17:20-18:10',
            '18:10-19:00',
            '19:00-19:50',
            '19:50-20:40'
        ],
        'dias_semana' => [
            ['id' => 1, 'nombre' => 'Lunes'],
            ['id' => 2, 'nombre' => 'Martes'],
            ['id' => 3, 'nombre' => 'Miércoles'],
            ['id' => 4, 'nombre' => 'Jueves'],
            ['id' => 5, 'nombre' => 'Viernes'],
            ['id' => 6, 'nombre' => 'Sábado']
        ],
    ],

    'estructura_academica' => [
        'tipos_aulas' => [
            ['id' => 1, 'nombre' => 'Salas'],
            ['id' => 2, 'nombre' => 'Laboratorios'],
            ['id' => 3, 'nombre' => 'Salón de clases']
        ],
    
        'edificios' => [
            ['id' => 1, 'nombre' => 'A'],
            ['id' => 2, 'nombre' => 'B'],
            ['id' => 3, 'nombre' => 'C'],
            ['id' => 4, 'nombre' => 'D (Biblioteca)'],
            ['id' => 5, 'nombre' => 'F (LT3 - CAPTA)'],
            ['id' => 6, 'nombre' => 'LT1'],
            ['id' => 7, 'nombre' => 'LT2'],
        ],
    ]
];