<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\EstructuraAcademica\Grupo;

use Carbon\Carbon;

class HorariosApi extends Controller
{
    public function MateriaHorario($id_grupo)
    {
        $data = Grupo::with(['aula', 'carrera', 'tutor', 'grupoMateria' => function($query) {
                $query->with(['profesor', 'materia', 'grupo'])->select(['id', 'profesor_id', 'materia_id', 'grupo_id', 'horarios']);
            }])
            ->where('id', 3)
            ->first()
            ->grupoMateria->map(function($grupo_materia) {
                $materia_nombre = isset($grupo_materia->materia->nombre) ? $grupo_materia->materia->nombre : 'Sin materia';
                $materia_horario = isset($grupo_materia->horarios) ? $grupo_materia->horarios : null;
                return [
                    'horario_materia' => $this->transformarHorariosConCarbon($materia_nombre, $materia_horario)
                ];
            });

        return response()->json($data);
    }

    public function transformarHorariosConCarbon($materia_nombre, $materia_horario)
    {
        // $horarios = json_decode($horariosJson, true);

        $diasMapa = ['lunes' => 1, 'martes' => 2, 'miercoles' => 3, 'jueves' => 4, 'viernes' => 5, 'sabado' => 6, 'domingo' => 0];

        $diasDeLaSemana = [];
        $horasInicio = [];
        $horasFin = [];

        foreach($materia_horario as $clave => $valor){
            if(is_bool($valor) && $valor === true){
                $diasDeLaSemana[] = $diasMapa[$clave];
            }

            if(strpos($clave, '_hora_inicio') !== false && $valor !== null){
                $horasInicio[] = Carbon::parse($valor)->setTimezone('America/Mexico_City')->format('H:i:s');
            }elseif(strpos($clave, '_hora_fin') !== false && $valor !== null){
                $horasFin[] = Carbon::parse($valor)->setTimezone('America/Mexico_City')->format('H:i:s');
            }
        }

        $startTime = !empty($horasInicio) ? min($horasInicio) : null;
        $endTime = !empty($horasFin) ? max($horasFin) : null;

        return [
            'title' => $materia_nombre,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'daysOfWeek' => $diasDeLaSemana,
        ];
    }
}
