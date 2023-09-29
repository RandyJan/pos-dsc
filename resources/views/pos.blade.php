<x-app-layout>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <style>
        </style>
    </head>

    <body>
        <div class="pos-container">
            <div class="column left-column">
                <!-- Item Display -->
                <div class="table-container">
                    <div class="item-display-container">
                        <table class="item-table">
                            <thead>
                                <tr style="position: sticky; top: 0;  z-index: 1;">
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Product 1</td>
                                    <td>Php10.00</td>
                                    <td>2</td>
                                    <td>Php20.00</td>
                                </tr>
                                <tr>
                                    <td>Product 1</td>
                                    <td>Php10.00</td>
                                    <td>2</td>
                                    <td>Php20.00</td>
                                </tr>
                                <tr>
                                    <td>Product 1</td>
                                    <td>Php10.00</td>
                                    <td>2</td>
                                    <td>Php20.00</td>
                                </tr>
                                <tr>
                                    <td>Product 1</td>
                                    <td>Php10.00</td>
                                    <td>2</td>
                                    <td>Php20.00</td>
                                </tr>
                                <tr>
                                    <td>Product 1</td>
                                    <td>Php10.00</td>
                                    <td>2</td>
                                    <td>Php20.00</td>
                                </tr>

                                <tr>
                                    <td>Product 1</td>
                                    <td>Php10.00</td>
                                    <td>2</td>
                                    <td>Php20.00</td>
                                </tr>

                                <tr>
                                    <td>Product 1</td>
                                    <td>Php10.00</td>
                                    <td>2</td>
                                    <td>Php20.00</td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Calculator Container -->
                <!-- Calculator Buttons Container -->
                <div class="calculator-buttons-container">
                    <div class="calculator">
                        <input type="text" readonly class="calculator-display" placeholder="0.00" />
                    </div>
                    <div class="calculator-buttons">
                        <button class="calcbutton" onclick="appendToDisplay('7')">7</button>
                        <button class="calcbutton" onclick="appendToDisplay('8')">8</button>
                        <button class="calcbutton" onclick="appendToDisplay('9')">9</button>
                        <button class="calcbutton clear-button" onclick="clearDisplay()"> Clear</button>
                        <button class="calcbutton special-button">Void</button>
                        <button class="calcbutton special-button">Preset</button>
                        <button class="calcbutton" onclick="appendToDisplay('4')">4</button>
                        <button class="calcbutton" onclick="appendToDisplay('5')">5</button>
                        <button class="calcbutton" onclick="appendToDisplay('6')">6</button>
                        <button class="calcbutton special-button">Open Drawer</button>
                        <button class="calcbutton special-button">Sub Total</button>
                        <button class="calcbutton special-button">Void All</button>
                        <button class="calcbutton" onclick="appendToDisplay('1')">1</button>
                        <button class="calcbutton" onclick="appendToDisplay('2')">2</button>
                        <button class="calcbutton" onclick="appendToDisplay('3')">3</button>
                        <button class="calcbutton special-button">Print Receipt</button>
                        <button class="calcbutton special-button">User</button>
                        <button class="calcbutton special-button">PG Disc</button>
                        <button class="calcbutton" onclick="appendToDisplay('0')">0</button>
                        <button class="calcbutton" onclick="appendToDisplay('00')">00</button>
                        <button class="calcbutton" onclick="appendToDisplay('.')">.</button>
                        <button class="calcbutton special-button">Safe Drop</button>
                        <button class="calcbutton special-button">All Stop</button>
                        <button class="calcbutton special-button">All Auth</button>
                    </div>
                </div>
            </div>
            <!-- Fuel Pumps -->
            <div class="right-column column">

                                  <div class="tabs is-normal">
                                    <ul>
                                      <li id="pump-nav" class="is-active"><a onclick="pumps()" >Pumps</a></li>
                                      <li id="mop-nav" ><a onclick="mop()">MOP</a></li>
                                      <li id="manual-nav"><a  onclick="manual()">Manual</a></li>
                                      <li id="nf-nav"><a onclick="nonfuel()">Non-fuel</a></li>
                                      <li id="reports-nav"><a  onclick="reports()">Reports</a></li>
                                      <li id="config-nav"><a  onclick="config()">Config</a></li>
                                    </ul>
                                  </div>

                <div id="pumpdiv">

                <div class="pump-items-container" id="pump-column">

                    @foreach ($datab as $pump )
                    <form action="/authorizepump" method="GET" id="{{$pump['Id']}}">
                    <div class="pump-item text-dark">


                            @if ($pump['Type']==='PumpIdleStatus')

                            @if ($pump['Data']['NozzleUp'] > 0)
                            <input type="hidden" name="nozzle" value="{{$pump['Data']['NozzleUp']}}">
                            @if ($pump['Data']['NozzleUp'] === 1)
                            <h3 style="background-color: lightgreen" class="card-header"> {{$pump['Id']}} <a class="card-header-title p-0">NOZZLE <a style="font-size:14px;color:red">(Premium)</a> </a></h3>

                            @elseif ($pump['Data']['NozzleUp'] === 2)
                            <h3 style="background-color: lightgreen" class="card-header"> {{$pump['Id']}} <a class="card-header-title p-0">NOZZLE <a style="font-size:14px;color:red">(Diesel)</a> </a></h3>

                            @elseif ($pump['Data']['NozzleUp'] === 3)
                            <h3 style="background-color: lightgreen" class="card-header"> {{$pump['Id']}} <a class="card-header-title p-0">NOZZLE <a style="font-size:14px;color:red">(Regular)</a> </a></h3>

                            @else
                            <h3 style="background-color: lightgreen" class="card-header"> {{$pump['Id']}} <a class="card-header-title p-0">NOZZLE </a></h3>
                            @endif

                            @else
                            <h3 style="background-color:#FFD580;" class="card-header"> {{$pump['Id']}} <a class="card-header-title p-0">IDLE</a></h3>
                            @endif
                            @elseif ($pump['Type']==='PumpOfflineStatus')
                            <h3 style="background-color: #FFCCCB" class="card-header"> {{$pump['Id']}} <a class="card-header-title p-0" >OFFLINE</a></h3>
                            @elseif ($pump['Type']==='PumpFillingStatus')
                            <h3 style="background-color: lightblue" class="card-header"> {{$pump['Id']}} <a class="card-header-title p-0" style="color: red">FILLING</a></h3>
                            @elseif ($pump['Type']==='PumpEndOfTransactionStatus')
                                <h3 style="background-color:darkgray" class="card-header"> {{$pump['Id']}} <a class="card-header-title p-0">DONE</a></h3>
                            @endif

                            <div class="label-input-group">

                                <label for="price">Price:</label>
                                @if ($pump['Type']==='PumpIdleStatus')
                                <input readonly type="text" id="price" name="price" value="{{$pump['Data']['LastPrice']}}" />
                                @elseif ($pump['Type']==='PumpOfflineStatus')
                                <input readonly type="text" id="price" name="price" value="0" />
                                @elseif ($pump['Type']==='PumpFillingStatus')
                                <input readonly type="text" id="price" name="price" value="{{$pump['Data']['Price']}}" />
                                @elseif ($pump['Type']==='PumpEndOfTransactionStatus')
                                    <input readonly type="text" id="price" name="eotprice" value="{{$pump['Data']['Price']}}" />
                                @endif
                            </div>
                            <div class="label-input-group">
                                <label for="volume">Volume:</label>
                                @if ($pump['Type']==='PumpIdleStatus')
                                <input readonly type="text" id="volume" name="volume" value="{{$pump['Data']['LastVolume']}}" />

                                @elseif ($pump['Type']==='PumpOfflineStatus')
                                <input readonly type="text" id="volume" name="volume" value="0" />
                                @elseif ($pump['Type']==='PumpFillingStatus')
                                <input readonly type="text" id="volume" name="volume" value="{{$pump['Data']['Volume']}}" />
                                @elseif ($pump['Type']==='PumpEndOfTransactionStatus')
                                    <input readonly type="text" id="volume" name="eotvolume" value="{{$pump['Data']['Volume']}}" />
                                @endif
                            </div>
                            <div class="label-input-group">
                                <label for="amount">Amount:</label>
                                @if ($pump['Type']==='PumpIdleStatus')
                                <input readonly type="text" id="amount" name="amount" value="{{$pump['Data']['LastAmount']}}" />

                                @elseif ($pump['Type']==='PumpOfflineStatus')
                                <input readonly type="text" id="amount" name="amount" value="0" />
                                @elseif ($pump['Type']==='PumpFillingStatus')
                                <input readonly type="text" id="amount" name="amount" value="{{$pump['Data']['Amount']}}" />
                                @elseif ($pump['Type']==='PumpEndOfTransactionStatus')
                                    <input readonly type="text" id="amount" name="eotamount" value="{{$pump['Data']['Amount']}}" />
                                @endif
                            </div>





                                <input type="hidden" name="pumpid" value="{{$pump['Id']}}">
                                {{-- <input type="hidden" name="nozzle" value="{{$pump['Data']['NozzleUp']}}"> --}}
                                <div class="btn-group" >
                                <button type="submit" class="start-button" style="background-color: #00cc00; color: #fff;" onclick="authorize({{$pump['Id']}})">
                                    Authorize
                                </button>

                                 <button type="button" class="stop-button " style="background-color: #ff0000; color: #fff;" onclick="stop({{$pump['Id']}})">
                                    Stop
                                </button>

                            </div>
                        </form>

                        <div style="display: none" class="item-display-container" id="pending-table">
                            <div class="item-display-container">
                                <table class="item-table">
                                    <thead>
                                        <tr style="position: sticky; top: 0; z-index: 1;">
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pending as $transaction)

                                        <tr>

                                            <td>{{ $transaction->nozzle }}</td>
                                            <td>{{ $transaction->price }}</td>
                                            <td>{{ $transaction->volume }}</td>
                                            <td>{{ $transaction->amount }}</td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <button type ="button"class="pt-button" style="background-color: #007bff; color: #fff" onclick="showTable({{$pump['Data']['Pump']}})" id="pendingtrans">
                        Pending Transaction
                    </button>
                </div>


                @endforeach





                  {{-- Mode of payment --}}

            </div>
            <div id="mopdiv">

               <button class="calcbutton">GCASH</button>
                <button class="calcbutton">PAYMAYA</button>
                <button class="calcbutton">BANK</button>
                <button class="calcbutton">BDO</button>
            </div>
            <div id="reports-column">

                <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
             </div>
             <div id="nonfuel-column">

                <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
             </div>
             <div id="manual-column">

                <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
             </div>
             <div id="config-column">

                <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
                 <button class="calcbutton">Lorem ipsum</button>
             </div>
        </div>
        </div>
        </div>

        <!-- MODAL -->

                </div>




        <script>


            function showTable(id){
                const tableContent = document.getElementById('pending-table').innerHTML;
            //    var pumpinput = document.getElementById("pumppendingtable");
            //      pumpinput.value = "id";
            //      console.log(id);

            Swal.fire({
                title: 'Pending Transaction Table',
                html:tableContent,
                scrollbarPadding: false
            });
        }
        const form = document.querySelector('form');

// Add an event listener for form submission
form.addEventListener('submit', (event) => {
  // Prevent the default form submission behavior
  event.preventDefault();

  // Show the success message using SweetAlert
  Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: 'Your form has been submitted successfully.',
    scrollbarPadding: false
  });
});
function authorize() {
            var pumpdataform = document.getElementById("pump-data");
            function isDocumentReady() {
            Swal.fire({
              title: 'Pump Authorized',
              icon: 'success',
              scrollbarPadding: false,
              showConfirmButton: false
            });
            // document.getElementById("pump-data").setAttribute('action','/authorizepump');
            // document.getElementById("pump-data").submit();

          }

          if (document.readyState === 'complete') {
            isDocumentReady();

          } else {
            document.addEventListener('DOMContentLoaded', isDocumentReady);
          }
}
function stop(Id){
    Swal.fire({
  title: 'Stop pump',
  text: 'Are you sure you want to stop this pump?',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes',
  cancelButtonText: 'No',
  dangerMode: true,
  scrollbarPadding: false

}).then((result) => {
  if (result.isConfirmed) {
    // Code to execute when "Yes" button is clicked
document.getElementById(Id).setAttribute('action','/stoppump');
    document.getElementById(Id).submit();
    Swal.fire({
        title:'Pump Stopped',
        icon:'success',
        scrollbarPadding: false
    });
  }
  else{
    Swal.fire({
        title:'Pump Continues',
        icon:'info',
        scrollbarPadding: false
    });
    console.log('Pump continues');
  }
});
}
const myinterval = setInterval(refresh, 500);

            function refresh() {
                $('#pump-column').load(document.URL + " #pump-column");
            }
            var pumpdiv = document.getElementById("pump-column");
            var mopdiv = document.getElementById("mopdiv");
            var reportsdiv = document.getElementById("reports-column");
            var nonfueldiv = document.getElementById("nonfuel-column");
            var manualdiv = document.getElementById("manual-column");
            var configdiv = document.getElementById("config-column");

            function mop() {
                reportsdiv.style.display = "none";
                pumpdiv.style.display = "none";
                nonfueldiv.style.display = "none";
                manualdiv.style.display = "none"
                mopdiv.style.display = "block";
                configdiv.style.display="none";
                console.log('mop clicked!');

                document.getElementById("mop-nav").setAttribute('class','is-active');
                document.getElementById("pump-nav").setAttribute('class','');
                document.getElementById("config-nav").setAttribute('class','');
                document.getElementById("reports-nav").setAttribute('class','');
                document.getElementById("nf-nav").setAttribute('class','');
                document.getElementById("manual-nav").setAttribute('class','');
            }

            function reports() {
                pumpdiv.style.display = "none";
                mopdiv.style.display = "none";
                nonfueldiv.style.display = "none";
                manualdiv.style.display = "none"
                reportsdiv.style.display = "block";
                configdiv.style.display="none";
                document.getElementById("mop-nav").setAttribute('class','');
                document.getElementById("pump-nav").setAttribute('class','');
                document.getElementById("config-nav").setAttribute('class','');
                document.getElementById("reports-nav").setAttribute('class','is-active');
                document.getElementById("nf-nav").setAttribute('class','');
                document.getElementById("manual-nav").setAttribute('class','');
            }

            function nonfuel() {
                pumpdiv.style.display = "none";
                mopdiv.style.display = "none";
                reportsdiv.style.display = "none";
                manualdiv.style.display = "none"
                nonfueldiv.style.display = "block";
                configdiv.style.display="none";
                document.getElementById("mop-nav").setAttribute('class','');
                document.getElementById("pump-nav").setAttribute('class','');
                document.getElementById("config-nav").setAttribute('class','');
                document.getElementById("reports-nav").setAttribute('class','');
                document.getElementById("nf-nav").setAttribute('class','is-active');
                document.getElementById("manual-nav").setAttribute('class','');
            }

            function pumps() {
                mopdiv.style.display = "none";
                reportsdiv.style.display = "none";
                nonfueldiv.style.display = "none";
                manualdiv.style.display = "none";
                configdiv.style.display="none";
                pumpdiv.style.display = "block";
                document.getElementById("mop-nav").setAttribute('class','');
                document.getElementById("pump-nav").setAttribute('class','is-active');
                document.getElementById("config-nav").setAttribute('class','');
                document.getElementById("reports-nav").setAttribute('class','');
                document.getElementById("nf-nav").setAttribute('class','');
                document.getElementById("manual-nav").setAttribute('class','');
            }

            function manual() {
                mopdiv.style.display = "none";
                reportsdiv.style.display = "none";
                nonfueldiv.style.display = "none";
                pumpdiv.style.display = "none";
                manualdiv.style.display = "block";
                configdiv.style.display="none";
                document.getElementById("mop-nav").setAttribute('class','');
                document.getElementById("pump-nav").setAttribute('class','');
                document.getElementById("config-nav").setAttribute('class','');
                document.getElementById("reports-nav").setAttribute('class','');
                document.getElementById("nf-nav").setAttribute('class','');
                document.getElementById("manual-nav").setAttribute('class','is-active');
            }
            function config() {
                mopdiv.style.display = "none";
                reportsdiv.style.display = "none";
                nonfueldiv.style.display = "none";
                pumpdiv.style.display = "none";
                manualdiv.style.display = "none";
                configdiv.style.display="block";
                document.getElementById("mop-nav").setAttribute('class','');
                document.getElementById("pump-nav").setAttribute('class','');
                document.getElementById("config-nav").setAttribute('class','is-active');
                document.getElementById("reports-nav").setAttribute('class','');
                document.getElementById("nf-nav").setAttribute('class','');
                document.getElementById("manual-nav").setAttribute('class','');

            }

            // Function to open the pending transaction modal
            function openPendingTransactionModal() {
                var modal = document.getElementById("pending-transaction-modal");
                modal.style.display = "block";
            }

            // Function to close the pending transaction modal
            function closePendingTransactionModal() {
                var modal = document.getElementById("pending-transaction-modal");
                modal.style.display = "none";
            }
        </script>
    </body>

    </html>
</x-app-layout>
