<x-app-layout>
    <div class="pos-container">
        <div class="column left-column">
            <!-- Item Display -->
            <div class="table-container">
                <div class="item-display-container">
                    <table class="item-table">
                        <thead>
                            <tr style="position: sticky; top: 0;  z-index: 1;">
                                <th>Pump ID</th>
                                <th>Nozzle</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="pump"></td>
                                <td id="nozzle"></td>
                                <td id="price"></td>
                                <td id="volume"></td>
                                <td id="amount"></td>
                                <td id="state"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="calculator-buttons-container">
                <div class="calculator">
                    <input type="text" class="calculator-display" id="display" readonly placeholder="0.00" />
                </div>
                <div class="calculator-buttons">
                    <button class="calcbutton" onclick="appendToDisplay('')">7</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">8</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">9</button>
                    <button class="calcbutton clear-button" onclick="clearDisplay"> Clear</button>
                    <button class="calcbutton special-button">Void</button>
                    <button class="calcbutton special-button">Preset</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">4</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">5</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">6</button>
                    <button class="calcbutton special-button">Open Drawer</button>
                    <button class="calcbutton special-button">Sub Total</button>
                    <button class="calcbutton special-button" id="clearButton">Void All</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">1</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">2</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">3</button>
                    <button class="calcbutton special-button">Print Receipt</button>
                    <button class="calcbutton special-button">User</button>
                    <button class="calcbutton special-button">PG Disc</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">0</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">00</button>
                    <button class="calcbutton" onclick="appendToDisplay('')">.</button>
                    <button class="calcbutton special-button" id="calculateButton">Enter</button>
                    <button class="calcbutton special-button">All Stop</button>
                    <button class="calcbutton special-button">All Auth</button>
                </div>
            </div>
        </div>
        <!-- Fuel Pumps -->
        <div class="right-column column">

            <div class="tabs is-normal">
                <ul>
                    <li id="pump-nav" class="is-active"><a onclick="pumps()">Pumps</a></li>
                    <li id="mop-nav"><a onclick="mop()">MOP</a></li>
                    <li id="manual-nav"><a onclick="manual()">Manual</a></li>
                    <li id="nf-nav"><a onclick="nonfuel()">Non-fuel</a></li>
                    <li id="reports-nav"><a onclick="reports()">Reports</a></li>
                    <li id="config-nav"><a onclick="config()">Config</a></li>
                </ul>
            </div>
            <div id="pump-div" class="pump-items-container">
                @foreach ($datab as $pump )
                <div class="pump-items-container" id="pump-column">
                    <form action="/authorizepump" method="GET" id="{{$pump['Id']}}">
                        <div class="pump-item text-dark" onclick="pumpDetails({{$pump['Id']}})" id="pump-column">

                            @if ($pump['Type']==='PumpIdleStatus')

                            @if ($pump['Data']['NozzleUp'] > 0)
                            <input type="hidden" name="nozzle" value="{{$pump['Data']['NozzleUp']}}">
                            @if ($pump['Data']['NozzleUp'] === 1)
                            <h3 style="background-color: lightgreen" class="card-header"><a class="pump-number"> {{$pump['Id']}} </a><a class="card-header-title p-0">NOZZLE </a></h3>
                            <center><img src="img/premium.png" class="img-icon"></center>
                            <div class="pump-thumb-details">
                                <p>A: {{ $pump['Data']['LastAmount'] }}<br>
                                    L: {{ $pump['Data']['LastVolume'] }}</p>
                            </div>
                            @elseif ($pump['Data']['NozzleUp'] === 2)
                            <h3 style="background-color: lightgreen" class="card-header"> <a class="pump-number">{{$pump['Id']}} </a><a class="card-header-title p-0">NOZZLE </a></h3>
                            <center><img src="img/diesel.png" class="img-icon"></center>
                            <div class="pump-thumb-details">
                                <p>A: {{ $pump['Data']['LastAmount'] }}<br>
                                    L: {{ $pump['Data']['LastVolume'] }}</p>
                            </div>
                            @elseif ($pump['Data']['NozzleUp'] === 3)
                            <h3 style="background-color: lightgreen" class="card-header"> <a class="pump-number"> {{$pump['Id']}} </a><a class="card-header-title p-0">NOZZLE </a></h3>
                            <center><img src="img/regular.png" class="img-icon"></center>
                            <div class="pump-thumb-details">
                                <p>A: {{ $pump['Data']['LastAmount'] }}<br>
                                    L: {{ $pump['Data']['LastVolume'] }}</p>
                            </div>
                            @else
                            <h3 style="background-color: lightgreen" class="card-header"> <a class="pump-number">{{$pump['Id']}} </a><a class="card-header-title p-0">NOZZLE </a></h3>

                            @endif

                            @else
                            <h3 style="background-color:#FFD580;" class="card-header"><a class="pump-number">{{$pump['Id']}} </a> <a class="card-header-title p-0">IDLE</a></h3>
                            <center><img src="img/idle.png" class="img-icon"></center>
                            <div class="pump-thumb-details">
                                <p>A: {{ $pump['Data']['LastAmount'] }}<br>
                                    L: {{ $pump['Data']['LastVolume'] }}</p>
                            </div>
                            @endif
                            @elseif ($pump['Type']==='PumpOfflineStatus')
                            <h3 style="background-color: #FFCCCB" class="card-header"><a class="pump-number"> {{$pump['Id']}} </a> <a class="card-header-title p-0">OFFLINE</a></h3>
                            <center><img src="img/offline.png"></center>
                            @elseif ($pump['Type']==='PumpFillingStatus')
                            <h3 style="background-color: lightblue" class="card-header"><a class="pump-number"> {{$pump['Id']}} </a> <a class="card-header-title p-0" style="color: red">FILLING</a></h3>
                            <center><img src="img/refilling-bar.gif" class="img-icon" style="margin-left:25px;opacity:1"> </center>
                            <div class="pump-thumb-details">
                                <p>A: {{ $pump['Data']['Amount'] }}<br>
                                    L: {{ $pump['Data']['Volume'] }}</p>
                            </div>

                            @elseif ($pump['Type']==='PumpEndOfTransactionStatus')
                            <h3 style="background-color:lightgreen" class="card-header"><a class="pump-number"> {{$pump['Id']}} </a><a class="card-header-title p-0">DONE</a></h3>
                            <center><img src="img/done-filling.gif"></center>
                            @else
                            <h1>you have no pumps</h1>
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
                                <input readonly type="text" id="price" name="eotprice" value="{{$pump['Data']['Price']}}" />
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
                                <input readonly type="text" id="volume" name="eotvolume" value="{{$pump['Data']['Volume']}}" />
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
                                <input readonly type="text" id="amount" name="eotamount" value="{{$pump['Data']['Amount']}}" />
                                @endif
                            </div>
                            <input type="hidden" name="pumpid" value="{{$pump['Id']}}">
                            <div class="btn-group">
                                <button type="button" class="start-button" style="background-color: #00cc00; color: #fff;" onclick="authorize({{$pump['Id']}})">
                                    Authorize
                                </button>
                                <button type="button" class="stop-button " style="background-color: #ff0000; color: #fff;" onclick="stop({{$pump['Id']}})">
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
                                        <td>{{ $transaction->volume }}</td>
                                        <td>{{ $transaction->amount }}</td>
                                        <td>
                                            <button class="btn btn-light pay-button" onclick="payTransaction({{ $transaction->id }})">
                                                <img src="img/payment.png" alt="Pay Now">
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5">No pending transactions for this pump.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="button" class="pt-button" style="background-color: #007bff; color: #fff" onclick="showTable({{ $pump['Id'] }})">
                        Pending Transaction
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        {{-- Mode of payment --}}
        <div id="mop-div" class="mop-column">
            @foreach($mopData as $mop)
            <button type="button" id="mop-btn" style="min-width:190px" onclick="addmop({{$mop['id']}},{{$mop['keyNum']}})">{{$mop['name']}}</button>
            @endforeach
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
    <script>
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
            const mySwal = Swal.fire({
                title: 'Pump ' + id,
                html: details,
                scrollbarPadding: false,
                showCloseButton: true,
                showConfirmButton: false
            });

            setInterval(function() {
                var newDetails = document.getElementById("pump-details-" + Id).innerHTML;
                mySwal.update({
                    html: newDetails
                });
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
        }

        function stop(Id) {
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
                    document.getElementById(Id).setAttribute('action', '/stoppump');
                    document.getElementById(Id).submit();
                    Swal.fire({
                        title: 'Pump Stopped',
                        icon: 'success',
                        scrollbarPadding: false
                    });
                } else {
                    Swal.fire({
                        title: 'Pump Continues',
                        icon: 'info',
                        scrollbarPadding: false
                    });
                    console.log('Pump continues');
                }
            });
        }
        const myinterval = setInterval(refresh, 500);

        function refresh() {
            $('#pump-div').load(document.URL + " #pump-div");
        }
        var pumpdiv = document.getElementById("pump-div");
        var mopdiv = document.getElementById("mop-div");
        var reportsdiv = document.getElementById("reports-column");
        var nonfueldiv = document.getElementById("nonfuel-column");
        var manualdiv = document.getElementById("manual-column");
        var configdiv = document.getElementById("config-column");

        function mop() {
            reportsdiv.style.display = "none";
            pumpdiv.style.display = "none";
            nonfueldiv.style.display = "none";
            manualdiv.style.display = "none"
            configdiv.style.display = "none";
            mopdiv.setAttribute('style', 'display:block');
            console.log('mop clicked!');
            document.getElementById("mop-nav").setAttribute('class', 'is-active');
            document.getElementById("pump-nav").setAttribute('class', '');
            document.getElementById("config-nav").setAttribute('class', '');
            document.getElementById("reports-nav").setAttribute('class', '');
            document.getElementById("nf-nav").setAttribute('class', '');
            document.getElementById("manual-nav").setAttribute('class', '');
        }

        function reports() {
            console.log("reports");
            pumpdiv.style.display = "none";
            mopdiv.style.display = "none";
            nonfueldiv.style.display = "none";
            manualdiv.style.display = "none"
            reportsdiv.style.display = "block";
            configdiv.style.display = "none";
            document.getElementById("mop-nav").setAttribute('class', '');
            document.getElementById("pump-nav").setAttribute('class', '');
            document.getElementById("config-nav").setAttribute('class', '');
            document.getElementById("reports-nav").setAttribute('class', 'is-active');
            document.getElementById("nf-nav").setAttribute('class', '');
            document.getElementById("manual-nav").setAttribute('class', '');
        }

        function nonfuel() {
            console.log("nonfuel");
            pumpdiv.style.display = "none";
            mopdiv.style.display = "none";
            reportsdiv.style.display = "none";
            manualdiv.style.display = "none"
            nonfueldiv.style.display = "block";
            configdiv.style.display = "none";
            document.getElementById("mop-nav").setAttribute('class', '');
            document.getElementById("pump-nav").setAttribute('class', '');
            document.getElementById("config-nav").setAttribute('class', '');
            document.getElementById("reports-nav").setAttribute('class', '');
            document.getElementById("nf-nav").setAttribute('class', 'is-active');
            document.getElementById("manual-nav").setAttribute('class', '');
        }

        function pumps() {
            console.log("pumps")
            mopdiv.style.display = "none";
            reportsdiv.style.display = "none";
            nonfueldiv.style.display = "none";
            manualdiv.style.display = "none";
            configdiv.style.display = "none";
            pumpdiv.setAttribute('style', 'display:block');
            document.getElementById("mop-nav").setAttribute('class', '');
            document.getElementById("pump-nav").setAttribute('class', 'is-active');
            document.getElementById("config-nav").setAttribute('class', '');
            document.getElementById("reports-nav").setAttribute('class', '');
            document.getElementById("nf-nav").setAttribute('class', '');
            document.getElementById("manual-nav").setAttribute('class', '');
        }

        function manual() {
            mopdiv.style.display = "none";
            reportsdiv.style.display = "none";
            nonfueldiv.style.display = "none";
            pumpdiv.style.display = "none";
            manualdiv.style.display = "block";
            configdiv.style.display = "none";
            console.log("manual");
            document.getElementById("mop-nav").setAttribute('class', '');
            document.getElementById("pump-nav").setAttribute('class', '');
            document.getElementById("config-nav").setAttribute('class', '');
            document.getElementById("reports-nav").setAttribute('class', '');
            document.getElementById("nf-nav").setAttribute('class', '');
            document.getElementById("manual-nav").setAttribute('class', 'is-active');
        }

        function config() {
            console.log("config");
            mopdiv.style.display = "none";
            reportsdiv.style.display = "none";
            nonfueldiv.style.display = "none";
            pumpdiv.style.display = "none";
            manualdiv.style.display = "none";
            configdiv.style.display = "block";
            document.getElementById("mop-nav").setAttribute('class', '');
            document.getElementById("pump-nav").setAttribute('class', '');
            document.getElementById("config-nav").setAttribute('class', 'is-active');
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
        function initializeItemDisplayContainer() {
            var transactions = getTransactionsFromLocalStorage();
            transactions.forEach(function(transaction) {
                appendTransactionToDisplay(transaction);
            });
        }

        // Call the initialization function when the page loads
        $(document).ready(function() {
            initializeItemDisplayContainer();
        });

        // Function to append a transaction to the item display container
        function appendTransactionToDisplay(transaction) {
            var tableBody = document.querySelector('.item-table tbody');
            var newRow = tableBody.insertRow(0);

            // Create table cells for each column
            var pumpCell = newRow.insertCell(0);
            var nozzleCell = newRow.insertCell(1);
            var priceCell = newRow.insertCell(2);
            var volumeCell = newRow.insertCell(3);
            var amountCell = newRow.insertCell(4);
            var stateCell = newRow.insertCell(5);

            // Fill the table cells with data
            pumpCell.textContent = transaction.pump;
            nozzleCell.textContent = transaction.nozzle;
            priceCell.textContent = transaction.price;
            volumeCell.textContent = transaction.volume;
            amountCell.textContent = transaction.amount;
            stateCell.textContent = transaction.state;
        }

        // Function to add a transaction to local storage and the item display container
        function addTransactionToLocalStorageAndDisplay(transaction) {
            var transactions = getTransactionsFromLocalStorage();
            transactions.push(transaction);
            saveTransactionsToLocalStorage(transactions);
            appendTransactionToDisplay(transaction);
        }

        // Function to clear transactions from local storage and the item display container
        function clearTransactions() {
            // Clear transactions from local storage
            localStorage.removeItem('transactions');

            // Clear transactions from the item display container
            var tableBody = document.querySelector('.item-table tbody');
            tableBody.innerHTML = '';
        }

        // Attach a click event handler to the "Clear" button
        document.getElementById('clearButton').addEventListener('click', function() {
            clearTransactions();
        });

        function addmop() {

            // alert(id);
            // console.log(name);
        }
    </script>
    <!-- Pay Now -->
    <script>
        function payTransaction(transactionId) {
            // Send an AJAX request to fetch transaction details
            $.ajax({
                url: '/payTransaction',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'transactionId': transactionId
                },
                success: function(data) {
                    // Add the transaction to local storage and the item display container
                    addTransactionToLocalStorageAndDisplay(data);
                },
                error: function() {
                    alert('Failed to fetch transaction details.');
                }
            });
        }
    </script>
    <script>
        // Get the last appended transaction
        var tableBody = document.querySelector('.item-table tbody');
        var lastRow = tableBody.lastChild;
        var transaction = {
            pump: lastRow.cells[0].textContent,
            nozzle: lastRow.cells[1].textContent,
            price: parseFloat(lastRow.cells[2].textContent),
            volume: parseFloat(lastRow.cells[3].textContent),
            amount: parseFloat(lastRow.cells[4].textContent),
        };
    </script>
    <script>
        // Get the display element
        const display = document.getElementById('display');

        // Function to append the clicked number to the display
        function appendToDisplay(number) {
            display.value += number;
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
        const clearButton = document.querySelector('.clear-button');
        clearButton.addEventListener('click', clearDisplay);
    </script>
</x-app-layout>
