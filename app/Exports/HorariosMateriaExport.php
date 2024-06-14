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
        $daysOfWeek = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        $time_slots = [
            '07:00-07:50',
            '07:50-08:40',
            '08:40-09:30',
            '09:30-10:20',
            '10:20-11:10',
            '11:10-12:00',
            '12:00-12:50',
            '12:50-13:40',
        ];

        // Agregar encabezado personalizado
        $this->data[] = [$this->encabezado['carrera'].' - '.$this->encabezado['periodo'].' | '.$this->encabezado['turno']];
        $this->data[] = ['AULA: '.$this->encabezado['aula'].' GRUPO: '.$this->encabezado['grupo']];
        // Agregar fila vacía
        $this->data[] = [];
        // Agregar encabezados de columnas
        $this->data[] = ['Hora', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

        foreach ($time_slots as $slot) {
            $row = [$slot];
            for ($day = 1; $day <= 5; $day++) {
                $found = false;
                foreach ($this->horarios as $horario) {
                    $startTime = substr($horario['horario_materia']['startTime'], 0, 5);
                    $endTime = substr($horario['horario_materia']['endTime'], 0, 5);
                    $slotTimes = explode('-', $slot);

                    if (in_array($day, $horario['horario_materia']['daysOfWeek']) &&
                        $startTime <= $slotTimes[0] && $endTime > $slotTimes[0]) {
                        $row[] = $horario['horario_materia']['title'];
                        // $this->colors[] = $horario['horario_materia']['color'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $row[] = '';
                    // $this->colors[] = null;
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
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', $this->encabezado['carrera'].' - '.$this->encabezado['periodo'].' | '.$this->encabezado['turno']);
        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', 'AULA: '.$this->encabezado['aula'].' GRUPO: '.$this->encabezado['grupo']);

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A3:F3')->getFont()->setBold(true);

        // Centrar los textos
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:F3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:F4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Centrar todos los datos
        $sheet->getStyle('A5:F' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // // Aplicar colores a las celdas
        // $rowIndex = 4;
        // foreach($this->colors as $index => $color){
        //     if ($color) {
        //         $column = chr(66 + ($index % 5)); // 66 = 'B' en ASCII
        //         $sheet->getStyle($column.$rowIndex)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(str_replace('#', '', $color));
        //     }
        //     if (($index + 1) % 5 == 0) {
        //         $rowIndex++;
        //     }
        // }

        return [];
    }

    public function title(): string
    {
        return 'Horario';
    }
}
