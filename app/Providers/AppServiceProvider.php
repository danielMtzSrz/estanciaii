<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Models\GestionAcademica\GrupoMateria;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('horarios_no_duplicados', function ($attribute, $value, $parameters, $validator)
        {
            $horarios_map = $this->horariosMap($value);
            $horarios_agrupados = $this->agruparHorarios($horarios_map, '');
            
            $horarios_grupo = GrupoMateria::with('grupo', 'materia')
                ->where([
                    ['grupo_id', $parameters[0]],
                    ['materia_id', '!=', $parameters[1]]
                ])
                ->whereHas('grupo', function ($query) use ($parameters) {
                    $query->where('periodo_id', $parameters[2]);
                })
                ->get()
                ->map(function($grupoMateria) {
                    return $this->agruparHorarios($grupoMateria->horarios, $grupoMateria->materia->nombre);
                });

            $horarios_superpuestos = $this->validarHorarios($horarios_agrupados, $horarios_grupo);

            if(count($horarios_superpuestos)){
                $errores_por_dia = [];

                foreach($horarios_superpuestos as $item){
                    $dia = $item['dia'];
                    $mensaje = "<li>{$item['grupo_nombre']}: {$item['hora_inicio']} - {$item['hora_fin']}</li>";
            
                    if(!isset($errores_por_dia[$dia])){
                        $errores_por_dia[$dia] = [];
                    }
            
                    $errores_por_dia[$dia][] = $mensaje;
                }
            
                $estructura_final = [];

                foreach($errores_por_dia as $dia => $mensajes){
                    $estructura_final[$dia] = implode('', $mensajes);
                }

                $validator->errors()->add($attribute, json_encode($estructura_final));
            }
        
            return !count($horarios_superpuestos);
        });
    }

    public function horariosMap($horarios)
    {
        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        $horarios_mapeados = [];

        foreach($dias as $dia){
            if(isset($horarios[$dia]) && $horarios[$dia]){
                $horarios_mapeados[$dia] = true;
                $horarios_mapeados[$dia.'_hora_inicio'] = (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3}Z$/', $horarios[$dia.'_hora_inicio'])) 
                    ? Carbon::now()->isDST() ? Carbon::parse($horarios[$dia.'_hora_inicio'])->timezone('America/Monterrey')->subHour()->format('H:i') : Carbon::parse($horarios[$dia.'_hora_inicio'])->timezone('America/Monterrey')->format('H:i')
                    : $horarios[$dia.'_hora_inicio'];
                $horarios_mapeados[$dia.'_hora_fin'] = (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3}Z$/', $horarios[$dia.'_hora_fin'])) 
                    ? Carbon::now()->isDST() ? Carbon::parse($horarios[$dia.'_hora_fin'])->timezone('America/Monterrey')->subHour()->format('H:i') : Carbon::parse($horarios[$dia.'_hora_fin'])->timezone('America/Monterrey')->format('H:i')
                    : $horarios[$dia.'_hora_fin'];
            }
        }
        
        return $horarios_mapeados;
    }

    public function agruparHorarios($horarios, $grupo_nombre='')
    {
        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
        $horarios_agrupados = [];

        foreach($dias as $dia){
            if(!empty($horarios[$dia])){
                $horarios_agrupados[$dia] = [
                    "grupo_nombre" => $grupo_nombre,
                    "hora_inicio" => $horarios[$dia."_hora_inicio"],
                    "hora_fin" => $horarios[$dia."_hora_fin"]
                ];
            }
        }

        return $horarios_agrupados;
    }

    function seSuperponen($horario_request, $horario_grupo)
    {
        $fecha_base = '2000-01-01';

        $horario_request_inicio = Carbon::createFromFormat('Y-m-d H:i', $fecha_base . ' ' . Carbon::parse($horario_request['hora_inicio'])->format('H:i'), 'America/Los_Angeles');
        $horario_request_fin = Carbon::createFromFormat('Y-m-d H:i', $fecha_base . ' ' . Carbon::parse($horario_request['hora_fin'])->format('H:i'), 'America/Los_Angeles');
        $horario_grupo_inicio = Carbon::createFromFormat('Y-m-d H:i', $fecha_base . ' ' . Carbon::parse($horario_grupo['hora_inicio'])->format('H:i'), 'America/Los_Angeles');
        $horario_grupo_fin = Carbon::createFromFormat('Y-m-d H:i', $fecha_base . ' ' . Carbon::parse($horario_grupo['hora_fin'])->format('H:i'), 'America/Los_Angeles');

        $seSuperponen = $horario_request_inicio->lt($horario_grupo_fin) && $horario_request_fin->gt($horario_grupo_inicio);

        
        return $seSuperponen;
    }
    
    function validarHorarios($horarios_request, $horarios_grupo)
    {
        $horarios_superpuestos = [];

        foreach ($horarios_request as $dia => $horario_request) {
            foreach ($horarios_grupo as $conjunto) {
                if (isset($conjunto[$dia])) {
                    $horario_grupo = $conjunto[$dia];
                    if ($this->seSuperponen($horario_request, $horario_grupo)) {
                        $horarios_superpuestos[] = [
                            "dia" => $dia,
                            "grupo_nombre" => $horario_grupo['grupo_nombre'],
                            "hora_inicio" => Carbon::parse($horario_grupo['hora_inicio'])->setTimezone('America/Mexico_City')->format('H:i'),
                            "hora_fin" => Carbon::parse($horario_grupo['hora_fin'])->setTimezone('America/Mexico_City')->format('H:i')
                        ];
                    }
                }
            }
        }

        return $horarios_superpuestos;
    }
}