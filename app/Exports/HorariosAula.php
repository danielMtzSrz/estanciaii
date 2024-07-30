<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class HorariosAula implements FromArray, WithStyles, ShouldAutoSize
{
    protected $horarios_matutino;
    protected $horarios_vespertino;
    protected $data = [];
    protected $colors = [];

    public function __construct(array $horarios_matutino, array $horarios_vespertino, array $encabezado_matutino, array $encabezado_vespertino)
    {
        $this->horarios_matutino = $horarios_matutino;
        $this->horarios_vespertino = $horarios_vespertino;
        $this->encabezado_matutino = $encabezado_matutino;
        $this->encabezado_vespertino = $encabezado_vespertino;
        $this->prepareData();
    }

    protected function prepareData()
    {
        $time_slots_matutino = config('staticdata.dates.horario_matutino');
        $time_slots_vespertino = config('staticdata.dates.horario_vespertino');

        // Encabezado para los horarios matutino y vespertino
        $this->data[] = [$this->encabezado_matutino['carrera'].' - '.$this->encabezado_matutino['periodo'].' | '.$this->encabezado_matutino['turno'], '', '', '', '', '', '', '', $this->encabezado_vespertino['carrera'].' - '.$this->encabezado_vespertino['periodo'].' | '.$this->encabezado_vespertino['turno'], '', '', '', '', '', ''];
        $this->data[] = [$this->encabezado_matutino['carrera'].' - '.$this->encabezado_matutino['periodo'].' | '.$this->encabezado_matutino['turno'], '', '', '', '', '', '', '', $this->encabezado_vespertino['carrera'].' - '.$this->encabezado_vespertino['periodo'].' | '.$this->encabezado_vespertino['turno'], '', '', '', '', '', ''];
        $this->data[] = [$this->encabezado_matutino['carrera'].' - '.$this->encabezado_matutino['periodo'].' | '.$this->encabezado_matutino['turno'], '', '', '', '', '', '', '', $this->encabezado_vespertino['carrera'].' - '.$this->encabezado_vespertino['periodo'].' | '.$this->encabezado_vespertino['turno'], '', '', '', '', '', ''];
        $this->data[] = ['AULA: '.$this->encabezado_matutino['aula'].' GRUPO: '.$this->encabezado_matutino['grupo'], '', '', '', '', '', '', '', 'AULA: '.$this->encabezado_vespertino['aula'].' GRUPO: '.$this->encabezado_vespertino['grupo'], '', '', '', '', '', ''];

        $this->data[] = ['Hora', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', '', 'Hora', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        $this->addHorario($this->horarios_matutino, $time_slots_matutino, 0);
        $this->addHorario($this->horarios_vespertino, $time_slots_vespertino, 8, true);
    }

    protected function addHorario(array $horarios, array $time_slots, int $start_column, bool $merge = false)
    {
        foreach($time_slots as $slotIndex => $slot){
            if($merge && isset($this->data[$slotIndex + 5])){
                $row = &$this->data[$slotIndex + 5];
            }else{
                $row = array_fill(0, 15, '');
                if(!$merge){
                    $row[$start_column] = $slot;
                }
            }
            if($merge){
                $row[$start_column] = $slot;
            }
            for($day=1; $day<=6; $day++){
                $found = false;
                foreach($horarios as $horario){
                    foreach($horario['horario_materia'] as $horario_materia){
                        $startTime = substr($horario_materia['startTime'], 0, 5);
                        $endTime = substr($horario_materia['endTime'], 0, 5);
                        $slotTimes = explode('-', $slot);

                        if (in_array($day, $horario_materia['daysOfWeek']) && $startTime <= $slotTimes[0] && $endTime > $slotTimes[0]) {
                            $row[$start_column + $day] = $horario_materia['title'];
                            $this->colors[] = [$start_column + $day, $slotIndex + 6, $horario_materia['color']];
                            $found = true;
                            break 2; // Salir de ambos bucles
                        }
                    }
                }
                if(!$found){
                    $row[$start_column + $day] = '';
                }
            }
            if(!$merge){
                $this->data[] = $row;
            }
        }
    }

    public function array(): array
    {
        return $this->data;
    }

    public function styles(Worksheet $sheet)
    {
        // Centrar los textos
        $sheet->getStyle('A1:M' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Aplicar colores a las celdas
        foreach($this->colors as $color) {
            $column = chr(65 + $color[0]); // Convertir el índice de columna a letra
            $sheet->getStyle($column . $color[1])->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(str_replace('#', '', $color[2]));
        }

        // Agregar encabezados
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');
        $sheet->mergeCells('A4:G4');
        $sheet->setCellValue('A1', $this->encabezado_matutino['carrera']);
        $sheet->setCellValue('A2', $this->encabezado_matutino['periodo']);
        $sheet->setCellValue('A3', $this->encabezado_matutino['turno']);
        $sheet->setCellValue('A4', 'AULA: '.$this->encabezado_matutino['aula'].' GRUPO: '.$this->encabezado_matutino['grupo']);

        $sheet->mergeCells('I1:O1');
        $sheet->mergeCells('I2:O2');
        $sheet->mergeCells('I3:O3');
        $sheet->mergeCells('I4:O4');
        $sheet->setCellValue('I1', $this->encabezado_vespertino['carrera']);
        $sheet->setCellValue('I2', $this->encabezado_vespertino['periodo']);
        $sheet->setCellValue('I3', $this->encabezado_vespertino['turno']);
        $sheet->setCellValue('I4', 'AULA: '.$this->encabezado_vespertino['aula'].' GRUPO: '.$this->encabezado_vespertino['grupo']);

        $sheet->getStyle('A1:O1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2:O2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3:O3')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A4:O4')->getFont()->setBold(true)->setSize(12);

        $sheet->getStyle('A5:O5')->getFont()->setBold(true);
        
        // Centrar todos los datos
        $sheet->getStyle('A5:O' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}