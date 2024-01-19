<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Packing List (PDF)</title>
        {{-- <link rel="stylesheet" href="{{ asset('public/css/custom.css')) }}" /> --}}
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

            .sanno_details{
                position: relative;
                top: 120px;
                left: 50px;
            }

            .sanno_details .data span{
                text-align: center;
            }


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
                <span style="text-align:center; width:150px; border-bottom: 1px solid black;">{{ $test[0]->control_no }}</span>
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
            <div class="sanno_details">
                <div class="data">
                    <span style="margin-right: 100px;">SANNO PHILS. MANUFACTURING CORP.</span>
                    <span>SANNO PHILS. MANUFACTURING CORP.</span>
                </div>
                <div class="data">Special Export Processing Zone, Gateway Business Park,</div>
                <div class="data">Javalera, Gen. Trias, Cavite, Philippines</div>
            </div>
        </div>
    </body>
</html>
