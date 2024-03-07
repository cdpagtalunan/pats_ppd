<?php
namespace App\Exports;

// use App\Model\ShippingInspector;
// use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\FromView;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Illuminate\Support\Facades\DB;
use App\Model\WBSSakidashiIssuance;
use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Sheet;
Use \Maatwebsite\Excel\Sheet;
use App\Model\WBSSakidashiIssuanceItem;
// use Maatwebsite\Excel\Cell\DataType;
// use Maatwebsite\Excel\Concerns\WithDrawings;
// use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
// use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class ExportMoldingTraceabilityReport implements FromView, WithEvents, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return ShippingInspector::all();
    // }
    use Exportable;

    protected $material;
    protected $secondMoldingData;
    protected $secondMoldingInitialData;
    protected $secondMoldingCameraData;
    protected $secondMoldingVisualData;
    protected $assemblyMarkingData;
    protected $assemblyMOData;

    // protected $device_name;

    function __construct(
    $material,
    $secondMoldingData,
    $secondMoldingInitialData,
    $secondMoldingCameraData,
    $secondMoldingVisualData,
    $assemblyMarkingData,
    $assemblyMOData,
    $assemblyVisualData
    ){
        $this->material = $material;
        $this->secondMoldingData = $secondMoldingData;
        $this->secondMoldingInitialData = $secondMoldingInitialData;
        $this->secondMoldingCameraData = $secondMoldingCameraData;
        $this->secondMoldingVisualData = $secondMoldingVisualData;
        $this->assemblyMarkingData = $assemblyMarkingData;
        $this->assemblyMOData = $assemblyMOData;
        $this->assemblyVisualData = $assemblyVisualData;
    }

    public function view(): View
    {
        return view('exports.export_molding_traceability_report', [
        ]);
    }
    public function title(): string{
        return "Traceability Report";
    }

    public function registerEvents(): array
    {
        $material = $this->material;
        $secondMoldingData = $this->secondMoldingData;
        $secondMoldingInitialData = $this->secondMoldingInitialData;
        $secondMoldingCameraData = $this->secondMoldingCameraData;
        $secondMoldingVisualData = $this->secondMoldingVisualData;
        $assemblyMarkingData = $this->assemblyMarkingData;
        $assemblyMOData = $this->assemblyMOData;
        $assemblyVisualData = $this->assemblyVisualData;

        $arial_font12_bold = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  12,
                'bold'      =>  true,
                // 'color'      =>  'red',
                // 'italic'      =>  true
            )
        );

        $arial_font12 = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  12,
                // 'bold'      =>  true,
                // 'color'      =>  'red',
                // 'italic'      =>  true
            )
        );

        $arial_font20 = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  20,
                // 'bold'      =>  true,
                // 'italic'      =>  true
            )
        );

        $arial_font8_bold = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  8,
                'bold'      =>  true,
                // 'italic'      =>  true
            )
        );

        $hv_center = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap' => TRUE
            ]
        );

        $hlv_center = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap' => TRUE
            ]
        );

        $hrv_center = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        );
        $styleBorderBottomThin= [
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $styleBorderAll = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $hlv_top = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                // 'vertical' => Alignment::VERTICAL_TOP,
                'wrap' => TRUE
            ]
        );

        $hcv_top = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_TOP,
                'wrap' => TRUE
            ]
        );



        return [
            AfterSheet::class => function(AfterSheet $event) use(
                $arial_font12_bold,
                $arial_font12,
                $hv_center,
                $hlv_center, 
                $hrv_center,
                $styleBorderBottomThin,
                $styleBorderAll,
                $hlv_top,
                $hcv_top,
                $arial_font20,
                $arial_font8_bold,
                $material,
                $secondMoldingData,
                $secondMoldingInitialData,
                $secondMoldingCameraData,
                $secondMoldingVisualData,
                $assemblyMarkingData,
                $assemblyMOData,
                $assemblyVisualData
            ) {         
                if($material == 'CN171S-07#IN-VE'){ // CN171S
                    $event->sheet->getColumnDimension('A')->setWidth(15);
                    $event->sheet->getColumnDimension('B')->setWidth(15);
                    $event->sheet->getColumnDimension('C')->setWidth(15);
                    $event->sheet->getColumnDimension('D')->setWidth(15);
                    $event->sheet->getColumnDimension('E')->setWidth(15);
                    $event->sheet->getColumnDimension('F')->setWidth(15);
                    $event->sheet->getColumnDimension('G')->setWidth(15);
                    $event->sheet->getColumnDimension('H')->setWidth(15);
                    $event->sheet->getColumnDimension('I')->setWidth(15);
                    $event->sheet->getColumnDimension('J')->setWidth(15);
                    $event->sheet->getColumnDimension('K')->setWidth(15);
                    $event->sheet->getColumnDimension('L')->setWidth(15);
                    $event->sheet->getColumnDimension('M')->setWidth(15);
                    $event->sheet->getColumnDimension('N')->setWidth(15);
                    $event->sheet->getColumnDimension('O')->setWidth(15);
                    $event->sheet->getColumnDimension('P')->setWidth(15);
                    $event->sheet->getColumnDimension('Q')->setWidth(15);
                    $event->sheet->getColumnDimension('R')->setWidth(15);
                    $event->sheet->getColumnDimension('S')->setWidth(15);
                    $event->sheet->getColumnDimension('T')->setWidth(15);
                    $event->sheet->getColumnDimension('U')->setWidth(15);
                    $event->sheet->getColumnDimension('V')->setWidth(15);
                    $event->sheet->getColumnDimension('W')->setWidth(15);
                    $event->sheet->getColumnDimension('X')->setWidth(15);
                    $event->sheet->getColumnDimension('Y')->setWidth(15);
                    $event->sheet->getColumnDimension('Z')->setWidth(15);
                    $event->sheet->getColumnDimension('AA')->setWidth(15);
                    $event->sheet->getColumnDimension('AB')->setWidth(15);
                    $event->sheet->getColumnDimension('AC')->setWidth(15);
                    $event->sheet->getColumnDimension('AD')->setWidth(15);
                    $event->sheet->getColumnDimension('AE')->setWidth(15);
                    $event->sheet->getColumnDimension('AF')->setWidth(15);
                    $event->sheet->getColumnDimension('AG')->setWidth(15);
                    $event->sheet->getColumnDimension('AH')->setWidth(15);
                    $event->sheet->getColumnDimension('AI')->setWidth(15);


                    $event->sheet->setCellValue('A1', $material.'Parts Lot Management Record');
                    $event->sheet->getDelegate()->mergeCells('A1:V1');
                    $event->sheet->getDelegate()->getStyle('A1:V1')->applyFromArray($arial_font12);

                    $event->sheet->getDelegate()->mergeCells('A2:A3');
                    $event->sheet->getDelegate()->mergeCells('B2:B3');
                    $event->sheet->getDelegate()->mergeCells('C2:C3');
                    $event->sheet->getDelegate()->mergeCells('D2:D3');
                    $event->sheet->getDelegate()->mergeCells('E2:E3');
                    $event->sheet->getDelegate()->mergeCells('F2:F3');
                    $event->sheet->getDelegate()->mergeCells('G2:G3');
                    $event->sheet->getDelegate()->mergeCells('H2:H3');
                    $event->sheet->getDelegate()->mergeCells('I2:I3');
                    $event->sheet->getDelegate()->mergeCells('J2:J3');
                    $event->sheet->getDelegate()->mergeCells('K2:K3');
                    $event->sheet->getDelegate()->mergeCells('L2:L3');
                    $event->sheet->getDelegate()->mergeCells('M2:M3');
                    $event->sheet->getDelegate()->mergeCells('N2:N3');
                    $event->sheet->getDelegate()->mergeCells('O2:O3');
                    $event->sheet->getDelegate()->mergeCells('P2:P3');
                    $event->sheet->getDelegate()->mergeCells('Q2:Q3');
                    $event->sheet->getDelegate()->mergeCells('R2:R3');
                    $event->sheet->getDelegate()->mergeCells('S2:S3');
                    $event->sheet->getDelegate()->mergeCells('T2:T3');
                    $event->sheet->getDelegate()->mergeCells('U2:U3');
                    $event->sheet->getDelegate()->mergeCells('V2:V3');
                    $event->sheet->getDelegate()->mergeCells('W2:W3');
                    $event->sheet->getDelegate()->mergeCells('X2:AC2');
                    $event->sheet->getDelegate()->mergeCells('AD2:AD3');
                    $event->sheet->getDelegate()->mergeCells('AE2:AI2');


                    $event->sheet->setCellValue('A2',"投入日 Production Date");
                    $event->sheet->setCellValue('B2',"Shift");
                    $event->sheet->setCellValue('C2',"Production Lot #");
                    $event->sheet->setCellValue('D2',"数量 Prodn Qty");
                    $event->sheet->setCellValue('E2',"Camera Inspection");
                    $event->sheet->setCellValue('F2',"Yield");
                    $event->sheet->setCellValue('G2',"Visual Inspection");
                    $event->sheet->setCellValue('H2',"Yield");
                    $event->sheet->setCellValue('I2',"Over-all Yield");
                    $event->sheet->setCellValue('J2',"Lot Marking");
                    $event->sheet->setCellValue('K2',"Yield");
                    $event->sheet->setCellValue('L2',"MO Assembly");
                    $event->sheet->setCellValue('M2',"Yield");
                    $event->sheet->setCellValue('N2',"Visual Inspection");
                    $event->sheet->setCellValue('O2',"Yield");
                    $event->sheet->setCellValue('P2',"Over-all Yield");
                    $event->sheet->setCellValue('Q2',"Material Name");
                    $event->sheet->setCellValue('R2',"Material Lot # (Resin Lot #)");
                    $event->sheet->setCellValue('S2',"Product Drawing");
                    $event->sheet->setCellValue('T2',"Product Drawing Rev.");
                    $event->sheet->setCellValue('U2',"CAV");
                    $event->sheet->setCellValue('V2',"识别表示 Special adoption document or any special instruction");
                    $event->sheet->setCellValue('W2',"Remarks");

                    $event->sheet->setCellValue('X2',"Operator Name");
                    $event->sheet->setCellValue('X3',"Rotary Machine");
                    $event->sheet->setCellValue('Y3',"Camera Inspection");
                    $event->sheet->setCellValue('Z3',"Visual Inspection");
                    
                    $event->sheet->setCellValue('AA3',"Lot Marking");
                    $event->sheet->setCellValue('AB3',"MO Assembly");
                    $event->sheet->setCellValue('AC3',"Visual Inspection");
                    $event->sheet->setCellValue('AD2',"QC Inspector Name");

                    $event->sheet->setCellValue('AE2',"Parts Name");
                    $event->sheet->setCellValue('AE3',"CN171S-08");
                    $event->sheet->setCellValue('AF3',"CN171S-09");
                    $event->sheet->setCellValue('AG3',"CN171S-10");
                    $event->sheet->setCellValue('AH3',"CN171S-03#ME-VE");
                    $event->sheet->setCellValue('AI3',"CN171S-05#ME-VE");

                    $start_col = 4;
                    $assemblyMarkingSum = '';
                    $assemblyMarkingYield = '';
                    $assemblyMOSum = '';
                    $assemblyMOYield = '';
                    $assemblyVisualSum = '';
                    $assemblyVisualYield = '';
                    for ($i=0; $i < count($secondMoldingData); $i++) { 
                        $created_at = substr($secondMoldingData[$i]->created_at,0,10);

                        $event->sheet->setCellValue('A'.$start_col, $created_at);
                        $event->sheet->setCellValue('C'.$start_col, $secondMoldingData[$i]->production_lot);
                        $event->sheet->setCellValue('Q'.$start_col, $secondMoldingData[$i]->material_name);
                        $event->sheet->setCellValue('R'.$start_col, $secondMoldingData[$i]->material_lot_number);
                        $event->sheet->setCellValue('S'.$start_col, $secondMoldingData[$i]->drawing_number);
                        $event->sheet->setCellValue('T'.$start_col, $secondMoldingData[$i]->revision_number);
                        $event->sheet->setCellValue('X'.$start_col, $secondMoldingData[$i]->r_machine_operator);
                        $event->sheet->setCellValue('AE'.$start_col, $secondMoldingData[$i]->lot_number_eight);
                        $event->sheet->setCellValue('AF'.$start_col, $secondMoldingData[$i]->lot_number_nine);
                        $event->sheet->setCellValue('AG'.$start_col, $secondMoldingData[$i]->lot_number_ten);
                        $event->sheet->setCellValue('AH'.$start_col, $secondMoldingData[$i]->me_name_lot_number_one);
                        $event->sheet->setCellValue('AI'.$start_col, $secondMoldingData[$i]->me_name_lot_number_second);

                        for ($p=0; $p <count($secondMoldingInitialData); $p++) { 
                            if ($secondMoldingData[$i]->id == $secondMoldingInitialData[$p]->sec_molding_runcard_id) {
                                $event->sheet->setCellValue('D'.$start_col, $secondMoldingInitialData[$p]->initial_sum);
                            }
                        }

                        for ($u=0; $u <count($secondMoldingCameraData); $u++) {
                            if ($secondMoldingData[$i]->id == $secondMoldingCameraData[$u]->sec_molding_runcard_id) {
                                    $yield = $secondMoldingCameraData[$u]->camera_yield;

                                    $event->sheet->setCellValue('E'.$start_col, $secondMoldingCameraData[$u]->camera_sum);
                                    $event->sheet->setCellValue('F'.$start_col, $yield.'%');
                                    $event->sheet->setCellValue('Y'.$start_col, $secondMoldingCameraData[$u]->camera_operator);
                            }
                        }

                        for ($o=0; $o <count($secondMoldingVisualData); $o++) { 
                            if ($secondMoldingData[$i]->id == $secondMoldingVisualData[$o]->sec_molding_runcard_id) {
                                    $event->sheet->setCellValue('G'.$start_col, $secondMoldingVisualData[$o]->visual_sum);
                                    $event->sheet->setCellValue('H'.$start_col, $secondMoldingVisualData[$o]->visual_yield/100);
                                    $event->sheet->setCellValue('Z'.$start_col, $secondMoldingVisualData[$o]->visual_operator);
                            }
                        }

                        if($assemblyMarkingData[$i]->s_lot_no != null && $assemblyMarkingData[$i]->s_lot_no == $secondMoldingData[$i]->production_lot){
                            $assemblyMarkingSum = $assemblyMarkingData[$i]->marking_sum;
                            $assemblyMarkingYield = $assemblyMarkingData[$i]->marking_yield;

                            $event->sheet->setCellValue('J'.$start_col, $assemblyMarkingSum);
                            $event->sheet->setCellValue('K'.$start_col, $assemblyMarkingYield.'%');
                            $event->sheet->setCellValue('AA'.$start_col, $assemblyMarkingData[$i]->marking_operator);
                        }
                        else if($assemblyMarkingData[$i]->p_lot_no != null && $assemblyMarkingData[$i]->p_lot_no == $secondMoldingData[$i]->production_lot){
                            $assemblyMarkingSum = $assemblyMarkingData[$i]->marking_sum;
                            $assemblyMarkingYield = $assemblyMarkingData[$i]->marking_yield;

                            $event->sheet->setCellValue('J'.$start_col, $assemblyMarkingSum);
                            $event->sheet->setCellValue('K'.$start_col, $assemblyMarkingYield.'%');
                            $event->sheet->setCellValue('AA'.$start_col, $assemblyMarkingData[$i]->marking_operator);
                        }

                        if($assemblyMOData[$i]->s_lot_no != null && $assemblyMOData[$i]->s_lot_no == $secondMoldingData[$i]->production_lot){
                            $assemblyMOSum = $assemblyMOData[$i]->mo_assembly_sum;
                            $assemblyMOYield = $assemblyMOData[$i]->mo_assembly_yield;

                            $event->sheet->setCellValue('L'.$start_col, $assemblyMOSum);
                            $event->sheet->setCellValue('M'.$start_col, $assemblyMOYield.'%');
                            $event->sheet->setCellValue('AB'.$start_col, $assemblyMOData[$i]->mo_operator);
                        }
                        else if($assemblyMOData[$i]->p_lot_no != null && $assemblyMOData[$i]->p_lot_no == $secondMoldingData[$i]->production_lot){
                            $assemblyMOSum = $assemblyMOData[$i]->mo_assembly_sum;
                            $assemblyMOYield = $assemblyMOData[$i]->mo_assembly_yield;

                            $event->sheet->setCellValue('L'.$start_col, $assemblyMOSum);
                            $event->sheet->setCellValue('M'.$start_col, $assemblyMOYield.'%');
                            $event->sheet->setCellValue('AB'.$start_col, $assemblyMOData[$i]->mo_operator);
                        }

                        if($assemblyVisualData[$i]->s_lot_no != null && $assemblyVisualData[$i]->s_lot_no == $secondMoldingData[$i]->production_lot){
                            $assemblyVisualSum = $assemblyVisualData[$i]->visual_sum;
                            $assemblyVisualYield = $assemblyVisualData[$i]->visual_yield;

                            $event->sheet->setCellValue('N'.$start_col, $assemblyVisualSum);
                            $event->sheet->setCellValue('O'.$start_col, $assemblyVisualYield.'%');
                            $event->sheet->setCellValue('AC'.$start_col, $assemblyVisualData[$i]->visual_operator);
                        }
                        else if($assemblyVisualData[$i]->p_lot_no != null && $assemblyVisualData[$i]->p_lot_no == $secondMoldingData[$i]->production_lot){
                            $assemblyVisualSum = $assemblyVisualData[$i]->visual_sum;
                            $assemblyVisualYield = $assemblyVisualData[$i]->visual_yield;

                            $event->sheet->setCellValue('N'.$start_col, $assemblyVisualSum);
                            $event->sheet->setCellValue('O'.$start_col, $assemblyVisualYield.'%');
                            $event->sheet->setCellValue('AC'.$start_col, $assemblyVisualData[$i]->visual_operator);
                        }

                        $event->sheet->setCellValue('I'.$start_col, ("=(F".$start_col."+H".$start_col.")")."/2");
                        $event->sheet->setCellValue('P'.$start_col, ("=(K".$start_col."+M".$start_col."+O".$start_col.")")."/3");

                        $event->sheet->getDelegate()->getStyle('A4'.':'.'AI'.$start_col)->applyFromArray($styleBorderAll);
                        $start_col++;
                    }

                    $event->sheet->getDelegate()->getStyle('H4'.':'.'H'.$start_col)->getNumberFormat()->setFormatCode('0.00%'); 
                    $event->sheet->getDelegate()->getStyle('I4'.':'.'I'.$start_col)->getNumberFormat()->setFormatCode('0.00%'); 
                    $event->sheet->getDelegate()->getStyle('P4'.':'.'P'.$start_col)->getNumberFormat()->setFormatCode('0.00%'); 
                    $event->sheet->getDelegate()->getStyle('A4'.':'.'AI'.$start_col)->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('A2:AI3')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('A4'.':'.'AI'.$start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('A2:AI3')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('A2:AI3')->applyFromArray($styleBorderAll);
                }
                
                else{ // CN171P
                    $event->sheet->getColumnDimension('A')->setWidth(15);
                    $event->sheet->getColumnDimension('B')->setWidth(15);
                    $event->sheet->getColumnDimension('C')->setWidth(15);
                    $event->sheet->getColumnDimension('D')->setWidth(15);
                    $event->sheet->getColumnDimension('E')->setWidth(15);
                    $event->sheet->getColumnDimension('F')->setWidth(15);
                    $event->sheet->getColumnDimension('G')->setWidth(15);
                    $event->sheet->getColumnDimension('H')->setWidth(15);
                    $event->sheet->getColumnDimension('I')->setWidth(15);
                    $event->sheet->getColumnDimension('J')->setWidth(15);
                    $event->sheet->getColumnDimension('K')->setWidth(15);
                    $event->sheet->getColumnDimension('L')->setWidth(15);
                    $event->sheet->getColumnDimension('M')->setWidth(15);
                    $event->sheet->getColumnDimension('N')->setWidth(15);
                    $event->sheet->getColumnDimension('O')->setWidth(15);
                    $event->sheet->getColumnDimension('P')->setWidth(15);
                    $event->sheet->getColumnDimension('Q')->setWidth(15);
                    $event->sheet->getColumnDimension('R')->setWidth(15);
                    $event->sheet->getColumnDimension('S')->setWidth(15);
                    $event->sheet->getColumnDimension('T')->setWidth(15);
                    $event->sheet->getColumnDimension('U')->setWidth(15);
                    $event->sheet->getColumnDimension('V')->setWidth(15);
                    $event->sheet->getColumnDimension('W')->setWidth(15);
                    $event->sheet->getColumnDimension('X')->setWidth(15);
                    $event->sheet->getColumnDimension('Y')->setWidth(15);
                    $event->sheet->getColumnDimension('Z')->setWidth(15);
                    $event->sheet->getColumnDimension('AA')->setWidth(15);
                    $event->sheet->getColumnDimension('AB')->setWidth(15);
                    $event->sheet->getColumnDimension('AC')->setWidth(15);
                    $event->sheet->getColumnDimension('AD')->setWidth(15);
                    $event->sheet->getColumnDimension('AE')->setWidth(15);
                    $event->sheet->getColumnDimension('AF')->setWidth(15);
                    $event->sheet->getColumnDimension('AG')->setWidth(15);
                    $event->sheet->getColumnDimension('AH')->setWidth(15);
                    $event->sheet->getColumnDimension('AI')->setWidth(15);


                    $event->sheet->setCellValue('A1', $material.' Parts Lot Management Record');
                    $event->sheet->getDelegate()->mergeCells('A1:V1');
                    $event->sheet->getDelegate()->getStyle('A1:V1')->applyFromArray($arial_font12);

                    $event->sheet->getDelegate()->mergeCells('A2:A3');
                    $event->sheet->getDelegate()->mergeCells('B2:B3');
                    $event->sheet->getDelegate()->mergeCells('C2:C3');
                    $event->sheet->getDelegate()->mergeCells('D2:D3');
                    $event->sheet->getDelegate()->mergeCells('E2:E3');
                    $event->sheet->getDelegate()->mergeCells('F2:F3');
                    $event->sheet->getDelegate()->mergeCells('G2:G3');
                    $event->sheet->getDelegate()->mergeCells('H2:H3');
                    $event->sheet->getDelegate()->mergeCells('I2:I3');
                    $event->sheet->getDelegate()->mergeCells('J2:J3');
                    $event->sheet->getDelegate()->mergeCells('K2:K3');
                    $event->sheet->getDelegate()->mergeCells('L2:L3');
                    $event->sheet->getDelegate()->mergeCells('M2:M3');
                    $event->sheet->getDelegate()->mergeCells('N2:N3');
                    $event->sheet->getDelegate()->mergeCells('O2:O3');
                    $event->sheet->getDelegate()->mergeCells('P2:P3');
                    $event->sheet->getDelegate()->mergeCells('Q2:Q3');
                    $event->sheet->getDelegate()->mergeCells('R2:R3');
                    $event->sheet->getDelegate()->mergeCells('S2:S3');
                    $event->sheet->getDelegate()->mergeCells('T2:T3');
                    $event->sheet->getDelegate()->mergeCells('U2:U3');
                    $event->sheet->getDelegate()->mergeCells('V2:V3');
                    $event->sheet->getDelegate()->mergeCells('W2:W3');
                    $event->sheet->getDelegate()->mergeCells('X2:AC2');
                    $event->sheet->getDelegate()->mergeCells('AD2:AD3');
                    $event->sheet->getDelegate()->mergeCells('AE2:AG2');


                    $event->sheet->setCellValue('A2',"投入日 Production Date");
                    $event->sheet->setCellValue('B2',"Shift");
                    $event->sheet->setCellValue('C2',"Production Lot #");
                    $event->sheet->setCellValue('D2',"数量 Prodn Qty");
                    $event->sheet->setCellValue('E2',"Camera Inspection");
                    $event->sheet->setCellValue('F2',"Yield");
                    $event->sheet->setCellValue('G2',"Visual Inspection");
                    $event->sheet->setCellValue('H2',"Yield");
                    $event->sheet->setCellValue('I2',"Over-all Yield");
                    $event->sheet->setCellValue('J2',"Lot Marking");
                    $event->sheet->setCellValue('K2',"Yield");
                    $event->sheet->setCellValue('L2',"MO Assembly");
                    $event->sheet->setCellValue('M2',"Yield");
                    $event->sheet->setCellValue('N2',"Visual Inspection");
                    $event->sheet->setCellValue('O2',"Yield");
                    $event->sheet->setCellValue('P2',"Over-all Yield");
                    $event->sheet->setCellValue('Q2',"Material Name");
                    $event->sheet->setCellValue('R2',"Material Lot # (Resin Lot #)");
                    $event->sheet->setCellValue('S2',"Product Drawing");
                    $event->sheet->setCellValue('T2',"Product Drawing Rev.");
                    $event->sheet->setCellValue('U2',"CAV");
                    $event->sheet->setCellValue('V2',"识别表示 Special adoption document or any special instruction");
                    $event->sheet->setCellValue('W2',"Remarks");

                    $event->sheet->setCellValue('X2',"Operator Name");
                    $event->sheet->setCellValue('X3',"Rotary Machine");
                    $event->sheet->setCellValue('Y3',"Camera Inspection");
                    $event->sheet->setCellValue('Z3',"Visual Inspection");
                    $event->sheet->setCellValue('AA3',"Lot Marking");
                    $event->sheet->setCellValue('AB3',"MO Assembly");
                    $event->sheet->setCellValue('AC3',"Visual Inspection");
                    $event->sheet->setCellValue('AD2',"QC Inspector Name");

                    $event->sheet->setCellValue('AE2',"Parts Name");
                    $event->sheet->setCellValue('AE3',"CT5869-VE");
                    $event->sheet->setCellValue('AF3',"CT5870-VE");
                    $event->sheet->setCellValue('AG3',"CN171P-02#ME-VE");
                    // $event->sheet->setCellValue('AH3',"CN171S-03#ME-VE");
                    // $event->sheet->setCellValue('AI3',"CN171S-05#ME-VE");

                    // $start_col = 4;
                    
                    // for ($i=0; $i < count($secondMoldingData); $i++) { 
                    //     $created_at = substr($secondMoldingData[$i]->created_at,0,10);

                    //     $event->sheet->setCellValue('A'.$start_col, $created_at);
                    //     $event->sheet->setCellValue('C'.$start_col, $secondMoldingData[$i]->production_lot);
                    //     $event->sheet->setCellValue('Q'.$start_col, $secondMoldingData[$i]->material_name);
                    //     $event->sheet->setCellValue('R'.$start_col, $secondMoldingData[$i]->material_lot_number);
                    //     $event->sheet->setCellValue('S'.$start_col, $secondMoldingData[$i]->drawing_number);
                    //     $event->sheet->setCellValue('T'.$start_col, $secondMoldingData[$i]->revision_number);
                    //     $event->sheet->setCellValue('X'.$start_col, $secondMoldingData[$i]->r_machine_operator);
                    //     $event->sheet->setCellValue('AE'.$start_col, $secondMoldingData[$i]->lot_number_eight);
                    //     $event->sheet->setCellValue('AF'.$start_col, $secondMoldingData[$i]->lot_number_nine);
                    //     $event->sheet->setCellValue('AG'.$start_col, $secondMoldingData[$i]->lot_number_ten);
                    //     $event->sheet->setCellValue('AH'.$start_col, $secondMoldingData[$i]->me_name_lot_number_one);
                    //     $event->sheet->setCellValue('AI'.$start_col, $secondMoldingData[$i]->me_name_lot_number_second);

                    //     for ($p=0; $p <count($secondMoldingInitialData) ; $p++) { 
                    //         if ($secondMoldingData[$i]->id == $secondMoldingInitialData[$p]->sec_molding_runcard_id) {
                    //             $event->sheet->setCellValue('D'.$start_col, $secondMoldingInitialData[$p]->initial_sum);
                    //         }
                    //     }

                    //     for ($u=0; $u <count($secondMoldingCameraData) ; $u++) {
                    //         if ($secondMoldingData[$i]->id == $secondMoldingCameraData[$u]->sec_molding_runcard_id) {
                    //             $yield = $secondMoldingCameraData[$i]->camera_yield;
                    //             $event->sheet->setCellValue('E'.$start_col, $secondMoldingCameraData[$i]->camera_sum);
                    //             $event->sheet->setCellValue('F'.$start_col, $yield.'%');
                    //             $event->sheet->setCellValue('Y'.$start_col, $secondMoldingCameraData[$i]->camera_operator);
                    //         }
                    //     }

                    //     for ($o=0; $o <count($secondMoldingVisualData) ; $o++) { 
                    //         if ($secondMoldingData[$i]->id == $secondMoldingVisualData[$o]->sec_molding_runcard_id) {
                    //             $event->sheet->setCellValue('G'.$start_col, $secondMoldingVisualData[$i]->visual_sum);
                    //             $event->sheet->setCellValue('H'.$start_col, $secondMoldingVisualData[$i]->visual_yield/100);
                    //             $event->sheet->setCellValue('Z'.$start_col, $secondMoldingVisualData[$i]->visual_operator);
                    //         }
                    //     }

                    //     if($assemblyMarkingData[$i]->s_lot_no != null && $assemblyMarkingData[$i]->s_lot_no == $secondMoldingData[$i]->production_lot){
                    //         $assemblyMarkingSum = $assemblyMarkingData[$i]->marking_sum;
                    //         $assemblyMarkingYield = $assemblyMarkingData[$i]->marking_yield;

                    //         $event->sheet->setCellValue('J'.$start_col, $assemblyMarkingSum);
                    //         $event->sheet->setCellValue('K'.$start_col, $assemblyMarkingYield.'%');
                    //         $event->sheet->setCellValue('AA'.$start_col, $assemblyMarkingData[$i]->marking_operator);
                    //     }
                    //     else if($assemblyMarkingData[$i]->p_lot_no != null && $assemblyMarkingData[$i]->p_lot_no == $secondMoldingData[$i]->production_lot){
                    //         $assemblyMarkingSum = $assemblyMarkingData[$i]->marking_sum;
                    //         $assemblyMarkingYield = $assemblyMarkingData[$i]->marking_yield;

                    //         $event->sheet->setCellValue('J'.$start_col, $assemblyMarkingSum);
                    //         $event->sheet->setCellValue('K'.$start_col, $assemblyMarkingYield.'%');
                    //         $event->sheet->setCellValue('AA'.$start_col, $assemblyMarkingData[$i]->marking_operator);
                    //     }

                    //     if($assemblyMOData[$i]->s_lot_no != null && $assemblyMOData[$i]->s_lot_no == $secondMoldingData[$i]->production_lot){
                    //         $assemblyMOSum = $assemblyMOData[$i]->mo_assembly_sum;
                    //         $assemblyMOYield = $assemblyMOData[$i]->mo_assembly_yield;

                    //         $event->sheet->setCellValue('L'.$start_col, $assemblyMOSum);
                    //         $event->sheet->setCellValue('M'.$start_col, $assemblyMOYield.'%');
                    //         $event->sheet->setCellValue('AB'.$start_col, $assemblyMOData[$i]->mo_operator);
                    //     }
                    //     else if($assemblyMOData[$i]->p_lot_no != null && $assemblyMOData[$i]->p_lot_no == $secondMoldingData[$i]->production_lot){
                    //         $assemblyMOSum = $assemblyMOData[$i]->mo_assembly_sum;
                    //         $assemblyMOYield = $assemblyMOData[$i]->mo_assembly_yield;

                    //         $event->sheet->setCellValue('L'.$start_col, $assemblyMOSum);
                    //         $event->sheet->setCellValue('M'.$start_col, $assemblyMOYield.'%');
                    //         $event->sheet->setCellValue('AB'.$start_col, $assemblyMOData[$i]->mo_operator);
                    //     }

                    //     if($assemblyVisualData[$i]->s_lot_no != null && $assemblyVisualData[$i]->s_lot_no == $secondMoldingData[$i]->production_lot){
                    //         $assemblyVisualSum = $assemblyVisualData[$i]->visual_sum;
                    //         $assemblyVisualYield = $assemblyVisualData[$i]->visual_yield;

                    //         $event->sheet->setCellValue('N'.$start_col, $assemblyVisualSum);
                    //         $event->sheet->setCellValue('O'.$start_col, $assemblyVisualYield.'%');
                    //         $event->sheet->setCellValue('AC'.$start_col, $assemblyVisualData[$i]->visual_operator);
                    //     }
                    //     else if($assemblyVisualData[$i]->p_lot_no != null && $assemblyVisualData[$i]->p_lot_no == $secondMoldingData[$i]->production_lot){
                    //         $assemblyVisualSum = $assemblyVisualData[$i]->visual_sum;
                    //         $assemblyVisualYield = $assemblyVisualData[$i]->visual_yield;

                    //         $event->sheet->setCellValue('N'.$start_col, $assemblyVisualSum);
                    //         $event->sheet->setCellValue('O'.$start_col, $assemblyVisualYield.'%');
                    //         $event->sheet->setCellValue('AC'.$start_col, $assemblyVisualData[$i]->visual_operator);
                    //     }

                    //     $event->sheet->setCellValue('I'.$start_col, ("=(F".$start_col."+H".$start_col.")")."/2");
                    //     $event->sheet->setCellValue('P'.$start_col, ("=(K".$start_col."+M".$start_col."+O".$start_col.")")."/3");

                    //     $event->sheet->getDelegate()->getStyle('A4'.':'.'AG'.$start_col)->applyFromArray($styleBorderAll);

                    //     $start_col++;
                    // }

                    // // $event->sheet->getDelegate()->getStyle('H4'.':'.'H'.$start_col)->getNumberFormat()->setFormatCode('0.00%'); 
                    // $event->sheet->getDelegate()->getStyle('A4'.':'.'AG'.$start_col)->getAlignment()->setWrapText(true);
                    // $event->sheet->getDelegate()->getStyle('A2:AG3')->applyFromArray($hv_center);
                    // $event->sheet->getDelegate()->getStyle('A4'.':'.'AG'.$start_col)->applyFromArray($hv_center);
                    // $event->sheet->getDelegate()->getStyle('A2:AG3')->getAlignment()->setWrapText(true);
                    // $event->sheet->getDelegate()->getStyle('A2:AG3')->applyFromArray($styleBorderAll);
                }


            },
        ];
    }

}


