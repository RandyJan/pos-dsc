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
            font-size: 14pt;
            font-family: 'Courier New', Courier, monospace;
            background: #eee;
            /* margin-bottom:5%; */

        }
        .table{
            /* font-size: 10px; */
            /* text-align: center; */
        }
        #invoicePOS {
            width: 130mm;
            /* margin: 0 auto; */
            background: #FFF;
            /* padding: 0; */
            padding-bottom: 13mm !important;
            /* box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3); */
        }
        #invoicePOS table {
            width: 100%;
            /* border-collapse: collapse; */
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
        .Items{
            padding-left:10px;
        }
        .headerInvoice::after{
            content: '_';
            color: white;
        }
        @media print {

@page {
    width: 42mm;
    margin: 0;
    padding: 0;
}

}
    </style>
</head>
<body>

    @if( Cache::get('Auth') == 0 || !Cache::has('Auth'))
<div>
    <p>SORRY YOU ARE NOT AUTHORIZED TO USE THIS SOFTWARE,<br> PLEASE LOGIN IMMEDIATELY.</p>
</div>
@else
<div id="invoicePOS">
    <div class="invoiceheader" id="invoiceheader">
    {{-- <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L1']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L2']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L3']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L4']) !!}</p>
    <p>{!! str_replace('\n', '<br>', $receipt['Receipt_Header_L5']) !!}</p> --}}
    @foreach( App\Models\receiptLayout::getLayout() as $receipt)
    {{-- <center> --}}
<p id="headerA" class = "headerInvoice" style="margin:0px;padding:0px"></p>
<p id="headerB" class = "headerInvoice" style="margin:0px;padding:0px"></p>
<p id="headerC" class = "headerInvoice" style="margin:0px;padding:0px"></p>
<p id="headerD" class = "headerInvoice" style="margin:0px;padding:0px"></p>
<p id="headerE" class = "headerInvoice" style="margin:0px;padding:0px"></p>
        <p name="" id="header1"  value="" style="display: none">{{$receipt->Receipt_Header_L1}}</p>
        <p  name="" id="header2" value="" style="display:none">{{$receipt->Receipt_Header_L2}}</p>
        <p name="" id="header3" value="" style="display: none">{{$receipt->Receipt_Header_L3}}</p>
        <p  name="" id="header4" value="" style="display:none">{{$receipt->Receipt_Header_L4}}</p>
        <p  name="" id="header5" value="" style="display: none" >{{$receipt->Receipt_Header_L5}}</p>
{{-- </center> --}}
    @endforeach
</div>
     <table class = "" style="padding:0px;margin:0px;margin-left:15px">
            <thead>

                <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                    <th></th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{now()->format('Y/m/d H:i:s A')}}</td>

                  {{-- <td>{{now()->format('Y-m-d')}}</td> --}}

                   <td>POS#1</td>
                </tr>
                <tr><td>DATALOGIC</td>
                <td>SI#01</td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
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

                @foreach ( App\Models\User::activeTransaction(Cache::get('transNo')) as $items )
          <tr>
            @if(trim($items['Item_Type']) == 7)
            <td id="body">
                {{ trim($items['Item_Description']) }} <br>
                <div class="Items">
                    <!-- Add content for Item_Type equal to 7 here -->
                </div>
            </td>
            <td id="itemValue">P{{number_format(trim($items['Item_Value']))}}</td>

        @else
        <td id="body">
            {{ trim($items['Item_Description']) }} <br>
            <div class="Items">
                <a id="volume">{{ trim($items['Item_Quantity']) }}</a>L x {{ number_format(trim($items['Item_Price'])) }} P/L VAT
            </div>
        </td>
        <td id="itemValue">P{{number_format(trim($items['Item_Value']))}}</td>

        @endif


        </tr>
           @endforeach
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
        @foreach (App\Models\User::transactions(Cache::get('transNo')) as $tax)
        <tr>
            <td>Sale Total</td>
            <td id="saleTotal">

                   P{{ $tax['Sale_Total'] + $tax['Tax_Total']}}

            </td>
            </tr>

            <tr><td></td></tr>
            <tr><td></td></tr>
          <tr>
            <tr>
            <td>TOTAL INVOICE</td>
            <td id="totalInv"> P{{ $tax['Sale_Total'] + $tax['Tax_Total']}}</td>
            </tr>
            <tr>
                <td>TOTAL VOLUME</td>
                <td id="totalVol"></td>
            </tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
          <tr>
        </tr>
        <tr><td></td></tr>
        <tr><td></td></tr>
      <tr>
    </tr>
    <tr><td></td></tr>
    <tr><td></td></tr>
  <tr>
            <td>VATable Sale</td>

            <td>P{{number_format(trim($tax['Sale_Total']))}}</td>
          </tr>
          <tr><td>VAT Amount</td>

                <td>P{{number_format(trim($tax['Tax_Total']))}}</td>
            </tr>
            <tr>
                <td>VAT-Exempt Sale</td>

                <td>P0.00</td>
            </tr>
            <tr>
                <td>Zero Rated Sale</td>

                <td>P0.00</td>
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

    <p id="footerA" style="margin-left:0;padding:0"></p>
    <p id="footerB" style="margin:0px;padding:0px"></p>
        <p id="footerC" style="margin:0px;padding:0px"></p>
            <p id="footerD" style="margin:0px;padding:0px"></p>
                <p id="footerE" style="margin:0px;padding:0px"></p>


                <p name="" id="footer1" value="" style="display: none">{{$receipt->Receipt_Footer_L1}}</p>
                <p  name="" id="footer2" value="" style="display:none">{{$receipt->Receipt_Footer_L2}}</p>
                <p name="" id="footer3" value="" style="display: none">{{$receipt->Receipt_Footer_L3}}</p>
                <p  name="" id="footer4" value="" style="display:none">{{$receipt->Receipt_Footer_L4}}</p>
                <p  name="" id="footer5" value="" style="display: none" >{{$receipt->Receipt_Footer_L5}}</p>
    </div>

@endif
{{-- <iframe src="{{route('/transaction')}}" frameborder="0" id=""></iframe> --}}
</body>
<script type = "text/javascript">
function  computeSpacing(value){
    var splitText = value.trim().split('\\n');
    var spacingData ="";
    splitText.forEach(function(splitter){
            var splitting = parseFloat(splitter.length);
            var output = (42-splitting)/2;
            let firstFormat = splitter.padStart(splitting + output, "_");
            let finalFormat = firstFormat.padEnd(firstFormat.length + output, "_");
                spacingData = spacingData + "\n" + finalFormat;
    })
    return spacingData;
}
 function forHeader(){

    let h1 = document.getElementById('header1');
    let h2 = document.getElementById('header2');
    let h3 = document.getElementById('header3');
    let h4 = document.getElementById('header4');
    let h5 = document.getElementById('header5');
// split variables
    let hA = document.getElementById('headerA');
    let hB = document.getElementById('headerB');
    let hC = document.getElementById('headerC');
    let hD = document.getElementById('headerD');
    let hE = document.getElementById('headerE');


    var h1f = h1.textContent;
    var h2f = h2.textContent;
    var h3f = h3.textContent;
    var h4f = h4.textContent;
    var h5f = h5.textContent;


            hA.textContent = computeSpacing(h1f) ;
         hB.textContent = computeSpacing(h2f).replace('_',' ');
        hC.textContent = computeSpacing(h3f).replace('_',' ');
        hD.textContent = computeSpacing(h4f).replace('_',' ');
        hE.textContent = computeSpacing(h5f).replace('_',' ');
    console.log(computeSpacing(h1f));
    console.log(computeSpacing(h2f));
    console.log(computeSpacing(h3f));
    console.log(computeSpacing(h4f));
    console.log(computeSpacing(h5f));
 }
 forHeader();
 function forFooter(){
    let f1 = document.getElementById('footer1');
    let f2 = document.getElementById('footer2');
    let f3 = document.getElementById('footer3');
    let f4 = document.getElementById('footer4');
    let f5 = document.getElementById('footer5');
// split variables
    let fA = document.getElementById('footerA');
    let fB = document.getElementById('footerB');
    let fC = document.getElementById('footerC');
    let fD = document.getElementById('footerD');
    let fE = document.getElementById('footerE');


    var f1f = f1.textContent;
    var f2f = f2.textContent;
    var f3f = f3.textContent;
    var f4f = f4.textContent;
    var f5f = f5.textContent;

        fA.textContent = computeSpacing(f1f);
        fB.textContent = computeSpacing(f2f);
        fC.textContent = computeSpacing(f3f);
        fD.textContent = computeSpacing(f4f);
        fE.textContent = computeSpacing(f5f);
    console.log(computeSpacing(f1f));
    console.log(computeSpacing(f2f));
    console.log(computeSpacing(f3f));
    console.log(computeSpacing(f4f));
    console.log(computeSpacing(f5f));
 }
 forFooter();
//  function receiptFormatter(){
//     var paragraphElements = document.querySelectorAll("#header1");
// var valuesArray = [];
// var arrayValue = [];
// paragraphElements.forEach(function(paragraph) {
//   valuesArray.push(paragraph.textContent.trim());
// });
//     valuesArray.forEach(function(value){
//        arrayValue.push(value.split('\\n'));

//     })
// console.log(valuesArray);
// console.log(arrayValue);
// }
// receiptFormatter();
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
    //  console.log(textContent);
    // console.log(stringlength);

 }
function footer(){
    var text = document.getElementById('footer');
     var textContent = text.textContent;
    var maxlength = 42;
     var stringlength = lineSpacing(textContent);
    var value = stringlength - maxlength;
     var space = value/2;
     text.style.marginLeft = space + 'px';
    //  console.log(textContent);
    // console.log(stringlength);
}
function printPageSilently() {
  if (window.chrome && window.chrome.print) {
    // Use the silent print option in Chrome
    window.chrome.print({silent: true});
  } else {
    // Fallback to standard print method
    window.print();
  }
}
var printCanceled = false;

window.onbeforeprint = function() {
  // The beforeprint event is triggered before the print dialog is displayed
  // You can use this event to perform any necessary actions before printing
  // For example, you can set a flag to indicate that the print process has started
  printCanceled = false;
};

window.onafterprint = function() {
  // The afterprint event is triggered after the print dialog is closed
  // You can use this event to check if the user canceled the print dialog
  // If the printCanceled flag is still false, it means the user did not cancel the print
  if (printCanceled) {
   // console.log("The user canceled the print dialog");
  } else {
    //console.log("The user completed the print process");
  }
};

// You can also add an event listener to the window to detect if the user cancels the print dialog
window.addEventListener('beforeprint', function() {
  // The beforeprint event is triggered before the print dialog is displayed
  // You can use this event to perform any necessary actions before printing
  // For example, you can set a flag to indicate that the print process has started
  printCanceled = false;
});

window.addEventListener('afterprint', function() {
    //
    //  setInterval(function () {window.location.href = "/pos"}, 5000);

});

printPageSilently();

// Example usage
header(); // Call the header function to execute the logic
// lineSpacing();

function totalSale(){

var itemValueElements = document.querySelectorAll("#itemValue");


var sum = 0;


itemValueElements.forEach(function(element) {

  var valueText = element.textContent.replace("P", "").replace(",", "");
  var numericValue = parseFloat(valueText);


  sum += numericValue;
});
var salettl = document.getElementById('saleTotal');
salettl.textContent = "P" + sum.toLocaleString();

var totalInv = document.getElementById('totalInv');
totalInv.textContent = "P" + sum.toLocaleString();

// Log the sum
// console.log("Sum of itemValue: P" + sum.toLocaleString());

}
function totalVolume(){ // Get all elements with the id "volume"
  var volumeElements = document.querySelectorAll("#volume");

  // Initialize the sum
  var sum = 0;

  // Iterate through the volumeElements and calculate the sum
  volumeElements.forEach(function(element) {
    // Extract the quantity from the text content of the element
    // var valueText = element.textContent;
    var quantity = parseFloat(element.textContent);

    // Add the quantity to the sum
    sum += quantity;
  });
  var volume = document.getElementById("totalVol");
volume.textContent = sum.toLocaleString() + "L" ;
  // Display the sum
//   console.log("The sum of Item_Quantity is: " + sum);

}
// totalSale();
totalVolume();
</script>
</html>
