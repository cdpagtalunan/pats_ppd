<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;

Use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

// use Maatwebsite\Excel\Concerns\WithMultipleSheets;
// use Maatwebsite\Excel\Concerns\WithDrawings;
// use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use PhpOffice\PhpSpreadsheet\Style\Alignment;



class OqcInspectionSheet implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    use Exportable;
    protected $search_po;
    protected $stamping;

    //
    function __construct(
        $search_po,
        $stamping
    ){
        $this->search_po = $search_po;
        $this->stamping = $stamping;
    }

    public function view(): View {
        return view('exports.export_report', ['search_po' => $this->search_po, 'process_type' => $this->stamping]);
    }

    public function title(): string{
        return 'OQC Inspection Report';
    }

    //for designs
    public function registerEvents(): array{
        $search_po = $this->search_po;
        $stamping = $this->stamping;

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $text_center = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap' => TRUE
            ]
        );

        $text_align_left = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'wrap' => TRUE
            ]
        );

        $font_8_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  8,
                'bold'      =>  true,
            ]
        );

        $font_9_arial = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  9,
            ]
        );

        $font_9_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  9,
                'bold'      =>  true,
            ]
        );

        $font_12_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  12,
                'bold'      =>  true,
            ]
        );

        $font_13_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  13,
                'bold'      =>  true,
            ]
        );

        return[AfterSheet::class => function(AfterSheet $event) use(
            $search_po, 
            $stamping, 
            $border, 
            $text_center, 
            $text_align_left, 
            $font_8_arial_bold, 
            $font_9_arial, 
            $font_9_arial_bold, 
            $font_12_arial_bold, 
            $font_13_arial_bold
        ){
            //==================== Excel Format =========================
            // $event->sheet->getDelegate()->getStyle('A1:P2')
            // ->getFill()
            // ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            // ->getStartColor()
            // ->setARGB('B7D8FF');

            // $event->sheet->getDelegate()->getStyle('A3:P4')
            // ->getFill()
            // ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            // ->getStartColor()
            // ->setARGB('E5FF75');

            // $event->sheet->getDelegate()->getStyle('A5:L6')
            // ->getFill()
            // ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            // ->getStartColor()
            // ->setARGB('70ECF9');

            $event->sheet->getDelegate()->getStyle('A7:P7')->applyFromArray($border);

            $event->sheet->getColumnDimension('A')->setWidth(18);
            $event->sheet->getColumnDimension('B')->setWidth(18);
            $event->sheet->getColumnDimension('C')->setWidth(10);
            $event->sheet->getColumnDimension('D')->setWidth(18);
            $event->sheet->getColumnDimension('E')->setWidth(15);
            $event->sheet->getColumnDimension('F')->setWidth(18);
            $event->sheet->getColumnDimension('G')->setWidth(18);
            $event->sheet->getColumnDimension('H')->setWidth(18);
            $event->sheet->getColumnDimension('I')->setWidth(10);
            $event->sheet->getColumnDimension('J')->setWidth(10);
            $event->sheet->getColumnDimension('K')->setWidth(15);
            $event->sheet->getColumnDimension('L')->setWidth(15);
            $event->sheet->getColumnDimension('M')->setWidth(15);
            $event->sheet->getColumnDimension('N')->setWidth(15);
            $event->sheet->getColumnDimension('O')->setWidth(18);
            $event->sheet->getColumnDimension('P')->setWidth(18);

            $event->sheet->getDelegate()->mergeCells('A1:Q2');

            $event->sheet->getDelegate()->mergeCells('B3:F3');
            $event->sheet->getDelegate()->mergeCells('B4:F4');
            $event->sheet->getDelegate()->mergeCells('B5:F5');

            $event->sheet->getDelegate()->mergeCells('H3:L3');
            $event->sheet->getDelegate()->mergeCells('H4:L4');
            $event->sheet->getDelegate()->mergeCells('H5:L5');

            $event->sheet->getDelegate()->mergeCells('N3:Q3');
            $event->sheet->getDelegate()->mergeCells('N4:Q4');
            $event->sheet->getDelegate()->mergeCells('N5:Q5');

            $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($text_center)->applyFromArray($font_13_arial_bold)->getAlignment()->setWrapText(true);
            $event->sheet->getDelegate()->getStyle('A7:Q7')->applyFromArray($text_center)->applyFromArray($font_9_arial_bold)->getAlignment()->setWrapText(true);
            
            $event->sheet->getDelegate()->getStyle('A3:A5')->applyFromArray($font_9_arial_bold)->getAlignment()->setWrapText(true);
            $event->sheet->getDelegate()->getStyle('G3:G5')->applyFromArray($font_9_arial_bold)->getAlignment();
            $event->sheet->getDelegate()->getStyle('M3:M5')->applyFromArray($font_9_arial_bold)->getAlignment()->setWrapText(true);
            
            $event->sheet->getDelegate()->getStyle('B3:B5')->applyFromArray($text_align_left)->getAlignment()->setWrapText(true);
            $event->sheet->getDelegate()->getStyle('H3:H5')->applyFromArray($text_align_left)->getAlignment()->setWrapText(true);
            $event->sheet->getDelegate()->getStyle('N3:N5')->applyFromArray($text_align_left)->getAlignment()->setWrapText(true);
            
            $event->sheet->setCellValue('A1', $stamping." OQC INSPECTION SUMMARY");

            $event->sheet->setCellValue('A3', "Part Name:");
            $event->sheet->setCellValue('A4', "Part Code:");
            $event->sheet->setCellValue('A5', "Customer:");

            $event->sheet->setCellValue('G3', "Type of Inspection:");
            $event->sheet->setCellValue('G4', "Inspection Level:");
            $event->sheet->setCellValue('G5', "AQL:");

            $event->sheet->setCellValue('M3', "Accept:");
            $event->sheet->setCellValue('M4', "Reject:");

            $event->sheet->setCellValue('A7',"FY-WW         ");
            $event->sheet->setCellValue('B7',"  Date \n Inspected");
            $event->sheet->setCellValue('C7',"  Shift");
            $event->sheet->setCellValue('D7',"  Time \n Inspected");
            $event->sheet->setCellValue('E7',"  Submission");
            $event->sheet->setCellValue('F7',"  P.O Number");
            $event->sheet->setCellValue('G7',"  Severity of \n Inspection");
            $event->sheet->setCellValue('H7',"  Lot \n Number");
            $event->sheet->setCellValue('I7',"  Lot \n Quantity");
            $event->sheet->setCellValue('J7',"  Sample \n Size");
            $event->sheet->setCellValue('K7',"  No. of \n Defective");
            $event->sheet->setCellValue('L7',"  Mode of \n Defect");
            $event->sheet->setCellValue('M7',"  Defect \n Quantity");
            $event->sheet->setCellValue('N7',"  Judgement");
            $event->sheet->setCellValue('O7',"  QC Inspector");
            $event->sheet->setCellValue('P7',"  Remarks");
            
            $event->sheet->setCellValue('B3',$search_po[0]->stamping_production_info->material_name);
            $event->sheet->setCellValue('B4',$search_po[0]->stamping_production_info->part_code);
            $event->sheet->setCellValue('B5',$search_po[0]->customer);

            $event->sheet->setCellValue('H3',$search_po[0]->oqc_inspection_type_info->inspection_type);
            $event->sheet->setCellValue('H4',$search_po[0]->oqc_inspection_level_info->inspection_level);
            $event->sheet->setCellValue('H5',$search_po[0]->oqc_inspection_aql_info->aql);

            $start_column = 8;
            $accept_sum = 0;
            $reject_sum = 0;
            for ($i=0; $i < count($search_po); $i++){
                $event
                    ->sheet
                    ->getDelegate()
                    ->getStyle('A'.$start_column.':P'.$start_column)
                    ->applyFromArray($border)
                    ->applyFromArray($text_center)
                    ->applyFromArray($font_9_arial)
                    ->getAlignment()
                    ->setWrapText(true);
                
                $event
                    ->sheet
                    ->getDelegate()
                    ->getStyle('F'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode('0');

                $event->sheet->setCellValue('A'.$start_column,$search_po[$i]->fy.'-'.$search_po[$i]->ww);
                $event->sheet->setCellValue('B'.$start_column,date("m-d-Y", strtotime($search_po[$i]->date_inspected)));
                $event->sheet->setCellValue('C'.$start_column,$search_po[$i]->shift);
                $event->sheet->setCellValue('D'.$start_column,date("h:i a", strtotime($search_po[$i]->time_ins_from)).' - '.date("h:i a",strtotime($search_po[$i]->time_ins_to)));
                $event->sheet->setCellValue('E'.$start_column,$search_po[$i]->submission);
                $event->sheet->setCellValue('F'.$start_column,$search_po[$i]->po_no);
                $event->sheet->setCellValue('G'.$start_column,$search_po[$i]->oqc_inspection_severity_inspection_info->severity_inspection);
                $event->sheet->setCellValue('H'.$start_column,$search_po[$i]->stamping_production_info->prod_lot_no);
                $event->sheet->setCellValue('I'.$start_column,$search_po[$i]->stamping_production_info->ship_output);
                $event->sheet->setCellValue('J'.$start_column,$search_po[$i]->sample_size);
                
                if($search_po[$i]->judgement == 'Reject'){
                    $event->sheet->setCellValue('K'.$start_column,$search_po[$i]->num_of_defects);

                    $mod_array = [];
                    $mod_qty_array = [];        
                    for($x=0; $x < count($search_po[$i]->mod_oqc_inspection_details); $x++){
                        array_push($mod_array, $search_po[$i]->mod_oqc_inspection_details[$x]->oqc_info_mod_info->mode_of_defects);
                        array_push($mod_qty_array, $search_po[$i]->mod_oqc_inspection_details[$x]->mod_qty);
                        $event->sheet->setCellValue('L'.$start_column,"\n".implode("\n", $mod_array)."\n");
                        $event->sheet->setCellValue('M'.$start_column,"\n".implode("\n", $mod_qty_array)."\n");
                    }
                }

                $event->sheet->setCellValue('N3',$accept_sum += $search_po[$i]->accept);
                $event->sheet->setCellValue('N4',$reject_sum += $search_po[$i]->reject);

                $event->sheet->setCellValue('N'.$start_column,$search_po[$i]->judgement);
                $event->sheet->setCellValue('O'.$start_column,$search_po[$i]->inspector);
                $event->sheet->setCellValue('P'.$start_column,$search_po[$i]->remarks);

                $start_column++;
            }
        }];
    }
}
