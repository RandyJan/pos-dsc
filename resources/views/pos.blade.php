<x-app-layout>
    {{-- @if(! Auth::user()->activeOrder())
<div>
    <p>Please login</p>
</div>
@else --}}

    <div class="pos-container">
  <!-- Use any element to open/show the overlay navigation menu -->

        <div class="left-column" id="left-column-div">
            <div id="mySidenav" class="sidenav">
                <center>
                <a href="#">
               <x-nav-logo style="width: 50px; height: 40px;" class="block h-10 w-auto fill-current text-gray-600" />
                </a>
            </center>
              <a href="#">Datalogic System Corp</a>
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                @foreach($cashier['Cashier'] as $cashierInfo)
                <a href="#">USER: {{$cashierInfo['Cashier_Name']}}</a>
                {{-- <a href="#">ID: {{$cashierInfo['Cashier_ID']}}</a> --}}
                @endforeach
                @foreach( $cashier['data'] as $cashierData)

                <a href="#">ROLE: {{$cashierData['Role_Name']}} </a>


                @endforeach

                <br><br>
                <form action="/logouts" method="GET">
                    <center>
                    {{-- <a href="/">logout</a> --}}

                    <button type="submit" style="color:white">Log out</button>
                </center>
                </form>
            </div>

              <!-- Item Display -->
            <div class="table-container" >
                <div class="item-display-container">
                    <table class="item-table" id="items-table" style="">
                        <thead>
                            <tr style="position:sticky;top: 0;z-index: 1;">
                                <th hidden>Transaction Id</th>
                                <th>Pump</th>
                                <th>Nozzle</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="transaction" hidden></td>
                                <td id="pump"></td>
                                <td id="nozzle"></td>
                                <td id="price"></td>
                                <td id="volume"></td>
                                <td id="amount">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="sub-total-div" id="sub-total-div">

                <label for="vatsale-total"> <b>VATSale: ₱</b>
                    <input type="text" id="vatsale-total" value="0" name="vatsale-total" class="sub-total" readonly>
                </label>
                <label for="vat-total"> <b>VAT: ₱</b>
                    <input type="text" id="vat-total" value="0" name="vat-total" class="sub-total" readonly>
                </label>
                <label for="sub-total"> <b>Sub total: ₱</b>
                    <input type="text" id="sub-total" value="0" name="sub-total" class="sub-total" readonly>
                </label>
            </div>
            <div class="calculator-buttons-container">
                <div class="calculator">
                    <input type="text" class="calculator-display" id="display" value="" placeholder="0.00" readonly>
                </div>
                <div class="calculator-buttons">
                    <button class="calcbutton" onclick="appendToDisplay('')">7</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">8</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">9</button>
                    <button class="special-button" onclick=clearbutton() style="background-color:lightcoral"> Clear</button>
                    <button class="special-button" id="voidButton" onclick="voidSelectedRow()" style="background-color:lightpink">Void</button>
                    <button class="special-button" style="background-color:violet" onclick="refreshb()"> refresh</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">4</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">5</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">6</button>
                    <button class="special-button" style="background-color: lightblue">Open Drawer</button>
                    <button class="special-button">Sub Total</button>
                    <button class="special-button" id="voidAll" style="background-color: orange">Void All</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">1</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">2</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">3</button>
                    <button class=" special-button">Print Receipt</button>
                    <button class="special-button" style="background-color: yellow">Zero Rated</button>
                    <button class="special-button">PG Disc</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">0</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">00</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">.</button>
                    <button class=" special-button" id="calculateButton" style="background-color: lightgreen">Enter</button>
                    <button class="special-button">All Stop</button>
                    <button class=" special-button">All Auth</button>
                </div>
            </div>
        </div>
        <!-- Fuel Pumps -->
        <div class="right-column column" id= "right-column">

            <div class="tabs is-normal">
                <ul >
                    <li id="pump-nav" class="is-toggled"><a onclick="pumps()">Pumps</a></li>
                    <li id="mop-nav"><a onclick="mop()">MOP</a></li>
                    <li id="manual-nav"><a onclick="manual()">Manual</a></li>
                    <li id="nf-nav"><a onclick="nonfuel()">Non-fuel</a></li>
                    <li id="reports-nav"><a onclick="reports()">Reports</a></li>
                    <li id="config-nav"><a onclick="config()">Config</a></li>

                </ul>
                <a id="settings-nav" style="position:relative;right:5px;top:0px" onclick="openNav()"> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                  </svg></a>
            </div>

            <div id="pump-div" class="pump-items-container">
                @foreach ($datab as $pump )
                {{-- <div id="pump-div" class="pump-items-container"> --}}
                <div class="pump-items-container" id="pump-column">
                    <form action="/authorizepump" method="GET" id="{{$pump['Id']}}">
                        @csrf
                        <input type="hidden" name="nozzle" value="{{$pump['Data']['NozzleUp']}}" id="nozup">
                        <input type="hidden" name="id"value = "{{$pump['Id']}}">
                        <div class="pump-item text-dark" onclick="pumpDetails({{$pump['Id']}})" id="pump-column">

                            @if ($pump['Type']==='PumpIdleStatus' && $pump['Data']['NozzleUp'] !== 0 )

                                  

                                         <input type="hidden" name="nozzle" value="{{$pump['Data']['NozzleUp']}}" id="nozup">
                                                <h3 style="background-color: lightgreen" class="card-header">
                                                    <a class="pump-number"> {{$pump['Id']}} </a>
                                                    <a class="card-header-title p-0">NOZZLE </a>
                                                </h3>
                                                    <p style="position: absolute;padding-left:5px;">{{$pump['Data']['NozzleUp']}}</p>
                                                  <center>
                                                    <img src="img/premium.png" class="img-icon">
                                                </center>
                                                  <div class="pump-thumb-details">
                                                      <p style="background-color:white">A: {{ $pump['Data']['LastAmount'] }}<br>
                                                      L: {{ $pump['Data']['LastVolume'] }}</p>
                                                  </div>
                              
                      @elseif ($pump['Type']==='PumpOfflineStatus')

                            <h3 style="background-color: #FFCCCB" class="card-header">
                            <a class="pump-number"> {{$pump['Id']}} </a>
                            <a class="card-header-title p-0" style="color: #ff0000">OFFLINE</a>
                            </h3>
                            <center><img src="img/offline.png"></center>

                            @elseif ($pump['Type']==='PumpFillingStatus')

                            <h3 style="background-color: lightblue" class="card-header">
                                <a class="pump-number"> {{$pump['Id']}} </a>
                                <a class="card-header-title p-0" style="color: red">FILLING</a>
                            </h3>
                            <center><img src="img/loadingFilling.gif" class="img-icon" style="margin-left:25px;opacity:1"> </center>
                            <div class="pump-thumb-details">
                                <p>A: {{ $pump['Data']['Amount'] }}<br>
                                    L: {{ $pump['Data']['Volume'] }}</p>
                            </div>

                            @elseif ($pump['Type']==='PumpEndOfTransactionStatus')

                            <h3 style="background-color:rgb(93, 225, 93)" class="card-header"><a class="pump-number"> {{$pump['Id']}} </a><a class="card-header-title p-0">DONE</a></h3>
                            <center><img src="img/done-filling.gif"></center>
                            @else
                            <h3 style="background-color:#FFD580;" class="card-header"><a class="pump-number">{{$pump['Id']}} </a> <a class="card-header-title p-0">IDLE</a></h3>
                            <center><img src="img/idle.png" class="img-icon"></center>
                            <div class="pump-thumb-details">
                                <p>A: {{ $pump['Data']['LastAmount'] }}<br>
                                    L: {{ $pump['Data']['LastVolume'] }}</p>
                             </div>
                        {{-- <h1>you have no pumps</h1> --}}
                            @endif
                        </div>

                        <div id="pump-details-{{$pump['Id']}}" class="pump-details" style="display: none;">
                            <div class="label-input-group">

                                <label for="price" style="font-size: 20px">Price:</label>

                                @if ($pump['Type']==='PumpIdleStatus')

                                <input readonly type="text" id="price" name="price" value="{{$pump['Data']['LastPrice']}}" />
                                @elseif ($pump['Type']==='PumpOfflineStatus')
                                <input readonly type="text" id="price" name="price" value="0" />
                                @elseif ($pump['Type']==='PumpFillingStatus')
                                <input readonly type="text" id="price" name="price" value="{{$pump['Data']['Price']}}" />
                                @elseif ($pump['Type']==='PumpEndOfTransactionStatus')
                                <input readonly type="text" id="price" name="price" value="{{$pump['Data']['Price']}}" />
                                @endif

                            </div>
                            <div class="label-input-group">
                                <label for="volume" style="font-size: 20px">Volume:</label>
                                @if ($pump['Type']==='PumpIdleStatus')

                                <input readonly type="text" id="volume" name="volume" value="{{$pump['Data']['LastVolume']}}" />

                                @elseif ($pump['Type']==='PumpOfflineStatus')
                                <input readonly type="text" id="volume" name="volume" value="0" />
                                @elseif ($pump['Type']==='PumpFillingStatus')
                                <input readonly type="text" id="volume" name="volume" value="{{$pump['Data']['Volume']}}" />
                                @elseif ($pump['Type']==='PumpEndOfTransactionStatus')
                                <input readonly type="text" id="volume" name="volume" value="{{$pump['Data']['Volume']}}" />
                                @endif
                            </div>
                            <div class="label-input-group">
                                <label for="amount" style="font-size: 20px">Amount:</label>
                                @if ($pump['Type']==='PumpIdleStatus')

                                <input readonly type="text" id="amount" name="amount" value="{{$pump['Data']['LastAmount']}}" />

                                @elseif ($pump['Type']==='PumpOfflineStatus')
                                <input readonly type="text" id="amount" name="amount" value="0" />
                                @elseif ($pump['Type']==='PumpFillingStatus')
                                <input readonly type="text" id="amount" name="amount" value="{{$pump['Data']['Amount']}}" />
                                @elseif ($pump['Type']==='PumpEndOfTransactionStatus')
                                <input readonly type="text" id="amount" name="amount" value="{{$pump['Data']['Amount']}}" />
                                @endif
                            </div>
                            <label for="idpump"></label>
                            <input type="hidden" name="pumpid" value="{{$pump['Id']}}" id="idpump">
                            <div class="btn-group">
                                <button type="button" class="start-button"
                                style="background-color: #00cc00; color: #fff;height:8vh;width:18vh;border-radius:50px;font-size:20px" onclick="authorize({{$pump['Id']}})">
                                    Authorize
                                </button>
                                <button type="button" class="stop-button "
                                style="background-color: #ff0000; color: #fff;padding:10px;width:17vh;border-radius:50px;font-size:20px" onclick="stop({{$pump['Id']}})">
                                    Stop
                                </button>
                            </div>
                    </form>
                    <div style="display: none" class="item-display-container" id="pending-table-{{ $pump['Id'] }}">
                        <div class="item-display-container">
                            <table class="item-table">
                                <thead>
                                    <tr style="position: sticky; top: 0;  z-index: 1;">
                                        <th>Nozzle</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Pay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($pendingTransactionsByPump[$pump['Id']]) && count($pendingTransactionsByPump[$pump['Id']]) > 0)
                                    @foreach ($pendingTransactionsByPump[$pump['Id']] as $transaction)
                                   
                                    <tr id="transaction-row-{{ $transaction->id }}">
                                        <td>{{ $transaction->nozzle }}</td>
                                        <td>{{ $transaction->price }}</td>
                                        <td>{{ number_format($transaction->volume,2) }}</td>
                                        <td>{{ number_format($transaction->amount,2) }}</td>
                                        <td>
                                            @if ($transaction->status == 0)
                                            <button class="btn btn-light pay-button pending-transaction-button" data-transaction-id="{{ $transaction->id }}" onclick="payTransaction({{ $transaction->id}},{{ $transaction->amount }}
                                            ,{{ $transaction->price }})">
                                                <img src="img/payment.png" alt="Pay Now">
                                            </button>
                                            @else
                                            <button class="btn btn-light pay-button pending-transaction-button" data-transaction-id="{{ $transaction->id }}" disabled>
                                                <img src="img/payment.png" alt="Pay Now">
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6">No pending transactions for this pump.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="button" class="pt-button" style="background-color: #007bff; color: #fff;height:8vh;padding:5px;border-radius:50px;font-size:20px;width:18vh" onclick="showTable({{ $pump['Id'] }})">
                        Pending
                    </button>
                </div>
            </div>
            @endforeach
    </div>
        <form action="/receipt" method="POST" id="printform">
            @csrf
            <input type="hidden" name="transactionNumber" id = "trn" >
        </form>
        {{-- Mode of payment --}}

        {{-- <iframe src="{{ route('transaction') }}" width="100%" height="300" id="reciept" style="display: block"></iframe> --}}

        {{-- <iframe id="os-iframe"src="{{ route('transaction') }}"  class="h-75" width="100%" height="80%" frameborder="0" allowTransparency="true" style="display: none" ></iframe> --}}
        <div id = "invoicePOS" style="display:none;position:absolute"></div>

    <div id="test">
        <div id="mop-div" class="mop-column">
            @foreach($mopData as $mop)
            <button type="submit" class ="mop-btn"id="mop-{{trim($mop['id'])}}"
             style="min-width:25%;height:60px"
             onclick="modeOfPayment({{$mop['id']}},{{$mop['partialTender']}},{{$mop['change']}})">{{$mop['keyLabel']}}</button>
            @endforeach
        </div>
        <div id="reports-column">
           {{-- <center> <img src="{{Asset('img/underDevelopment.png')}}" alt="" style = "width: 40vh;">
           <p style="font-size: 50px">Under Development</p>
        </center> --}}
            {{-- <button class="calcbutton">Lorem ipsum</button>
            <button class="calcbutton">Lorem ipsum</button>
            <button class="calcbutton">Lorem ipsum</button>
            <button class="calcbutton">Lorem ipsum</button> --}}
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
        <div id="config-column" class="config">
            <div class="settingDiv">
           <p> Pump sound notification sound</p>
            <label class="switch">
                <input type="checkbox" id="notifSound" onclick="soundSetting()"  checked>
                <span class="slider round"></span>
              </label><br><br>
            </div>
            <div class="settingDiv">
                <p> Toggle auto log out</p>
                 <label class="switch">
                     <input type="checkbox" id = "logOut" checked>
                     <span class="slider round"></span>
                   </label><br><br>
                 </div>
                 <div class="settingDiv">
                    <p> Darkmode</p>
                     <label class="switch">
                         <input type="checkbox" id = "darkMode" checked>
                         <span class="slider round"></span>
                       </label><br><br>
                     </div>
        </div>
    </div>
    </div>
    <form action="/getitems" method="POST">

        <input type="hidden" name="item-no" id = "item-no">
        <input type="hidden" name="nozzle-data" id="nozzle-data">
        <input type="hidden" name="price-data" id="price-data">
        <input type="hidden" name="amount-data" id="amount-data">
        <input type="hidden" name="transactionid-data" id = "transactionid-data">
        {{-- <button type="submit">test button</button> --}}
    </form>
    <input type="hidden" name="vat-amount" id="vat-amount">
    <input type="hidden" name="vat-sale" id="vat-sale">

</x-app-layout>
    <script>

function refreshb() {
    location.href = '/pos';
}


        function showTable(pumpId) {
            const tableContent = document.getElementById('pending-table-' + pumpId).innerHTML;
            Swal.fire({
                title: 'Pending Transaction Table',
                html: tableContent,
                scrollbarPadding: false,
            });
        }

        function pumpDetails(Id) {
            var details = document.getElementById("pump-details-" + Id).innerHTML;
            var id = Id;
            var isOpen = true;

            const mySwal = Swal.fire({
                title: 'Pump ' + id,
                html: details,
                scrollbarPadding: false,
                showCloseButton: true,
                showConfirmButton: false,
                didClose: () => {
                    isOpen = false;
                },
                preConfirm: () => {
                    var newDetails = document.getElementById("pump-details-" + Id).innerHTML;
                    return newDetails;
                }
            });

            setInterval(function() {
                if (isOpen) {
                    mySwal.update();
                }
            }, 500);
        }

        function authorize(Id) {
            document.getElementById(Id).setAttribute('action', '/authorizepump');
            document.getElementById(Id).submit();

            function isDocumentReady() {
                Swal.fire({
                    title: 'Pump Authorized',
                    icon: 'success',
                    scrollbarPadding: false,
                    showConfirmButton: false
                });
            }

            if (document.readyState === 'complete') {
                isDocumentReady();

            } else {
                document.addEventListener('DOMContentLoaded', isDocumentReady);

            }
           // fullscreenMode();
        }

        function stop(Id) {
            // Swal.fire({
            //     title: 'Stop pump',
            //     text: 'Are you sure you want to stop this pump?',
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonText: 'Yes',
            //     cancelButtonText: 'No',
            //     dangerMode: true,
            //     scrollbarPadding: false
            // }).then((result) => {
            //     if (result.isConfirmed) {
                    // Code to execute when "Yes" button is clicked

                    document.getElementById(Id).setAttribute('action', '/stoppump');
                    document.getElementById(Id).submit();
                    // alertify.success('Pump Stopped')
                    Swal.fire({
                        title: 'Pump Stopped',
                        icon: 'warning',
                        scrollbarPadding: false,
                        showConfirmButton: false
                    });
            //     } else {
            //         Swal.fire({
            //             title: 'Pump Continues',
            //             icon: 'info',
            //             scrollbarPadding: false
            //         });
            //         console.log('Pump continues');
            //     }
            // });
        }
     const myinterval = setInterval(refresh, 1000);

        function refresh() {
            $('#pump-div').load(document.URL + " #pump-div");
        }
        var pumpdiv = document.getElementById("pump-div");
        var pumpcolumn = document.getElementById("pump-column");
        var mopdiv = document.getElementById("mop-div");
        var reportsdiv = document.getElementById("reports-column");
        var nonfueldiv = document.getElementById("nonfuel-column");
        var manualdiv = document.getElementById("manual-column");
        var configdiv = document.getElementById("config-column");


//   if (lightGreenCounta > 0) {
//     alert('Number of light green divs: ' + lightGreenCounta);
//   }
// }
const parentDiv = document.getElementById('pump-div');
let previousBlueH1Count = 0;

function countAndPlaySound() {
    const notifSetting = document.getElementById('notifSound').checked;

if(notifSetting){

    const childDivs = parentDiv.querySelectorAll('#pump-column');
  let currentBlueH1Count = 0;

  childDivs.forEach((div) => {
    const h1Elements = div.querySelectorAll('h3');
    h1Elements.forEach((h3) => {
      const color = h3.style.backgroundColor;
      if (color === 'lightgreen') {
        currentBlueH1Count++;
      }
    });
  });

  if (currentBlueH1Count > previousBlueH1Count) {
    playSound();
  }

  // Update the previous count to the current count
  previousBlueH1Count = currentBlueH1Count;
}
else{
    console.log('sound is turned off')
}
}

// Check the count and play the sound every 1 second
setInterval(countAndPlaySound, 500);

// soundSetting();
    function playSound(){
        const audio = new Audio('audio/notif.mp3');
    audio.play();

    }
        function mop() {
            reportsdiv.style.visibility = "none";
            pumpdiv.style.display = "none";
            // nonfueldiv.style.display = "none";
            // manualdiv.style.display = "none"
            configdiv.style.display = "none";
            mopdiv.style.display = "flex";
            pumpcolumn.style.display = "none";
            console.log('mop clicked!');
            document.getElementById("mop-nav").setAttribute('class', 'is-toggled');
            document.getElementById("pump-nav").setAttribute('class', '');
            document.getElementById("config-nav").setAttribute('class', '');
            document.getElementById("reports-nav").setAttribute('class', '');
            // document.getElementById("nf-nav").setAttribute('class', '');
            // document.getElementById("manual-nav").setAttribute('class', '');
        }

        function reports() {
            console.log("reports");
            pumpdiv.style.display = "none";
            mopdiv.style.display = "none";
            nonfueldiv.style.display = "none";
            manualdiv.style.display = "none"
            reportsdiv.style.display = "flex";
            configdiv.style.display = "none";
            document.getElementById("mop-nav").setAttribute('class', '');
            document.getElementById("pump-nav").setAttribute('class', '');
            document.getElementById("config-nav").setAttribute('class', '');
            document.getElementById("reports-nav").setAttribute('class', 'is-toggled');
            document.getElementById("nf-nav").setAttribute('class', '');
            document.getElementById("manual-nav").setAttribute('class', '');
        }

        // function nonfuel() {
        //     console.log("nonfuel");
        //     pumpdiv.style.display = "none";
        //     mopdiv.style.display = "none";
        //     reportsdiv.style.display = "none";
        //     manualdiv.style.display = "none"
        //     nonfueldiv.style.display = "block";
        //     configdiv.style.display = "none";
        //     document.getElementById("mop-nav").setAttribute('class', '');
        //     document.getElementById("pump-nav").setAttribute('class', '');
        //     document.getElementById("config-nav").setAttribute('class', '');
        //     document.getElementById("reports-nav").setAttribute('class', '');
        //     document.getElementById("nf-nav").setAttribute('class', 'is-active');
        //     document.getElementById("manual-nav").setAttribute('class', '');
        // }

        function pumps() {
            console.log("pumps")
            mopdiv.style.display = "none";
            reportsdiv.style.display = "none";
            // nonfueldiv.style.display = "none";
            // manualdiv.style.display = "none";
            configdiv.style.display = "none";
            pumpdiv.style.display = "flex";
            document.getElementById("mop-nav").setAttribute('class', '');
            document.getElementById("pump-nav").setAttribute('class', 'is-toggled');
            document.getElementById("config-nav").setAttribute('class', '');
            document.getElementById("reports-nav").setAttribute('class', '');
            // document.getElementById("nf-nav").setAttribute('class', '');
            // document.getElementById("manual-nav").setAttribute('class', '');
        }

        // function manual() {
        //     mopdiv.style.display = "none";
        //     reportsdiv.style.display = "none";
        //     nonfueldiv.style.display = "none";
        //     pumpdiv.style.display = "none";
        //     manualdiv.style.display = "block";
        //     configdiv.style.display = "none";
        //     console.log("manual");
        //     document.getElementById("mop-nav").setAttribute('class', '');
        //     document.getElementById("pump-nav").setAttribute('class', '');
        //     document.getElementById("config-nav").setAttribute('class', '');
        //     document.getElementById("reports-nav").setAttribute('class', '');
        //     document.getElementById("nf-nav").setAttribute('class', '');
        //     document.getElementById("manual-nav").setAttribute('class', 'is-active');
        // }

        function config() {
            console.log("config");
            mopdiv.style.display = "none";
            reportsdiv.style.display = "none";
            nonfueldiv.style.display = "none";
            pumpdiv.style.display = "none";
            manualdiv.style.display = "none";
            configdiv.style.display = "flex";
            document.getElementById("mop-nav").setAttribute('class', '');
            document.getElementById("pump-nav").setAttribute('class', '');
            document.getElementById("config-nav").setAttribute('class', 'is-toggled');
            document.getElementById("reports-nav").setAttribute('class', '');
            document.getElementById("nf-nav").setAttribute('class', '');
            document.getElementById("manual-nav").setAttribute('class', '');
        }
    </script>

    <!-- Append a transaction to the item display container -->
    <script>
        // Function to save transactions to local storage
        function saveTransactionsToLocalStorage(transactions) {
            localStorage.setItem('transactions', JSON.stringify(transactions));
        }

        // Function to retrieve transactions from local storage
        function getTransactionsFromLocalStorage() {
            var transactions = localStorage.getItem('transactions');
            return transactions ? JSON.parse(transactions) : [];
        }

        // Function to initialize the item display container with transactions from local storage
        function taxTotal(vat,vatsale){
            var vatainputdisp = document.getElementById('vat-total');
           var vatsinputdisp = document.getElementById('vatsale-total');
           vatainputdisp.value = vat;
           vatsinputdisp.value = vatsale;

        }
        function itemsTotal(){
            const table = document.getElementById('items-table');
            const rows = table.querySelectorAll('tr');

            let sum = 0;

            rows.forEach((row) => {
                const cells = row.querySelectorAll('td');
                const fifthCell = cells[5];

                if (fifthCell) {
                    const value = parseFloat(fifthCell.textContent.replace(",",""));
                    if (!isNaN(value)) {
                        sum += value;
                    }
                }
            });
            return sum;
        }
        function initializeItemDisplayContainer() {
            var transactions = getTransactionsFromLocalStorage();
            transactions.forEach(function(transaction) {
                appendTransactionToDisplay(transaction);
            });

           var sum = itemsTotal();

            var vatsale = sum / 1.12;
            var vat = sum - vatsale;
            // console.log("Sub total:" + sum);
            // console.log("vat sale:" + vatsale);
            // console.log("vat amount:" + vat);
            var vatainput = document.getElementById('vat-amount');
           var vatsinput = document.getElementById('vat-sale');

          taxTotal(vat,vatsale);
           vatainput.value = vat;
           vatsinput.value = vatsale;
            var subttl = document.getElementById("sub-total");
            subttl.value = sum;
        }

        // Call the initialization function when the page loads
        $(document).ready(function() {
            initializeItemDisplayContainer();
        });

        // Attach a click event handler to the "Clear" button
        function clearbutton(){
            // document.getElementById('clearButton').addEventListener('click', function() {
            // clearTransactions();
            var display = document.getElementById("display");
            var clear = display.value = 0;
            console.log("sub total is now" + clear);
        // });

        }



    </script>
    <script>
        const table = document.querySelector('.item-table');
        const lastRowIndex = table.rows.length - 1;
        var itemdata = []
        var itemno = 1;
   

        table.deleteRow(lastRowIndex);

        // Function to add a transaction to local storage and the item display container
        function addTransactionToLocalStorageAndDisplay(transaction) {
            var transactions = getTransactionsFromLocalStorage();
            transactions.push(transaction);
            saveTransactionsToLocalStorage(transactions);
            appendTransactionToDisplay(transaction);
        }

        // Function to append a transaction to the item display container
        function appendTransactionToDisplay(transaction, callback) {
            var subttl = document.getElementById("sub-total");
        var total = parseFloat(subttl.value);
        var money = document.getElementById("display");
        var moneyb = parseFloat(money.value);
        var vatsale = total / 1.12;
        var vat = total - vatsale;
            var tableBody = document.querySelector('.item-table tbody');
            var newRow = tableBody.insertRow(0);

            newRow.setAttribute("onclick", "selectRow(this)");

            // Create table cells for each column
            var transactionCell = newRow.insertCell(0);
            var pumpCell = newRow.insertCell(1);
            var nozzleCell = newRow.insertCell(2);
            var priceCell = newRow.insertCell(3);
            var volumeCell = newRow.insertCell(4);
            var amountCell = newRow.insertCell(5);

            // Fill the table cells with data
            transactionCell.textContent = transaction.transaction;
            pumpCell.textContent = transaction.pump;
            nozzleCell.textContent = transaction.nozzle;
            priceCell.textContent = transaction.price;
            volumeCell.textContent = transaction.volume;
            amountCell.textContent = transaction.amount;
            transactionCell.style.display = 'none';

            // ................

            var items = {
                itemNumber: itemno,
                itemType:2,
                itemDesc: transaction.nozzle,
                itemPrice: transaction.price,
                itemQTY: transaction.volume,
                itemValue: transaction.amount,
                itemID: transaction.transaction,
                itemTaxAmount:vat,
                deliveryID:1,
                itemTaxId: 1,
                gcNumber:null,
                gcAmount:null,
                originalItemValuePreTaxChange:vatsale,
                isZeroRatedTaxItem:0,
                isTaxExemptItem:0,
                itemDiscTotal:null,
                departmentID:1,
                itemDiscCodeType:null,
                itemDBPrice: transaction.price,
            }
            itemno++;
            itemdata.push(items);
        }
        console.log(itemdata);
        function payTransaction(transactionId, amount,price) {
            console.log(transactionId + '-'+amount+'-'+price+'-');
            $.ajax({
                url: '/payTransaction',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'transactionId': transactionId
                },
                success: function(data) {
                    $('[data-transaction-id="' + transactionId + '"]').prop('disabled', true);
                    // Add the transaction to local storage and the item display container
                    addTransactionToLocalStorageAndDisplay(data);

                    var subttl = document.getElementById("sub-total");
                    var total = parseFloat(subttl.value);
                    var payable = total + amount;
                    var final = subttl.value = payable;


                      var vatsale = payable / 1.12;
                     var vat = payable - vatsale;
                    taxTotal(vat,vatsale);
                    // console.log("hello" + final);
                },
                error: function(response) {
                    console.log(response);
                    alert('Failed to fetch transaction details.');
                }
            });
           
        }

  function printDiv(divId) {
  var printContents = document.getElementById(divId).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}
function generateReceipt(){
    $.ajax({
  url: '/receipt', // Replace with your server endpoint URL
  method: 'GET',
  success: function(htmlContent) {
    // Display the rendered Blade template on the web page
    $('#invoicePOS').html(htmlContent);
    // $('#invoicePOS').contentWindow.print();
    printDiv('invoicePOS');
  },
  error: function() {
    console.log('Error: Failed to retrieve and render the Blade template');
  }
});

}

        var tabledata = document.getElementById("items-table");
        var data = [];
        var itemno = 1;
function submitToPrint(){
   

    var receipt = document.getElementById("printform");
    receipt.submit();
    itemdata = [];
}
function updateTrans(id){
    $.ajax({
  url: '/updateTrans',
  type: 'POST',
  data:{
    '_token': '{{ csrf_token() }}',
    'transaction':id},
  success: function(response) {
    // Handle the response from the controller

    console.log("transaction updated!");
  },
  error: function(response) {

    console.log("transaction update failed")

  }
});
}
function sendPayload(transactiondata){
    console.log(transactiondata);
    console.log("above me");
    $.ajax({
  url: '/getitems',
  type: 'POST',
  data:{
    '_token': '{{ csrf_token() }}',
    'data':transactiondata},
  success: function(response) {
    // Handle the response from the controller
    var transNo = document.getElementById("trn");
    transNo.value = response;
    var test = transNo.value;
    console.log(response);
    // alert(test);
    console.log("request sent!");
  },
  error: function(response) {
    console.log(response);
    console.log("request failed")

  }
});
}


function addItemData(keyvalue,totalv){
  
    var subttl = document.getElementById("sub-total");
    var total = parseFloat(subttl.value);
    var money = document.getElementById("display");
    var moneyb = parseFloat(money.value);
    var vatsale = total / 1.12;
    var vat = total - vatsale;
    var paymentdata = {
                itemNumber: itemno,
                itemType:7,
                itemDesc:keyvalue,
                itemPrice:(moneyb == null || isNaN(moneyb) || moneyb == 0) ? total: moneyb,
                itemQTY: 1,
                itemValue:(moneyb == null || isNaN(moneyb) || moneyb == 0) ? total: moneyb,
                itemID:1,
                itemTaxAmount:0,
                deliveryID:1,
                itemTaxId: 1,
                gcNumber:null,
                gcAmount:null,
                originalItemValuePreTaxChange:0,
                isTaxExemptItem:0,
                isZeroRatedTaxItem:0,
                itemDiscTotal:null,
                departmentID:null,
                itemDiscCodeType:null,
                itemDBPrice:0,
            }
            itemno++;
            itemdata.push(paymentdata);
            console.log(itemdata);
}


function addChange(){
  
  var subttl = document.getElementById("sub-total");
  var total = parseFloat(subttl.value);
  var money = document.getElementById("display");
  var moneyb = parseFloat(money.value);
  var vatsale = total / 1.12;
  var vat = total - vatsale;
  var change = moneyb - total;
  var paymentdata = {
              itemNumber: itemno,
              itemType:10,
              itemDesc:"Change",
              itemPrice:change,
              itemQTY: 1,
              itemValue:change,
              itemID:1,
              itemTaxAmount:0,
              deliveryID:1,
              itemTaxId: 1,
              gcNumber:null,
              gcAmount:null,
              originalItemValuePreTaxChange:0,
              isTaxExemptItem:0,
              isZeroRatedTaxItem:0,
              itemDiscTotal:null,
              departmentID:null,
              itemDiscCodeType:null,
              itemDBPrice:0,
          }
          itemno++;
          itemdata.push(paymentdata);
          console.log(itemdata);
          console.log("this is the moneyb:"+moneyb);
          console.log("this is the total:"+total);
}


function transactionDataPayload(){
    var subttl = document.getElementById("sub-total");
        var total = parseFloat(subttl.value);
        var money = document.getElementById("display");
        var moneyb = parseFloat(money.value);
        var vatsale = itemsTotal() / 1.12;
        var vat =  itemsTotal() - vatsale;
    var datab = JSON.stringify(data);
            var transactiondata = {
            cashierID:1,
            subAccID:null,
            accountID:null,
            posID:1,
            taxTotal:vat ?? 0,
            saleTotal:vatsale,
            isManual:0,
            isZeroRated:0,
            customerName:null,
            address:null,
            TIN:null,
            businessStyle:null,
            cardNumber:null,
            approvalCode:null,
            bankCode:null,
            type:null,
            isRefund:0,
            transaction_type:1,
            isRefundOrigTransNum:null,
            transaction_resetter:null,
            birReceiptType:null,
            poNum:null,
            plateNum:null,
            odometer:null,
            transRefund:0,
            grossRefund:0,
            subAccAmt:null,
            vehicleTypeID:6,
            isNormalTrans:1,
            items:itemdata
            }
            console.log(transactiondata);
      var jsonData = JSON.stringify(transactiondata);
            return transactiondata;
}
function modeOfPayment(id,pt,ct){
    var subttl = document.getElementById("sub-total");
        var total = parseFloat(subttl.value);
        var money = document.getElementById("display");
        var moneyb = parseFloat(money.value);
        var vatsale = itemsTotal() / 1.12;
        var vat = total - vatsale;


         var key = document.getElementById('mop-' + id);
        var keyvalue = key.textContent;
        var tabledata = document.getElementById("items-table");
        console.log("this is the ct:" +ct);
        var cellfifth
        var change = '0';

        

        if( moneyb == 0 || moneyb == null || isNaN(moneyb)){
            alertify.success('Transaction Complete');
            // updateTrans(id);
            addItemData(keyvalue,total);
            sendPayload(transactionDataPayload());
            voidAllTransactions();
            submitToPrint();
        }
        else if( moneyb > total){ 
            if(ct == 0){
                alertify.error('This is not eligible for giving change');
            }
            else{
                
                var change = moneyb - total;
                // subttl.value = 0;
                Swal.fire({
                title: "Change",
                text: "Php " + change,
                icon: "success",
                scrollbarPadding: false
            })
            updateTrans(id);
            addItemData(keyvalue);
            addChange();
            sendPayload(transactionDataPayload());
            submitToPrint();
            voidAllTransactions();
        alertify.success('Transaction Complete');
            }
        }
        else{
           subttl.value = total - moneyb;
        addItemData(keyvalue);

    alertify.success('Partial payment successful');

        }
    
      

}

//  function addmop(id, pt, cd) {

//         // alert(label);
//         // console.log(label);
//         var key = document.getElementById('mop-' + id);
//         var keyvalue = key.textContent;
//         var subttl = document.getElementById("sub-total");
//         var total = parseFloat(subttl.value);
//         var money = document.getElementById("display");
//         var moneyb = parseFloat(money.value);
//         var vatsale = total / 1.12;
//         var vat = total - vatsale;
//         var tabledata = document.getElementById("items-table");
//         console.log(total);
//         var cellfifth
//         var change = '0';
//         if(moneyb > total){
//             change = moneyb - total;
//         }
        
//         if(total != 0){

//         for (var i = 1; i < tabledata.rows.length; i++){
//             var row = tabledata.rows[i];

//             var itemvalue = isNaN(parseFloat(row.cells[5].innerText,2)) ? moneyb : parseFloat(row.cells[5].innerText,2);
//             var paymentvalue = (moneyb == null || moneyb == 0 )? total: moneyb;
//             var itemdata = {
//                 itemNumber: itemno,
//                 itemType:2,
//                 itemDesc:row.cells[2].innerText,
//                 itemPrice: row.cells[3].innerText,
//                 itemQTY: row.cells[4].innerText,
//                 itemValue:itemvalue,
//                 itemID:row.cells[0].innerText,
//                 itemTaxAmount:vat,
//                 deliveryID:1,
//                 itemTaxId: 1,
//                 gcNumber:null,
//                 gcAmount:null,
//                 originalItemValuePreTaxChange:vatsale,
//                 is_zero_rated_tax_item:0,
//                 is_tax_exempt_item:0,
//                 itemDiscTotal:null,
//                 departmentID:null,
//                 itemDiscCodeType:null,
//                 itemDBPrice:row.cells[3].innerText,
//             }
//             data.push(itemdata);
//             itemno++;

//         }

//         var paymentdata = {
//                 itemNumber: itemno,
//                 itemType:7,
//                 itemDesc:keyvalue,
//                 itemPrice:total,
//                 itemQTY: 1,
//                 itemValue:0,
//                 itemID:1,
//                 itemTaxAmount:0,
//                 deliveryID:1,
//                 itemTaxId: 1,
//                 gcNumber:null,
//                 gcAmount:null,
//                 originalItemValuePreTaxChange:0,
//                 is_tax_exempt_item:0,
//                 is_zero_rated_tax_item:0,
//                 itemDiscTotal:null,
//                 departmentID:null,
//                 itemDiscCodeType:null,
//                 itemDBPrice:0,
//             }

//         data.push(paymentdata);
//         if(change > 0 ){
//             var changedata = {
//                 itemNumber: itemno,
//                 itemType:10,
//                 itemDesc:'Change',
//                 itemPrice:change,
//                 itemQTY: 1,
//                 itemValue:0,
//                 itemID:1,
//                 itemTaxAmount:0,
//                 deliveryID:1,
//                 itemTaxId: 1,
//                 gcNumber:null,
//                 gcAmount:null,
//                 originalItemValuePreTaxChange:0,
//                 is_tax_exempt_item:0,
//                 is_zero_rated_tax_item:0,
//                 itemDiscTotal:null,
//                 departmentID:null,
//                 itemDiscCodeType:null,
//                 itemDBPrice:0,
//             }
//             data.push(changedata);
//         }
//         // console.log(data);
//         var datab = JSON.stringify(data);
//             var transactiondata = {
//             cashierID:1,
//             subAccID:null,
//             accountID:null,
//             posID:1,
//             taxTotal:vat ?? 0,
//             saleTotal:vatsale,
//             isManual:0,
//             isZeroRated:0,
//             customerName:null,
//             address:null,
//             TIN:null,
//             businessStyle:null,
//             cardNumber:null,
//             approvalCode:null,
//             bankCode:null,
//             type:null,
//             isRefund:0,
//             transaction_type:1,
//             isRefundOrigTransNum:null,
//             transaction_resetter:null,
//             birReceiptType:null,
//             poNum:null,
//             plateNum:null,
//             odometer:null,
//             transRefund:0,
//             grossRefund:0,
//             subAccPmt:null,
//             vehicleTypeID:6,
//             isNormalTrans:1,
//             items:data
//             }
//             console.log(transactiondata);
//       var jsonData = JSON.stringify(transactiondata);
     
// }

// sendPayload(transactiondata);

// if (total == 0 ||isNaN(total)) {
//     Swal.fire({
//         title: "Please select transaction",
//         icon: "error",
//         scrollbarPadding: false
//     });
//     const data = {};
//     let

// } else {
//     if(id == 1){


//     if (moneyb == 0 || moneyb == null || isNaN(moneyb)) {
//         subttl.value = 0;
//         // Swal.fire({
//         //     title: "payment successful",
//         //     icon: "success",
//         //     scrollbarPadding: false
//         // })
//         updateTrans(id);
//         alertify.success('Transaction Complete');
//        submitToPrint();
//         // generateReceipt();
//         voidAllTransactions();

//         // location.reload('/pos');
//     //    $("#os-iframe").get(0).contentWindow.print();
//     }
//     else{
//         if(moneyb > total){
//             var change = moneyb - total;
//             subttl.value = 0;
//             Swal.fire({
//             title: "Change",
//             text: "Php " + change,
//             icon: "success",
//             scrollbarPadding: false
//         })
//     //    $("#os-iframe").get(0).contentWindow.print();
//     alertify.success('Transaction Complete');
//     voidAllTransactions();
//      submitToPrint();
//         }
//         else{
//             var remaining = total - moneyb;
//             subttl.value = remaining;
//             Swal.fire({
//             title: "Successfully paid cash Php" + moneyb,
//             text: "Remaining balance: Php " + remaining,
//             icon: "success",
//             scrollbarPadding: false

//         });
//       //  $("#os-iframe").get(0).contentWindow.print();

//         }
//         }

// }

// else if(id > 1 && pt ==1){
 
//  if(moneyb == total || moneyb == NULL){
//             var remaining = total - moneyb;
//             subttl.value = remaining;
//             Swal.fire({
//             title:"Successfuly paid  Php " + moneyb,
//             text: "Remaining balance: Php" + remaining,
//             icon: "success",
//             scrollbarPadding: false
//         })
//         submitToPrint();
//         }
//         else{
//             Swal.fire({
//             title: "Invalid",
//             text: "This mode of payment is  inelligible for giving change please enter exact amount or lesser amount.",
//             icon: "error",
//             scrollbarPadding: false
//         })
//         }

// }
// else{
//     alert("this payment mode is not elligible for partial tender");
// }

//     }



// }
    </script>
    <script>
        // Get the display element
        const display = document.getElementById('display');

        // Function to append the clicked number to the display
        function appendToDisplay(number) {
            const value = display.value;
            if( value == 0 && number ==0){
                display.value = 0;

            }
            if(value == 0){
                display.value = number;


            }
            else{

                display.value += number;
            }

            // if(!value.includes(".") && value > 0){
            //     display.value += number;
            // }
//             else{

// display.value += number;
// }

                // alert("display equal" + value);


        }

        // Function to clear the display
        function clearDisplay() {
            display.value = '';
        }

        // Add event listeners to the number buttons
        const numberButtons = document.querySelectorAll('.calcbutton:not(.special-button)');
        numberButtons.forEach(button => {
            button.addEventListener('click', () => {
                const number = button.textContent;
                appendToDisplay(number);
            });
        });

        // Add event listener to the clear button
      
        function test(){
        history.replaceState(null, document.title, location.href);
window.addEventListener('popstate', function(event) {
  history.replaceState(null, document.title, location.href);
});
}
test();
    </script>
    <script>
        /// Add an event listener to the "Void" button
        const voidButton = document.getElementById('voidButton');
        voidButton.addEventListener('click', function() {
            voidSelectedRow();
        });;

        // Function to select a row and highlight it
        function selectRow(row) {

            // Remove highlighting from any previously selected row
            const selectedRow = document.querySelector('.selected-row');
            if (selectedRow) {
                selectedRow.classList.remove('selected-row');
            }

            // Highlight the selected row
            row.classList.add('selected-row');
        }

        // Function to void the selected row
        function voidSelectedRow() {
            // Find the selected row
// location.reload();
            var subttl = document.getElementById("sub-total");
            subttl.value = 0;
            const selectedRow = document.querySelector('.selected-row');

            if (selectedRow) {
                // Get the transaction ID or other identifier for the selected row
                const transactionId = selectedRow.querySelector('td:first-child').textContent;
                // console.log('Transaction ID:', transactionId);

                // Send an AJAX request to mark the transaction as void
                $.ajax({
                    url: '/voidTransaction',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'transactionId': transactionId
                    },
                    success: function() {
                        // Remove the selected row from the table
                        selectedRow.remove();
                        // Remove the selected row from local storage
                        removeTransactionFromLocalStorage(transactionId);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Failed to void transaction');
                    }
                });
            }
        }

        // Function to remove a transaction from local storage
        function removeTransactionFromLocalStorage(transactionId) {
            const transactions = getTransactionsFromLocalStorage();
            const updatedTransactions = transactions.filter(transaction => transaction.transaction !== transactionId);
            saveTransactionsToLocalStorage(updatedTransactions);
        }
    </script>
    <script>
        // Function to void all transactions
        function voidAllTransactions() {
            var subttl = document.getElementById("sub-total");
            var vatttl = document.getElementById("vat-total");
            var vatsalettl = document.getElementById("vatsale-total");
            subttl.value = 0;
            vatttl.value = 0;
            vatsalettl.value = 0;

            // Clear transactions from local storage
            localStorage.removeItem('transactions');

            // Clear transactions from the item display container
            var tableBody = document.querySelector('.item-table tbody');
            tableBody.innerHTML = '';

        }
        // Attach a click event handler to the "Void All" button
        document.getElementById('voidAll').addEventListener('click', function() {
            voidAllTransactions();
        });
        /* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
//   document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
//   document.htmlContent.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.body.style.backgroundColor = "white";
}


    </script>

