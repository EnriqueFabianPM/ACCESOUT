<?php

namespace App\Exports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style;
use PhpOffice\PhpSpreadsheet\Style\Style as DefaultStyles;


class EstudiantesSheetExport implements WithTitle, WithHeadings, FromQuery, WithMapping, WithColumnWidths, ShouldAutoSize, WithStyles, WithEvents
{
    use RegistersEventListeners;
    public $user;

    public function __construct (Estudiante $estudiante) {
        $this->estudiante = $estudiante;
    }

    /**
     * @return string
     */
    public function title(): string {
        return $this->estudiante->nombre;
    }

    public function headings (): array {
        return [
            'identificador',
            'Fotoqr',
            'Foto',
            'nombre',
            'apellidos',
            'semestre',
            'grupo',
            'email',
        ];
    }

    public function query() {
        return Estudiante::where('identificador', $this->estudiante->identificador);
    }

    public function map($row): array {
        return [
            $row['identificador'],
            $row['Fotoqr'],
            $row['Foto'],
            $row['nombre'],
            $row['apellidos'],
            $row['semestre'],
            $row['grupo'],
            $row['email'],
        ];
    }

    public function columnWidths(): array {
        return [
            'B'=> 25
        ];
    }

    public function styles(Worksheet $sheet) {
        // return [
        //     '1' => ['font' => ['bold' => true]],
        // ];
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('B1:B'.$sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }

    /**
     * @return array|void
     */
    public function defaultStyles(DefaultStyles $defaultStyle)
    {
        return [
            'font' => [
                'name' => 'Calibri',
                'size' => 12
            ],
            'alignment' => [
                'horizontal' => Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => Style\Alignment::VERTICAL_CENTER,
            ],
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        return $event->sheet->getDelegate()->setRightToLeft(true);
    }
}