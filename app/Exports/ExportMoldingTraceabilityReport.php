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
    protected $secondMoldingFirstOqcData;
    protected $assemblyMarkingData;
    protected $assemblyMOData;
    protected $assemblyVisualData;

    // protected $device_name;

    function __construct(
    $material,
    $secondMoldingData,
    $secondMoldingInitialData,
    $secondMoldingCameraData,
    $secondMoldingVisualData,
    $secondMoldingFirstOqcData,
    $assemblyMarkingData,
    $assemblyMOData,
    $assemblyVisualData
    ){
        $this->material = $material;
        $this->secondMoldingData = $secondMoldingData;
        $this->secondMoldingInitialData = $secondMoldingInitialData;
        $this->secondMoldingCameraData = $secondMoldingCameraData;
        $this->secondMoldingVisualData = $secondMoldingVisualData;
        $this->secondMoldingFirstOqcData = $secondMoldingFirstOqcData;
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
        $secondMoldingFirstOqcData = $this->secondMoldingFirstOqcData;
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
                $secondMoldingFirstOqcData,
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
                    $event->sheet->getColumnDimension('AJ')->setWidth(15);
                    $event->sheet->getColumnDimension('AK')->setWidth(15);
                    $event->sheet->getColumnDimension('AL')->setWidth(15);
                    $event->sheet->getColumnDimension('AM')->setWidth(15);
                    $event->sheet->getColumnDimension('AN')->setWidth(15);



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
                    $event->sheet->getDelegate()->mergeCells('X2:X3');
                    $event->sheet->getDelegate()->mergeCells('Y2:Y3');
                    $event->sheet->getDelegate()->mergeCells('Z2:Z3');
                    $event->sheet->getDelegate()->mergeCells('AA2:AA3');
                    $event->sheet->getDelegate()->mergeCells('AB2:AB3');
                    $event->sheet->getDelegate()->mergeCells('AB2:AB3');
                    $event->sheet->getDelegate()->mergeCells('AC2:AC3');
                    $event->sheet->getDelegate()->mergeCells('AD2:AH2');
                    $event->sheet->getDelegate()->mergeCells('AI2:AI3');
                    $event->sheet->getDelegate()->mergeCells('AJ2:AN2');


                    $event->sheet->setCellValue('A2',"投入日 Production Date");
                    $event->sheet->setCellValue('B2',"Shift");
                    $event->sheet->setCellValue('C2',"Production Lot #");
                    $event->sheet->setCellValue('D2',"数量 Prodn Qty");
                    $event->sheet->setCellValue('E2',"Camera Inspection");
                    $event->sheet->setCellValue('F2',"Yield");
                    $event->sheet->setCellValue('G2',"Visual Inspection");
                    $event->sheet->setCellValue('H2',"Yield");
                    $event->sheet->setCellValue('I2',"Over-all Yield");
                    $event->sheet->setCellValue('J2',"1st OQC");
                    $event->sheet->setCellValue('K2',"DPPM");
                    $event->sheet->setCellValue('L2',"LAR");
                    $event->sheet->setCellValue('M2',"Lot Marking");
                    $event->sheet->setCellValue('N2',"Yield");
                    $event->sheet->setCellValue('O2',"MO Assembly");
                    $event->sheet->setCellValue('P2',"Yield");
                    $event->sheet->setCellValue('Q2',"Visual Inspection");
                    $event->sheet->setCellValue('R2',"Yield");
                    $event->sheet->setCellValue('S2',"Over-all Yield");
                    $event->sheet->setCellValue('T2',"Final OQC");
                    $event->sheet->setCellValue('U2',"DPPM");
                    $event->sheet->setCellValue('V2',"LAR");
                    $event->sheet->setCellValue('W2',"Material Name");
                    $event->sheet->setCellValue('X2',"Material Lot # (Resin Lot #)");
                    $event->sheet->setCellValue('Y2',"Product Drawing");
                    $event->sheet->setCellValue('Z2',"Product Drawing Rev.");
                    $event->sheet->setCellValue('AA2',"CAV");
                    $event->sheet->setCellValue('AB2',"识别表示 Special adoption document or any special instruction");
                    $event->sheet->setCellValue('AC2',"Remarks");

                    $event->sheet->setCellValue('AD2',"Operator Name");
                    $event->sheet->setCellValue('AD3',"Rotary Machine");
                    $event->sheet->setCellValue('AE3',"Camera Inspection");
                    $event->sheet->setCellValue('AF3',"Visual Inspection");
                    
                    $event->sheet->setCellValue('AG2',"Lot Marking");
                    $event->sheet->setCellValue('AG3',"MO Assembly");
                    $event->sheet->setCellValue('AH3',"Visual Inspection");
                    $event->sheet->setCellValue('AI2',"QC Inspector Name");

                    $event->sheet->setCellValue('AJ2',"Parts Name");
                    $event->sheet->setCellValue('AJ3',"CN171S-08");
                    $event->sheet->setCellValue('AK3',"CN171S-09");
                    $event->sheet->setCellValue('AL3',"CN171S-10");
                    $event->sheet->setCellValue('AM3',"CN171S-03#ME-VE");
                    $event->sheet->setCellValue('AN3',"CN171S-05#ME-VE");

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
                        $event->sheet->setCellValue('W'.$start_col, $secondMoldingData[$i]->material_name);
                        $event->sheet->setCellValue('X'.$start_col, $secondMoldingData[$i]->material_lot_number);
                        $event->sheet->setCellValue('Y'.$start_col, $secondMoldingData[$i]->drawing_number);
                        $event->sheet->setCellValue('Z'.$start_col, $secondMoldingData[$i]->revision_number);
                        $event->sheet->setCellValue('AD'.$start_col, $secondMoldingData[$i]->r_machine_operator);
                        $event->sheet->setCellValue('AJ'.$start_col, $secondMoldingData[$i]->lot_number_eight);
                        $event->sheet->setCellValue('AK'.$start_col, $secondMoldingData[$i]->lot_number_nine);
                        $event->sheet->setCellValue('AL'.$start_col, $secondMoldingData[$i]->lot_number_ten);
                        $event->sheet->setCellValue('AM'.$start_col, $secondMoldingData[$i]->me_name_lot_number_one);
                        $event->sheet->setCellValue('AN'.$start_col, $secondMoldingData[$i]->me_name_lot_number_second);



                        for ($p=0; $p <count($secondMoldingInitialData); $p++) { 
                            if ($secondMoldingData[$i]->id == $secondMoldingInitialData[$p]->sec_molding_runcard_id) {
                                $event->sheet->setCellValue('D'.$start_col, $secondMoldingInitialData[$p]->initial_sum);
                            }
                        }

                        for ($u=0; $u < count($secondMoldingCameraData); $u++) {
                            if ($secondMoldingData[$i]->id == $secondMoldingCameraData[$u]->sec_molding_runcard_id) {
                                    $yield = $secondMoldingCameraData[$u]->camera_yield;

                                    $event->sheet->setCellValue('E'.$start_col, $secondMoldingCameraData[$u]->camera_sum);
                                    $event->sheet->setCellValue('F'.$start_col, $yield.'%');
                                    $event->sheet->setCellValue('AE'.$start_col, $secondMoldingCameraData[$u]->camera_operator);
                            }
                        }

                        for ($o=0; $o <count($secondMoldingVisualData); $o++) { 
                            if ($secondMoldingData[$i]->id == $secondMoldingVisualData[$o]->sec_molding_runcard_id) {
                                    $event->sheet->setCellValue('G'.$start_col, $secondMoldingVisualData[$o]->visual_sum);
                                    $event->sheet->setCellValue('H'.$start_col, $secondMoldingVisualData[$o]->visual_yield / 100);
                                    $event->sheet->setCellValue('AF'.$start_col, $secondMoldingVisualData[$o]->visual_operator);
                            }
                        }

                        for ($v=0; $v <count($secondMoldingFirstOqcData); $v++) { 
                            if ($secondMoldingData[$i]->id == $secondMoldingFirstOqcData[$v]->sec_molding_runcard_id){

                                $dppm = ($secondMoldingFirstOqcData[$v]->no_of_defects / $secondMoldingFirstOqcData[$v]->sample_size) * 1000000;
                                $lar = ($secondMoldingFirstOqcData[$v]->lot_accepted / $secondMoldingFirstOqcData[$v]->lot_inspected) * 100;
                                
                                $event->sheet->setCellValue('J'.$start_col, $secondMoldingFirstOqcData[$v]->first_oqc_sum);
                                $event->sheet->setCellValue('K'.$start_col, $dppm);
                                $event->sheet->setCellValue('L'.$start_col, $lar.'%');
                                
                            }
                        }


                        if(isset($assemblyMarkingData)){
                            for ($z=0; $z <count($assemblyMarkingData); $z++) { 
                                if($assemblyMarkingData[$z]->s_lot_no != null && $assemblyMarkingData[$z]->s_lot_no == $secondMoldingData[$i]->production_lot){
                                    $assemblyMarkingSum = $assemblyMarkingData[$z]->marking_sum;
                                    $assemblyMarkingYield = $assemblyMarkingData[$z]->marking_yield;
        
                                    $event->sheet->setCellValue('M'.$start_col, $assemblyMarkingSum);
                                    $event->sheet->setCellValue('N'.$start_col, $assemblyMarkingYield.'%');
                                    $event->sheet->setCellValue('AG'.$start_col, $assemblyMarkingData[$z]->marking_operator);
                                }
                                else if($assemblyMarkingData[$z]->p_lot_no != null && $assemblyMarkingData[$z]->p_lot_no == $secondMoldingData[$i]->production_lot){
                                    $assemblyMarkingSum = $assemblyMarkingData[$z]->marking_sum;
                                    $assemblyMarkingYield = $assemblyMarkingData[$z]->marking_yield;
        
                                    $event->sheet->setCellValue('M'.$start_col, $assemblyMarkingSum);
                                    $event->sheet->setCellValue('N'.$start_col, $assemblyMarkingYield.'%');
                                    $event->sheet->setCellValue('AG'.$start_col, $assemblyMarkingData[$z]->marking_operator);
                                }
                            }                            
                        }
                
                        if(isset($assemblyMOData)){
                            for ($x=0; $x <count($assemblyMOData); $x++) { 
                                if($assemblyMOData[$x]->s_lot_no != null && $assemblyMOData[$x]->s_lot_no == $secondMoldingData[$i]->production_lot){
                                    $assemblyMOSum = $assemblyMOData[$x]->mo_assembly_sum;
                                    $assemblyMOYield = $assemblyMOData[$x]->mo_assembly_yield;
        
                                    $event->sheet->setCellValue('O'.$start_col, $assemblyMOSum);
                                    $event->sheet->setCellValue('P'.$start_col, $assemblyMOYield.'%');
                                    $event->sheet->setCellValue('AG'.$start_col, $assemblyMOData[$x]->mo_operator);
                                }
                                else if($assemblyMOData[$x]->p_lot_no != null && $assemblyMOData[$x]->p_lot_no == $secondMoldingData[$i]->production_lot){
                                    $assemblyMOSum = $assemblyMOData[$x]->mo_assembly_sum;
                                    $assemblyMOYield = $assemblyMOData[$x]->mo_assembly_yield;
        
                                    $event->sheet->setCellValue('O'.$start_col, $assemblyMOSum);
                                    $event->sheet->setCellValue('P'.$start_col, $assemblyMOYield.'%');
                                    $event->sheet->setCellValue('AG'.$start_col, $assemblyMOData[$x]->mo_operator);
                                }
                            }
                            
                        }
                    
                        if(isset($assemblyVisualData)){
                            for ($c=0; $c <count($assemblyVisualData); $c++) { 
                                if($assemblyVisualData[$c]->s_lot_no != null && $assemblyVisualData[$c]->s_lot_no == $secondMoldingData[$i]->production_lot){
                                    $assemblyVisualSum = $assemblyVisualData[$c]->visual_sum;
                                    $assemblyVisualYield = $assemblyVisualData[$c]->visual_yield;
        
                                    $event->sheet->setCellValue('Q'.$start_col, $assemblyVisualSum);
                                    $event->sheet->setCellValue('R'.$start_col, $assemblyVisualYield.'%');
                                    $event->sheet->setCellValue('AH'.$start_col, $assemblyVisualData[$c]->visual_operator);
                                }
                                else if($assemblyVisualData[$c]->p_lot_no != null && $assemblyVisualData[$c]->p_lot_no == $secondMoldingData[$i]->production_lot){
                                    $assemblyVisualSum = $assemblyVisualData[$c]->visual_sum;
                                    $assemblyVisualYield = $assemblyVisualData[$c]->visual_yield;
        
                                    $event->sheet->setCellValue('Q'.$start_col, $assemblyVisualSum);
                                    $event->sheet->setCellValue('R'.$start_col, $assemblyVisualYield.'%');
                                    $event->sheet->setCellValue('AH'.$start_col, $assemblyVisualData[$c]->visual_operator);
                                }
                            }
                        }
                        
                        //KULANG 3/10/24

                        // $event->sheet->setCellValue('J'.$start_col, $assemblyVisualSum); // FINAL OQC
                        // $event->sheet->setCellValue('K'.$start_col, $assemblyVisualSum); // DPPM (NO. OF DEFECTS / SAMPLES * 1000000)
                        // $event->sheet->setCellValue('L'.$start_col, $assemblyVisualSum); // LAR (ACCEPTED LOT / TOTAL LOT INSPECTED * 100%)

                        $event->sheet->setCellValue('I'.$start_col, ("=(F".$start_col."+H".$start_col.")")."/2");
                        $event->sheet->setCellValue('S'.$start_col, ("=(N".$start_col."+P".$start_col."+R".$start_col.")")."/3");

                        $event->sheet->getDelegate()->getStyle('A4'.':'.'AN'.$start_col)->applyFromArray($styleBorderAll);
                        $start_col++;
                    }

                    $event->sheet->getDelegate()->getStyle('H4'.':'.'H'.$start_col)->getNumberFormat()->setFormatCode('0.00%'); 
                    $event->sheet->getDelegate()->getStyle('I4'.':'.'I'.$start_col)->getNumberFormat()->setFormatCode('0.00%'); 
                    $event->sheet->getDelegate()->getStyle('L4'.':'.'L'.$start_col)->getNumberFormat()->setFormatCode('0.00%'); 
                    $event->sheet->getDelegate()->getStyle('N4'.':'.'N'.$start_col)->getNumberFormat()->setFormatCode('0.00%'); 
                    $event->sheet->getDelegate()->getStyle('P4'.':'.'P'.$start_col)->getNumberFormat()->setFormatCode('0.00%'); 
                    $event->sheet->getDelegate()->getStyle('R4'.':'.'R'.$start_col)->getNumberFormat()->setFormatCode('0.00%'); 
                    $event->sheet->getDelegate()->getStyle('S4'.':'.'S'.$start_col)->getNumberFormat()->setFormatCode('0.00%'); 
                    $event->sheet->getDelegate()->getStyle('A4'.':'.'AN'.$start_col)->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('A2:AN3')->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('A4'.':'.'AN'.$start_col)->applyFromArray($hv_center);
                    $event->sheet->getDelegate()->getStyle('A2:AN3')->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle('A2:AN3')->applyFromArray($styleBorderAll);
                }
                
                else{ // CN171P
                    // $event->sheet->getColumnDimension('A')->setWidth(15);
                    // $event->sheet->getColumnDimension('B')->setWidth(15);
                    // $event->sheet->getColumnDimension('C')->setWidth(15);
                    // $event->sheet->getColumnDimension('D')->setWidth(15);
                    // $event->sheet->getColumnDimension('E')->setWidth(15);
                    // $event->sheet->getColumnDimension('F')->setWidth(15);
                    // $event->sheet->getColumnDimension('G')->setWidth(15);
                    // $event->sheet->getColumnDimension('H')->setWidth(15);
                    // $event->sheet->getColumnDimension('I')->setWidth(15);
                    // $event->sheet->getColumnDimension('J')->setWidth(15);
                    // $event->sheet->getColumnDimension('K')->setWidth(15);
                    // $event->sheet->getColumnDimension('L')->setWidth(15);
                    // $event->sheet->getColumnDimension('M')->setWidth(15);
                    // $event->sheet->getColumnDimension('N')->setWidth(15);
                    // $event->sheet->getColumnDimension('O')->setWidth(15);
                    // $event->sheet->getColumnDimension('P')->setWidth(15);
                    // $event->sheet->getColumnDimension('Q')->setWidth(15);
                    // $event->sheet->getColumnDimension('R')->setWidth(15);
                    // $event->sheet->getColumnDimension('S')->setWidth(15);
                    // $event->sheet->getColumnDimension('T')->setWidth(15);
                    // $event->sheet->getColumnDimension('U')->setWidth(15);
                    // $event->sheet->getColumnDimension('V')->setWidth(15);
                    // $event->sheet->getColumnDimension('W')->setWidth(15);
                    // $event->sheet->getColumnDimension('X')->setWidth(15);
                    // $event->sheet->getColumnDimension('Y')->setWidth(15);
                    // $event->sheet->getColumnDimension('Z')->setWidth(15);
                    // $event->sheet->getColumnDimension('AA')->setWidth(15);
                    // $event->sheet->getColumnDimension('AB')->setWidth(15);
                    // $event->sheet->getColumnDimension('AC')->setWidth(15);
                    // $event->sheet->getColumnDimension('AD')->setWidth(15);
                    // $event->sheet->getColumnDimension('AE')->setWidth(15);
                    // $event->sheet->getColumnDimension('AF')->setWidth(15);
                    // $event->sheet->getColumnDimension('AG')->setWidth(15);
                    // $event->sheet->getColumnDimension('AH')->setWidth(15);
                    // $event->sheet->getColumnDimension('AI')->setWidth(15);

                    // $event->sheet->setCellValue('A1', $material.' Parts Lot Management Record');
                    // $event->sheet->getDelegate()->mergeCells('A1:V1');
                    // $event->sheet->getDelegate()->getStyle('A1:V1')->applyFromArray($arial_font12);

                    // $event->sheet->getDelegate()->mergeCells('A2:A3');
                    // $event->sheet->getDelegate()->mergeCells('B2:B3');
                    // $event->sheet->getDelegate()->mergeCells('C2:C3');
                    // $event->sheet->getDelegate()->mergeCells('D2:D3');
                    // $event->sheet->getDelegate()->mergeCells('E2:E3');
                    // $event->sheet->getDelegate()->mergeCells('F2:F3');
                    // $event->sheet->getDelegate()->mergeCells('G2:G3');
                    // $event->sheet->getDelegate()->mergeCells('H2:H3');
                    // $event->sheet->getDelegate()->mergeCells('I2:I3');
                    // $event->sheet->getDelegate()->mergeCells('J2:J3');
                    // $event->sheet->getDelegate()->mergeCells('K2:K3');
                    // $event->sheet->getDelegate()->mergeCells('L2:L3');
                    // $event->sheet->getDelegate()->mergeCells('M2:M3');
                    // $event->sheet->getDelegate()->mergeCells('N2:N3');
                    // $event->sheet->getDelegate()->mergeCells('O2:O3');
                    // $event->sheet->getDelegate()->mergeCells('P2:P3');
                    // $event->sheet->getDelegate()->mergeCells('Q2:Q3');
                    // $event->sheet->getDelegate()->mergeCells('R2:R3');
                    // $event->sheet->getDelegate()->mergeCells('S2:S3');
                    // $event->sheet->getDelegate()->mergeCells('T2:T3');
                    // $event->sheet->getDelegate()->mergeCells('U2:U3');
                    // $event->sheet->getDelegate()->mergeCells('V2:V3');
                    // $event->sheet->getDelegate()->mergeCells('W2:W3');
                    // $event->sheet->getDelegate()->mergeCells('X2:AC2');
                    // $event->sheet->getDelegate()->mergeCells('AD2:AD3');
                    // $event->sheet->getDelegate()->mergeCells('AE2:AG2');


                    // $event->sheet->setCellValue('A2',"投入日 Production Date");
                    // $event->sheet->setCellValue('B2',"Shift");
                    // $event->sheet->setCellValue('C2',"Production Lot #");
                    // $event->sheet->setCellValue('D2',"数量 Prodn Qty");
                    // $event->sheet->setCellValue('E2',"Camera Inspection");
                    // $event->sheet->setCellValue('F2',"Yield");
                    // $event->sheet->setCellValue('G2',"Visual Inspection");
                    // $event->sheet->setCellValue('H2',"Yield");
                    // $event->sheet->setCellValue('I2',"Over-all Yield");
                    // $event->sheet->setCellValue('J2',"Lot Marking");
                    // $event->sheet->setCellValue('K2',"Yield");
                    // $event->sheet->setCellValue('L2',"MO Assembly");
                    // $event->sheet->setCellValue('M2',"Yield");
                    // $event->sheet->setCellValue('N2',"Visual Inspection");
                    // $event->sheet->setCellValue('O2',"Yield");
                    // $event->sheet->setCellValue('P2',"Over-all Yield");
                    // $event->sheet->setCellValue('Q2',"Material Name");
                    // $event->sheet->setCellValue('R2',"Material Lot # (Resin Lot #)");
                    // $event->sheet->setCellValue('S2',"Product Drawing");
                    // $event->sheet->setCellValue('T2',"Product Drawing Rev.");
                    // $event->sheet->setCellValue('U2',"CAV");
                    // $event->sheet->setCellValue('V2',"识别表示 Special adoption document or any special instruction");
                    // $event->sheet->setCellValue('W2',"Remarks");

                    // $event->sheet->setCellValue('X2',"Operator Name");
                    // $event->sheet->setCellValue('X3',"Rotary Machine");
                    // $event->sheet->setCellValue('Y3',"Camera Inspection");
                    // $event->sheet->setCellValue('Z3',"Visual Inspection");
                    // $event->sheet->setCellValue('AA3',"Lot Marking");
                    // $event->sheet->setCellValue('AB3',"MO Assembly");
                    // $event->sheet->setCellValue('AC3',"Visual Inspection");
                    // $event->sheet->setCellValue('AD2',"QC Inspector Name");

                    // $event->sheet->setCellValue('AE2',"Parts Name");
                    // $event->sheet->setCellValue('AE3',"CT5869-VE");
                    // $event->sheet->setCellValue('AF3',"CT5870-VE");
                    // $event->sheet->setCellValue('AG3',"CN171P-02#ME-VE");

                }


            },
        ];
    }

}


