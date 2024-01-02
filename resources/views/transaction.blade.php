<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <title>Document</title>
    <style>
            body {
            padding: 0;
            margin: 2%;
            font-size: 10pt;
            font-family: Arial, Helvetica, sans-serif;
            background: #eee;
            /* margin-bottom:5%; */

        }
        .table{
            /* font-size: 10px; */
            /* text-align: center; */
        }
        #invoicePOS {
            width: 85mm;
            /* margin: 0 auto; */
            background: #FFF;
            /* padding: 0; */
            /* padding-bottom: 13mm !important; */
            box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
        }
        #invoicePOS table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-borderless tbody+tbody,
        .table-borderless td,
        .table-borderless th,
        .table-borderless thead th {
            border: 0;
        }
        .table-sm td,
        .table-sm th {
            padding: 0.3rem;
        }

        th {
            /* text-align: inherit; */
        }
        .text-center {
            /* text-align: center; */
        }
        footer{
            text-align:center;
        }
        .invoiceheader{
            /* text-align:center; */
        }
        @media print {

@page {
    width: 58mm;
    margin: 0;
    padding: 0;
}
}
    </style>
</head>
<body>

    @if(! Auth::user())
<div>
    <p>Oops you have no active transaction</p>
</div>
@else
<div id="invoicePOS">
    <div class="invoiceheader">
    {{-- <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L1']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L2']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L3']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L4']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L5']) !!}</p> --}}
    @foreach( App\Models\receiptLayout::getLayout() as $receipt)
    <center>
<p id="header" style="margin:0px;padding:0px">{!! trim(str_replace('\n', '<br>', $receipt->Receipt_Header_L1)) !!}</p>
<p id="header" style="margin:0px;padding:0px">{!! trim(str_replace('\n', '<br>', $receipt->Receipt_Header_L2)) !!}</p>
<p id="header" style="margin:0px;padding:0px">{!! trim(str_replace('\n', '<br>', $receipt->Receipt_Header_L3)) !!}</p>
<p id="header" style="margin:0px;padding:0px">{!! trim(str_replace('\n', '<br>', $receipt->Receipt_Header_L4)) !!}</p>
<p id="header" style="margin:0px;padding:0px">{!! trim(str_replace('\n', '<br>', $receipt->Receipt_Header_L5)) !!}</p><br>
    </center>
    @endforeach
</div>
     <table class = "" style="padding:0px;margin:0px;margin-left:15px">
            <thead>

                <tr>
                <th></th>

                <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{now()->format('Y/m/d H:i:s A')}}</td>

                   <td></td> {{-- <td>{{now()->format('Y-m-d')}}</td> --}}

                   <td>POS#1</td>
                </tr>
                {{-- @php

 $apiUrl = 'http://172.16.12.234:8087/api/getTransId';

// Initialize cURL session
$ch = curl_init();

// Set the cURL options
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

// Close cURL session
curl_close($ch);

// Process the API response
if ($response) {
    // Process the response data
    echo $response;
} else {
    // Handle the error
    echo 'Error: Failed to retrieve data from the API';
}

                    $transactionId = $response;

                @endphp --}}
                @foreach ( App\Models\User::activeTransaction() as $items )
          <tr>
            <td id="body">{{trim($items['Item_Description'])}} </td>
           <td></td>

           <td>P{{number_format(trim($items['Item_Value']))}}</td>

        </tr>


           @endforeach

            </tbody>
            <tfoot>

                <tr>
                    {{-- <td>Total:</td> --}}
                    {{-- <td>{{ $total }}</td> --}}




                </tr>
            </tfoot>
        </table>
     <footer>   @foreach( App\Models\receiptLayout::getLayout() as $receipt)
        <td></td>
    @endforeach
    </footer>
    <center>
    <p id="footer" style="margin:0px;padding:0px">{!! trim(str_replace('\n', '<br>', $receipt->Receipt_Footer_L1)) !!}</p>
    <p id="footer" style="margin:0px;padding:0px">{!! trim(str_replace('\n', '<br>', $receipt->Receipt_Footer_L2))!!}</p>
        <p id="footer" style="margin:0px;padding:0px">{!! trim(str_replace('\n', '<br>', $receipt->Receipt_Footer_L3)) !!}</p>
            <p id="footer" style="margin:0px;padding:0px">{!! trim(str_replace('\n', '<br>', $receipt->Receipt_Footer_L4)) !!}</p>
                <p id="footer" style="margin:0px;padding:0px">{!! trim(str_replace('\n', '<br>', $receipt->Receipt_Footer_L5)) !!}</p>
            </center>
    </div>

@endif
</body>
<script type = "text/javascript">
     function lineSpacing(textContent) {
        //  var splitText = textContent.split("<br>");
        //  console.log(splitText);
//  return splitText[0].length;
        return textContent.textContent;
}
 function header() {
    var text = document.getElementById('header');
     var textContent = text.textContent;
    var maxlength = 42;
     var stringlength = lineSpacing(textContent);
    var value = stringlength - maxlength;
     var space = value/2;
     text.style.marginLeft = space + 'px';
     console.log(textContent);
    console.log(stringlength);

 }
function footer(){
    var text = document.getElementById('footer');
     var textContent = text.textContent;
    var maxlength = 42;
     var stringlength = lineSpacing(textContent);
    var value = stringlength - maxlength;
     var space = value/2;
     text.style.marginLeft = space + 'px';
     console.log(textContent);
    console.log(stringlength);
}

// Example usage
header(); // Call the header function to execute the logic
// lineSpacing();
</script>
</html>
