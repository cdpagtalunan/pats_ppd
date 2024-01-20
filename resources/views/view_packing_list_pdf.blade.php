<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Packing List (PDF)</title>
        {{-- <link rel="stylesheet" href="{{ asset('public/css/custom.css')) }}" /> --}}
        @php
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
                background-color: orange;
                border: 1 solid black;
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
                border: 1 solid black;
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
                border: 1 solid black;
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
                border: 1 solid black;
            }

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
            <div class="item">
                <span class="label">Ctrl #:</span>
                <span>{{ $test[0]->control_no }}</span>
            </div>
            <div>
                <div class="pu_time">
                    <span class="data">P/U Time:</span>
                    <span class="data">{{ '12:00 NN' }}</span>
                </div>
                <div class="pu_time">
                    <span class="data">P/U Date:</span>
                    <span class="data">{{ '12/22/2023' }}</span>
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
                        <span class="data" style="margin-right:25%">SANNO REP</span>
                        <span class="data" style="margin-right:40%">12/22/2023</span>
                        <span class="data">FROM: PRICON</span>
                    </div>
                    {{-- <br> --}}
                    <div>
                        <span class="data" style="margin-right:25%">PRICON LAGUNA</span>
                        <span class="data" style="margin-right:40%">SANNO</span>
                        <span class="data">TO: SANNO</span>
                    </div>
                </div>
            </div>
            <div class="content_header">
                {{-- <div class="content_header1"> --}}
                        <span class="data" style="margin-right:10%">BOX #</span>
                        <span class="data" style="margin-right:10%">PO #</span>
                        <span class="data" style="margin-right:12%">Various Contact for Plating Raw Materials</span>
                        <span class="data" style="margin-right:5%">LOT #</span>
                        <span class="data" style="margin-right:5%">QUANTITY #</span>
                        {{-- <span class="data" style="margin-right:80%"></span> --}}
                    {{-- <br> --}}
                {{-- </div> --}}
            </div>
            @for ($i = 0; $i < count($row_data); $i++)
                <div class="content">
                    <span class="data" style="margin-right:10%">{{ $row_data[$i][0] }}</span>
                    <span class="data" style="margin-right:10%">{{ $row_data[$i][1] }}</span>
                    <span class="data" style="margin-right:20%">{{ $row_data[$i][2] }}</span>
                    <span class="data" style="margin-right:10%">{{ $row_data[$i][3] }}</span>
                    <span class="data">{{ $row_data[$i][4].' pcs.' }}</span>
                    {{-- <span class="data">{{ 'pcs.' }}</span> --}}
                </div>
            @endfor
            <div class="content_total">
                <span class="data" style="margin-left:72%; margin-right:4%">Total ===></span>
                <span class="data" style="margin-right:5%">{{ '550,000'.' pcs.' }}</span>
            </div>
        </div>
    </body>
</html>
