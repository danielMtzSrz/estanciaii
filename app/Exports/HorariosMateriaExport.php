<?php

namespace App\Exports;

use App\Models\GestionAcademica\GrupoMateria;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class HorariosMateriaExport implements FromArray, WithStyles, ShouldAutoSize, WithTitle
{
    protected $horarios;
    protected $encabezado;
    protected $data = [];
    protected $colors = [];

    public function __construct(array $horarios, array $encabezado)
    {
        $this->horarios = $horarios;
        $this->encabezado = $encabezado;
        $this->prepareData();
    }

    protected function prepareData()
    {
        $daysOfWeek = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $time_slots = array_merge(
            config('staticdata.dates.horario_matutino'),
            config('staticdata.dates.horario_vespertino')
        );

        // Agregar encabezado personalizado
        $this->data[] = [''];
        $this->data[] = [''];
        $this->data[] = [''];
        $this->data[] = [''];
        
        // Agregar encabezados de columnas
        $this->data[] = ['Hora', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        foreach ($time_slots as $slotIndex => $slot) {
            $row = [$slot];
            for ($day = 1; $day <= 6; $day++) {
                $found = false;
                foreach ($this->horarios as $horario) {
                    foreach ($horario['horario_materia'] as $horario_materia) {
                        $startTime = substr($horario_materia['startTime'], 0, 5);
                        $endTime = substr($horario_materia['endTime'], 0, 5);
                        $slotTimes = explode('-', $slot);

                        if (in_array($day, $horario_materia['daysOfWeek']) &&
                            $startTime <= $slotTimes[0] && $endTime > $slotTimes[0]) {
                            $row[] = $horario_materia['title'];
                            $this->colors[] = ['column' => $day, 'index' => $slotIndex + 6, 'color' => $horario_materia['color']];
                            $found = true;
                            break 2; // Salir de ambos bucles
                        }
                    }
                }
                if(!$found) {
                    $row[] = '';
                    $this->colors[] = null; // Descomentar si usas colores
                }
            }
            $this->data[] = $row;
        }
    }

    public function array(): array
    {
        return $this->data;
    }

    public function styles(Worksheet $sheet)
    {
        // Estilos para el encabezado general y las filas de datos
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');
        $sheet->mergeCells('A4:G4');
        $sheet->setCellValue('A1', $this->encabezado['carrera']);
        $sheet->setCellValue('A2', $this->encabezado['periodo']);
        $sheet->setCellValue('A3', $this->encabezado['turno']);
        $sheet->setCellValue('A4', 'AULA: '.$this->encabezado['aula'].' GRUPO: '.$this->encabezado['grupo']);
        
        $sheet->getStyle('A1:G3')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A4:G4')->getFont()->setBold(true)->setSize(12);

        $sheet->getStyle('A5:G5')->getFont()->setBold(true);

        // Centrar todos los datos
        $sheet->getStyle('A1:G' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Aplicar colores a las celdas
        foreach($this->colors as $color) {
            if($color){
                $column = chr(65 + $color['column']); // Convertir el índice de columna a letra
                $cell = $column . $color['index'];
                $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(str_replace('#', '', $color['color']));
            }
        }

        return [];
    }

    public function title(): string
    {
        return 'Horario';
    }
}
