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

        dd($this->horarios);

        // Agregar encabezado personalizado
        $this->data[] = [$this->encabezado['carrera'].' - '.$this->encabezado['periodo'].' | '.$this->encabezado['turno']];
        $this->data[] = ['AULA: '.$this->encabezado['aula'].' GRUPO: '.$this->encabezado['grupo']];
        // Agregar fila vacía
        $this->data[] = [];
        // Agregar encabezados de columnas
        $this->data[] = ['Hora', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        foreach ($time_slots as $slot) {
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
                            // $this->colors[] = $horario_materia['color']; // Descomentar si usas colores
                            $found = true;
                            break 2; // Salir de ambos bucles
                        }
                    }
                }
                if (!$found) {
                    $row[] = '';
                    // $this->colors[] = null; // Descomentar si usas colores
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
        $sheet->setCellValue('A1', $this->encabezado['carrera'].' - '.$this->encabezado['periodo'].' | '.$this->encabezado['turno']);
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'AULA: '.$this->encabezado['aula'].' GRUPO: '.$this->encabezado['grupo']);

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A3:G3')->getFont()->setBold(true);

        // Centrar los textos
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:G3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:G4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Centrar todos los datos
        $sheet->getStyle('A5:G' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

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
