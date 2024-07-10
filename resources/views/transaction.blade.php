<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
    <style>
            body {
            padding: 0;
            margin: 2%;
            font-size: 14pt;
            font-family: monospace;
            background: #eee;

            /* margin-bottom:5%; */

        }
        .table{
            /* font-size: 10px; */
            /* text-align: center; */
        }
        #invoicePOS {
            width: 120mm;
            position: relative;
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
        #invoiceBody p{
            display: none;


        }
        .miniHeader{
            display: flex;
            justify-content: space-between;
            background-color: yellow;
            width:98%;

        }

        .itemsA{
            display: flex;
            justify-content: space-between;
            background-color: pink;
            width:98%;
        }
        .invoiceheader p{
            display: none;
        }
        /* #invoicefooter{

        } */


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

    @foreach( App\Models\receiptLayout::getLayout() as $receipt)

        <p name="" id="header1"  value="" style="display: none">{{$receipt->Receipt_Header_L1}}</p>
        <p  name="" id="header2" value="" style="display:none">{{$receipt->Receipt_Header_L2}}</p>
        <p name="" id="header3" value="" style="display: none">{{$receipt->Receipt_Header_L3}}</p>
        <p  name="" id="header4" value="" style="display:none">{{$receipt->Receipt_Header_L4}}</p>
        <p  name="" id="header5" value="" style="display: none" >{{$receipt->Receipt_Header_L5}}</p>
{{-- </center> --}}
    @endforeach
</div>
<div id="otherinfo" style=""></div><br>
<div id="itemsarray"></div><br>
<div id="mop"></div><br>
<div id="alltotal"></div><br>
<div id="taxdetails"></div> <br>

<div id="invoiceBody">
    {{-- <div style="display: none"> --}}
         <p id="date">{{now()->format('m/d/Y H:i:s A')}}</p>
         <p id ="posnumlbl">POS#1<p>
         <p id="compname">DATALOGIC</p>
         <p id="unum">SI#0000000001</p>
         <p id = "transno">{{Cache::get('transNo')}}</p>
 @foreach ( App\Models\User::activeTransaction(Cache::get('transNo')) as $items )

    @if(trim($items['Item_Type']) == 7)
         <p id="itemDescA">{{trim($items['Item_Description'])}}</p>
         <p id="itemtest"> </p>
         {{-- <p id="itemDetails"></p> --}}
         <p  id="itemValueA" style="display: none">P{{number_format(trim($items['Item_Value']))}}</p>
     @else
         <p id="itemDesc" style="display: none;">{{trim($items['Item_Description'])}}<br></p>
         <p id="itemTest"> </p>
         <p id = "itemDetails">{{number_format(trim($items['Item_Quantity']))}}L x {{number_format(trim($items['Item_Price']))}}P/L VAT</p>
         <p id="itemValue" style="display: none">P{{number_format(trim($items['Item_Value']))}}</p>
    @endif
     @endforeach
     @foreach (App\Models\User::transactions(Cache::get('transNo')) as $tax)
        <p id="saletotallbl">Sale Total</p>
        <p id="saleTotal">P{{str_replace( ',','',number_format($tax['Sale_Total'] + $tax['Tax_Total'],2))}}</p>
        <p id = "totalInvlbl">TOTAL INVOICE</p>
        <p id="totalInv">P{{ str_replace(',','',number_format($tax['Sale_Total'] + $tax['Tax_Total'],2))}}</p>
        <p id="totalvollbl">TOTAL VOLUME</p>
        <p id="totalVol"> </p>
        <p id="vatsalelbl">VATable Sale</p>
        <p id="vatsalettl">P{{str_replace(',','',number_format(trim($tax['Sale_Total'],2)))}}</p>
        <p id="vatamountlbl">VAT Amount</p>
        <p id="taxttl">P{{number_format(trim($tax['Tax_Total']))}}</p>
        <p id="vatexemplbl">VAT-Exempt Sale</p>
        <p id="vatexemp">P0.00</p>
        <p id="zeroratedlbl">Zero Rated Sale</p>
        <p id="zerorated">P0.00</p>
         @endforeach
        {{-- </div> --}}
        </div>

     @foreach( App\Models\receiptLayout::getLayout() as $receipt)
        <td></td>
    @endforeach
    </footer>
    <br>
    <div id="invoicefooter">
                <p name="" id="footer1" value="" style="display: none">{{$receipt->Receipt_Footer_L1}}</p>
                <p  name="" id="footer2" value="" style="display:none">{{$receipt->Receipt_Footer_L2}}</p>
                <p name="" id="footer3" value="" style="display: none">{{$receipt->Receipt_Footer_L3}}</p>
                <p  name="" id="footer4" value="" style="display:none">{{$receipt->Receipt_Footer_L4}}</p>
                <p  name="" id="footer5" value="" style="display: none" >{{$receipt->Receipt_Footer_L5}}</p>
            </div>
    </div>
</div>
@endif
{{-- <iframe src="{{route('/transaction')}}" frameborder="0" id=""></iframe> --}}
</body>
<script type = "text/javascript">
var middleformat = [];
var headerformat = [];
var footerformat = [];
var sampleReceipt = [];
var arrayleftright = [[],[]];
var combined = [];
var outputdapat = '';
var itemsarray = [];
var otherinfo = [];
var taxinfo = [];
var alltotal=[];
var mop = [];

function dualColumnSpacing(right,left){

    var rightitem = document.getElementById(right);
    var leftitem = document.getElementById(left);
    var rightlength = rightitem.textContent.length;
    var leftlength = leftitem.textContent.length;
    var totalspace = 42 - (rightlength + leftlength);
    var data = leftitem.textContent;
    for(var i = 0;i < totalspace;i++ ){
     data += "-";
    }
    data += rightitem.textContent;
    if(right == 'posnumlbl' || right == 'unum'){
        otherinfo.push(data);
    }

    else if(right == 'saleTotal'){
        mop.push(data);
    }
    else if(right == 'totalVol' || right =='totalInv'){
        alltotal.push(data);
    }

    else{
        console.log("data inserted");
        taxinfo.push(data);
            }


}



function spacingMiddle(arraytoform,parentdiv){
arraytoform.forEach(function(itemdata){
var paragraph = document.createElement('a');
var br = document.createElement('br');
var brb = document.createElement('br');

var text = document.createTextNode(itemdata);
paragraph.appendChild(text);
var div = document.getElementById(parentdiv);
paragraph.innerHTML = paragraph.innerHTML.replace(/-/g, "&nbsp;");

div.appendChild(paragraph);
div.appendChild(br);
// div.appendChild(brb);

});
}




function middlespacingformat(){
var trans = document.getElementById('transno');
var transno = trans.textContent;
console.log(transno);
$.ajax({
  url: '/receiptItems',
  type: 'POST',
  contentType: 'application/json',
  data: JSON.stringify({
    '_token': '{{ csrf_token() }}',
    'data': transno
  }),
  success: function(response) {


dualColumnSpacing('posnumlbl', 'date');
dualColumnSpacing('unum', 'compname');

dualColumnSpacing('saleTotal','saletotallbl');

console.log(response);
var literdisplay = 0;
response.forEach(function(items){
    if(items[4] == '2'){
        var space = 42 - items[0].trim().length;

        var format = items[0].trim();

        for(var g = 0; g < space;g++){
                        format += '-';
                    }
                    itemsarray.push(format);
                    let liter = items[1];
                    let litervalue =new Number(liter).toFixed(3) + 'L';
                    let price = items[2];
                    let pricevalue = new Number(price).toFixed(2);
                    let total = items[3];
                    let totalvalue = new Number(total).toFixed(2);
                     literdisplay = literdisplay + parseFloat(litervalue.replace('L',''));

            var space2 = 42-(litervalue.length + pricevalue.length + totalvalue.length + 10);
            var formattedData = litervalue + '-x-' + pricevalue + '-P/L-';
            for(var g = 0; g < space2;g++){
                        formattedData += '-';
                    }
                itemsarray.push('-'+formattedData+ 'P' + totalvalue);

    }
else{
    var left = items[0].trim().length;
    let leftvalue = new Number(items[0]).toFixed(2);
    var right = items[3].trim().length;
    var rightvalue = new Number(items[3]).toFixed(2);
    var formatdata = items[0].trim();
    var spacing = 42 - ( left + rightvalue.length + 1);

    for(var i = 0;i < spacing;i++){
        formatdata += '-';

    }
    formatdata+= 'P' + rightvalue;
    mop.push(formatdata);
}
});
    var totalliters = document.getElementById('totalVol');
    totalliters.textContent = literdisplay.toFixed(3) + 'L';
dualColumnSpacing('totalInv', 'totalInvlbl');
dualColumnSpacing('totalVol', 'totalvollbl');
dualColumnSpacing('vatsalettl', 'vatsalelbl');
dualColumnSpacing('taxttl','vatamountlbl');
dualColumnSpacing('vatexemp','vatexemplbl');
dualColumnSpacing('zerorated','zeroratedlbl');

spacingMiddle(otherinfo,'otherinfo');
spacingMiddle(itemsarray,'itemsarray');
spacingMiddle(mop,'mop');
console.log(mop);
spacingMiddle(taxinfo,'taxdetails');
spacingMiddle(alltotal,'alltotal');

window.print();

  },
  error: function(response) {
    console.log("request failed");
  }



});
};
middlespacingformat();

function  computeSpacing(header){
        var headerelement = document.getElementById(header);
        var headervalue = headerelement.textContent;
    var splitText = headervalue.trim().split('\\n');
    var spacingData ="";
    splitText.forEach(function(splitter){
            var splitting = parseFloat(splitter.length);
            var output = (42-splitting)/2;
            let firstFormat = splitter  .padStart(splitting + output, "-");
            let finalFormat = firstFormat.padEnd(firstFormat.length + output, "-");
                spacingData = spacingData + "\n" + finalFormat;
    })
    return spacingData;
}

 function headerSpacingformat(header,arrayformat){
        arrayformat.push(header);
}
headerSpacingformat(computeSpacing('header1'),headerformat);
headerSpacingformat(computeSpacing('header2'),headerformat);
headerSpacingformat(computeSpacing('header3'),headerformat);
headerSpacingformat(computeSpacing('header4'),headerformat);
headerSpacingformat(computeSpacing('header5'),headerformat);

headerSpacingformat(computeSpacing('footer1'),footerformat);
headerSpacingformat(computeSpacing('footer2'),footerformat);
headerSpacingformat(computeSpacing('footer3'),footerformat);
headerSpacingformat(computeSpacing('footer4'),footerformat);
headerSpacingformat(computeSpacing('header5'),footerformat);
console.log(itemsarray);

 function spacingHeader(parentdiv,arrayformat){

 arrayformat.forEach(function(itemdata){
var paragraph = document.createElement('a');
var br = document.createElement('br');
var text = document.createTextNode(itemdata);
paragraph.appendChild(text);
var div = document.getElementById(parentdiv);
paragraph.innerHTML = paragraph.innerHTML.replace(/-/g, "&nbsp;");

div.appendChild(paragraph);
div.appendChild(br);
});
}
spacingHeader('invoiceheader',headerformat);
spacingHeader('invoicefooter',footerformat);
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

// printPageSilently();



function totalSale(){

var itemValueElements = document.querySelectorAll("#itemValue");


var sum = 0;


itemValueElements.forEach(function(element) {

  var valueText = element.textContent.replace("P", "").replace(",", "");
  var numericValue = valueText.toFixed(2);


  sum += numericValue.toFixed(2);
});
var salettl = document.getElementById('saleTotal');
salettl.textContent = sum.toFixed(2);

var totalInv = document.getElementById('totalInv');
totalInv.textContent = parseFloat(sum,2).toLocaleString();

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
