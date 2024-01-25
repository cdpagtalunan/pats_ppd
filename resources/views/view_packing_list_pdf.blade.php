<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Packing List (PDF)</title>
        {{-- <link rel="stylesheet" href="{{ asset('public/css/custom.css')) }}" /> --}}
        @php

            // $created_at = $packing_list_details[0]->created_at;
            $created_at = explode(' ', $packing_list_details[0]->created_at);
            $row_data = [
                        ['C/NO.1','PO 123456','CT 3640 CF 1','M231220-01-1','150,001'],
                        ['C/NO.2','PO 123456','CT 3640 CF 2','M231220-01-2','150,002'],
                        ['C/NO.3','PO 123456','CT 3640 CF 3','M231220-01-3','150,003'],
                        ['C/NO.4','PO 123456','CT 3640 CF 4','M231220-01-4','150,004'],
                        ['C/NO.5','PO 123456','CT 3640 CF 5','M231220-01-5','150,005'],
                        ['C/NO.6','PO 123456','CT 3640 CF 6','M231220-01-6','150,006']
                    ];
        @endphp
        <style>

            *{
                margin: 0;
                padding: 0;
            }

            body{
                font:14px Georgia, serif;
            }

            .item {
                position: relative;
                top: 20px;
                left: 500px;
                /* background-color: powderblue; */
                /* font:30px Georgia, serif; */
            }

            .item span.label{

            }

            .item span.data{
                /* width: 1000px; */
                /* background-color: powderblue; */
                /* font:30px Georgia, serif; */
            }

            .pu_time .data {
                position: relative;
                top: 100px;
                left: 600px;
                /* background-color: powderblue; */
            }

            /* .sanno_details{
                position: relative;
                top: 120px;
                left: 50px;
            } */

            .sanno{
                position: relative;
                top: 130px;
                left: 0;
                right: 0;
                bottom: 0;

                width: 100%;
                height: 5%;
                margin: auto;
            }

            .sanno_details{
                display: inline-block !important;
                height: 50px;
                width: 350px;
                /* text-align: center;
                position: relative;
                top: 120px;
                left: 0;
                right: 0;
                bottom: 0;
                width: 50%;
                height: 5%; */
                margin: 21px;
                /* background-color: orange;
                border: 1 solid black; */
            }

            .sanno_details .data{
                text-align: center;
            }

            .doc_header{
                position: relative;
                top: 160px;
                left: 0;
                right: 0;
                bottom: 0;
                width: 100%;
                height: 5%;
                margin: auto;
            }

            .doc_header1{
                height: 50px;
                width: 760px;
                margin-left: 15px;
                /* display: inline-block !important; */
                /* display: flex !important;
                justify-content: space-between; */
                /* text-align: center;
                position: relative;
                top: 120px;
                left: 0;
                right: 0;
                bottom: 0;
                width: 50%;
                height: 5%; */
                /* gap: 1rem; */
                /* background-color: orange; */
                /* border: 1 solid black; */
            }

            .content_header{
                position: relative;
                top: 180px;
                left: 10px;
                right: 0;
                bottom: 0;
                width: 97%;
                height: 2%;
                /* margin: auto; */
                /* border: 1 solid black; */
            }

            .content{
                position: relative;
                top: 180px;
                left: 10px;
                right: 0;
                bottom: 0;
                width: 97%;
                height: 2%;
                /* margin: auto; */
                /* border: 1 solid black; */
            }

            .table_content{
                position: relative;
                top: 180px;
                left: 10px;
                right: 0;
                bottom: 0;
                width: 97%;
                height: 600px;
                /* margin: auto; */
                /* border: 1 solid black; */
            }

            .content_total{
                position: relative;
                top: 180px;
                left: 10px;
                right: 0;
                bottom: 0;
                width: 97%;
                height: 2%;
                /* margin: auto; */
                /* border: 1 solid black; */
            }

            .content_grand_total{
                position: relative;
                top: 200px;
                left: 10px;
                right: 0;
                bottom: 0;
                width: 97%;
                height: 2%;
                /* margin: auto; */
                /* border: 1 solid black; */
            }

            .doc_footer{
                position: relative;
                top: 200px;
                left: 10px;
                right: 0;
                bottom: 0;
                width: 97%;
                height: 2%;
                /* margin: auto; */
                /* border: 1 solid black; */
            }

            .doc_footer_data{
                position: relative;
                top: 220px;
                left: 10px;
                right: 0;
                bottom: 0;
                width: 97%;
                height: 2%;
                /* margin: auto; */
                /* border: 1 solid black; */
            }

            .doc_footer_position{
                position: relative;
                top: 230px;
                left: 10px;
                right: 0;
                bottom: 0;
                width: 97%;
                height: 2%;
                /* margin: auto; */
                /* border: 1 solid black; */
            }

            .test_sanno{
                position: relative;
                top: 250px;
                left: 0;
                right: 0;
                bottom: 0;

                width: 100%;
                height: 5%;
                margin: auto;
            }

            .test{
                display: inline-block !important;
                height: 50px;
                width: 190px;
                /* text-align: center;
                position: relative;
                top: 120px;
                left: 0;
                right: 0;
                bottom: 0;
                width: 50%;
                height: 5%; */
                margin: 0.5px;
                /* margin-left: 10px; */
                /* margin-right: 10px; */
                /* background-color: orange;
                border: 1 solid black; */
            }

            .test .data{
                text-align: center;
            }

            .table_content .data{
                text-align: center;
            }

            /* .table_content tr{
                border: 1 solid black;
            }

            .table_content th{
                border: 1 solid black;
            }

            .table_content td{
                border: 1 solid black;
            } */


            /* .content_header1{
                height: 50px;
                width: 800px;
                margin-left: 15px;
                border: 1 solid black;
            } */

            /* .data{
                position: relative;
                top: 20px;
                left: 100px;
                background-color: powderblue;
            } */

            /* .parent{
                position: relative;
            } */

        </style>
    </head>
    <body>
        <div class="container">
            @php
                echo '<img src="'.$base64.'"/>';
            @endphp
            <div class="item">
                <span class="label">CTRL #:</span>
                <span>{{ $packing_list_details[0]->control_no }}</span>
            </div>
            <div>
                <div class="pu_time">
                    <span class="data">P/U Time:</span>
                    <span class="data">{{ $packing_list_details[0]->pick_up_time }}</span>
                </div>
                <div class="pu_time">
                    <span class="data">P/U Date:</span>
                    <span class="data">{{ $packing_list_details[0]->pick_up_date }}</span>
                </div>
            </div>
            <div class="sanno">
                <div class="sanno_details">
                    <div class="data">SANNO PHILS. MANUFACTURING CORP.</div>
                    <div class="data">Special Export Processing Zone, Gateway Business Park,</div>
                    <div class="data">Javalera, Gen. Trias, Cavite, Philippines</div>
                </div>
                <div class="sanno_details">
                    <div class="data">SANNO PHILS. MANUFACTURING CORP.</div>
                    <div class="data">Special Export Processing Zone, Gateway Business Park,</div>
                    <div class="data">Javalera, Gen. Trias, Cavite, Philippines</div>
                </div>
            </div>
            <div class="doc_header">
                <div class="doc_header1">
                    <div>
                        <span class="data" style="margin-right:25%">{{ $packing_list_details[0]->carrier }}</span>
                        <span class="data" style="margin-right:35%">{{ $created_at[0] }}</span>
                        <span class="data">FROM: {{ $packing_list_details[0]->product_from }}</span>
                    </div>
                    {{-- <br> --}}
                    <div>
                        <span class="data" style="margin-right:25%">{{ $packing_list_details[0]->port_of_loading }}</span>
                        <span class="data" style="margin-right:35%">{{ $packing_list_details[0]->port_of_destination }}</span>
                        <span class="data">TO: {{ $packing_list_details[0]->product_to }}</span>
                    </div>
                </div>
            </div>
            {{-- <div class="content_header">
                        <span class="data" >BOX #</span>
                        <span class="data" style="margin-right:10%">PO #</span>
                        <span class="data" style="margin-right:12%">Various Contact for Plating Raw Materials</span>
                        <span class="data" style="margin-right:5%">LOT #</span>
                        <span class="data" style="margin-right:5%">QUANTITY #</span>
            </div>
            @for ($i = 0; $i < count($row_data); $i++)
                <div class="content">
                    <span class="data" style="margin-right:10%">{{ $row_data[$i][0] }}</span>
                    <span class="data" style="margin-right:10%">{{ $row_data[$i][1] }}</span>
                    <span class="data" style="margin-right:20%">{{ $row_data[$i][2] }}</span>
                    <span class="data" style="margin-right:10%">{{ $row_data[$i][3] }}</span>
                    <span class="data">{{ $row_data[$i][4].' pcs.' }}</span>
                </div>
            @endfor --}}

            <table class="table_content">
                <tr>
                    <th colspan="2">BOX #</th>
                    <th colspan="3">PO #</th>
                    <th colspan="2">Various Contact for Plating Raw Materials</th>
                    <th colspan="2">LOT #</th>
                    <th colspan="2">QUANTITY #</th>
                </tr>
                @php
                        $grand_total_qty = [];
                    for($ii = 0; $ii < count($packing_list_details_mat_count); $ii++){
                        $total_qty = [];
                        for ($i = 0; $i < count($packing_list_details); $i++){
                            if($packing_list_details_mat_count[$ii]->mat_name == $packing_list_details[$i]->mat_name){
                                echo    '<tr>';
                                echo        '<td colspan="3" class="data">C/NO.'.$packing_list_details[$i]->box_no.'</td>';
                                echo        '<td colspan="2" class="data">'.$packing_list_details[$i]->po_no.'</td>';
                                echo        '<td colspan="2" class="data">'.$packing_list_details[$i]->mat_name.'</td>';
                                echo        '<td colspan="2" class="data">'.$packing_list_details[$i]->lot_no.'</td>';
                                echo        '<td class="data" style="text-align:right !important;">'.$packing_list_details[$i]->quantity.'</td>';
                                echo        '<td class="data">pcs.</td>';
                                echo    '</tr>';
                                $total_qty[] = $packing_list_details[$i]->quantity;
                            }
                        }
                            echo '<tr>
                                    <td colspan="8"></td>
                                    <td class="data">Total ===></td>
                                    <td class="data" style="text-align:right !important;">'.array_sum($total_qty).'</td>
                                    <td class="data">pcs.</td>
                                </tr>';
                            $grand_total_qty[] = array_sum($total_qty);
                    }
                        echo '<tr>
                                <td colspan="8"></td>
                                <td class="data">Grand Total ===></td>
                                <td class="data" style="text-align:right !important;">'.array_sum($grand_total_qty).'</td>
                                <td class="data">pcs.</td>
                            </tr>';
                @endphp
            </table>

            {{-- <div class="doc_footer">
                <span class="data" style="margin-left: 5%; margin-right:12%">Prepared By:</span>
                <span class="data" style="margin-right:30%">Checked By:</span>
                <span class="data" style="margin-right:12%">Cc:</span>
            </div>

            <div class="doc_footer_data">
                <span class="data" style="margin-left:3%; margin-right:5%">{{ 'Melea M. Alvarez' }}</span>
                <span class="data" style="margin-right:5%">{{ 'Jo B. Cahilig' }}</span>
                <span class="data" style="margin-right:5%">{{ 'Clark Chester D. Casuyon' }}</span>
                <span class="data" style="margin-right:2%">{{ 'Cris M. / JR. /' }}</span>
            </div>

            <div class="doc_footer_position">
                <span class="data" style="margin-left: 5%; margin-right:10%">{{ 'PPS-PPC CLERK' }}</span>
                <span class="data" style="margin-right:8%">{{ 'PPS-PPC Sr Planner' }}</span>
                <span class="data" style="margin-right:8%">{{ 'Whse Supvr / Manager' }}</span>
                <span class="data" style="margin-right:5%">{{ 'Traffic / Prod`n / QC'  }}</span>
            </div> --}}

            <div class="test_sanno">
                <div class="test" style="margin-left:5px;">
                    <div class="data">Prepared By:</div>
                    @php
                        if($packing_list_details[0]->prepared_by == null){
                            echo '<div class="data">&nbsp;</div>';
                        }else{
                            echo '<div class="data">'.$packing_list_details[0]->prepared_by.'</div>';
                        }
                    @endphp
                    {{-- <div class="data">{{ $packing_list_details[0]->prepared_by }}</div> --}}
                    {{-- <div class="data">{{ 'Melea M. Alvarez' }}</div> --}}
                    <div class="data">{{ 'PPS-PPC CLERK' }}</div>
                </div>
                <div class="test">
                    <div class="data">Checked By:</div>
                    @php
                        if($packing_list_details[0]->checked_by == null){
                            echo '<div class="data">&nbsp;</div>';
                        }else{
                            echo '<div class="data">'.$packing_list_details[0]->checked_by.'</div>';
                        }
                    @endphp
                    {{-- <div class="data">{{ $packing_list_details[0]->checked_by }}</div> --}}
                    {{-- <div class="data">{{ 'Jo B. Cahilig' }}</div> --}}
                    <div class="data">{{ 'PPS-PPC Sr. Planner' }}</div>
                </div>
                <div class="test">
                    <div class="data">&nbsp;</div>
                    <div class="data">&nbsp;</div>
                    <div class="data">{{ 'Whse Supvr / Manager' }}</div>
                </div>
                <div class="test">
                    <div class="data" style="text-align: left;">Cc:</div>
                    @php
                        if($packing_list_details[0]->cc_personnel == null){
                            echo '<div class="data">&nbsp;</div>';
                        }else{
                            echo '<div class="data">'.$packing_list_details[0]->cc_personnel.'</div>';
                        }
                    @endphp
                    {{-- <div class="data">{{ $packing_list_details[0]->cc_personnel }}</div> --}}
                    {{-- <div class="data">{{ 'Cris M. / JR. /' }}</div> --}}
                    <div class="data">{{ 'Traffic / Prod`n / QC' }}</div>
                </div>
            </div>
        </div>
    </body>
</html>
