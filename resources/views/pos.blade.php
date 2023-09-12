<x-app-layout>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <style>
            .pos-container {
                display: flex;
                justify-content: space-between;
                padding: 10px;
                flex-wrap: wrap;
            }

            /* Styles for left column (Item Display and Calculator) */
            .left-column {
                flex: 1;
                background-color: #ffffff;
                border: 1px solid #ccc;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                min-width: 300px;
                display: flex;
                flex-direction: column;
                margin-right: 5px;
            }

            /* Styles for right column (Fuel Pumps) */
            .right-column {
                flex: 1;
                background-color: #ffffff;
                border: 1px solid #ccc;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                min-width: 300px;
                margin-left: 5px;
            }

            /* Styles for the item display container */
            .item-display-container {
                flex-grow: 1;
                overflow-y: auto;
                max-height: 300px;
            }

            h1 {
                color: #007bff;
                margin-bottom: 20px;
            }

            /* Styles for the item display table */
            .item-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            .table-container {
                margin-top: 20px;
            }

            .item-table th,
            .item-table td {
                border: 1px solid #ccc;
                padding: 10px;
                text-align: center;
            }

            .item-table th {
                background-color: #007bff;
                color: #fff;
            }

            .item-table tbody tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            /* Style the quantity input field */
            .item-table input[type="number"] {
                width: 50px;
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
                text-align: center;
            }

            /* Styles for Calculator */
            .calculator-display {
                width: 100%;
                height: 40px;
                font-size: 24px;
                text-align: right;
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 10px 15px;
                background-color: #f9f9f9;
                outline: none;
            }

            .calculator-container {
                background-color: #ffffff;
                border: 1px solid #ccc;
                border-radius: 10px;
                padding: 20px;
                margin-top: auto;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .calculator-buttons {
                display: grid;
                grid-template-columns: repeat(6, 1fr);
                gap: 5px;
            }

            .calcbutton {
                padding: 10px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .calcbutton:hover {
                background-color: #0056b3;
            }

            .calcbutton.clear-button,
            .calcbutton.special-button {
                background-color: #ccc;
                color: #333;
            }

            /* Styles for the container of pump items */
            .pump-items-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                overflow-y: auto;
                max-height: 600px;
            }

            /* Styles for Fuel Pumps Item */
            .pump-item {
                background-color: #ffffff;
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 5px;
                margin: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                box-sizing: border-box;
                max-width: 170px;
            }

            /* Styles for labels inside the pump-item */
            .pump-item h3 {
                font-size: 18px;
            }

            .label-input-group {
                display: flex;
                align-items: center;
                margin: 5px 0;
            }

            .label-input-group label {
                flex: 0 0 auto;
                width: 80px;
                text-align: right;
                margin-right: 10px;
                font-size: 14px;
            }

            .label-input-group .input-container {
                flex: 1;
            }

            .label-input-group input[type="text"] {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 14px;
            }

            .button-group {
                margin-top: 10px;
                text-align: right;
            }

            .start-button,
            .stop-button {
                padding: 5px 10px;
                margin: 0 5px;
                font-size: 14px;
                border-radius: 3px;
            }

            .pt-button {
                padding: 5px 10px;
                margin: 0 5px;
                font-size: 14px;
                border-radius: 3px;
                margin-top: 10px;
            }

            .start-button:hover,
            .stop-button:hover {
                background-color: #0056b3;
            }

            .pos-buttons {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 20px;
            }

            .pos-buttons button {
                padding: 10px 15px;
                font-size: 15px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                margin-right: 10px;
                margin-top: -20px;
            }

            .pos-buttons button:last-child {
                margin-right: 0;
            }

            .pos-buttons button:hover {
                background-color: #0056b3;
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
            }

            .modal-content {
                background-color: #fff;
                margin: 10% auto;
                padding: 20px;
                border-radius: 5px;
                width: 60%;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                position: relative;
            }

            /* Style the close button for the modal */
            .close {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 20px;
                cursor: pointer;
            }
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
                                    <td>$10.00</td>
                                    <td>2</td>
                                    <td>$20.00</td>
                                </tr>
                                <tr>
                                    <td>Product 1</td>
                                    <td>$10.00</td>
                                    <td>2</td>
                                    <td>$20.00</td>
                                </tr>
                                <tr>
                                    <td>Product 1</td>
                                    <td>$10.00</td>
                                    <td>2</td>
                                    <td>$20.00</td>
                                </tr>
                                <tr>
                                    <td>Product 1</td>
                                    <td>$10.00</td>
                                    <td>2</td>
                                    <td>$20.00</td>
                                </tr>
                                <tr>
                                    <td>Product 1</td>
                                    <td>$10.00</td>
                                    <td>2</td>
                                    <td>$20.00</td>
                                </tr>
                                <tr>
                                    <td>Product 1</td>
                                    <td>$10.00</td>
                                    <td>2</td>
                                    <td>$20.00</td>
                                </tr>
                                <tr>
                                    <td>Product 1</td>
                                    <td>$10.00</td>
                                    <td>2</td>
                                    <td>$20.00</td>
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
                        <button class="calcbutton clear-button" onclick="clearDisplay()">Clear</button>
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
                <h1>Fuel Pumps</h1>
                <div class="pump-items-container" id="pump-column">
                    @foreach ($datab as $pump )

                    <div class="pump-item text-dark">
                        <form action="/authorizepump">
                            @if ($pump['Type']==='PumpIdleStatus')

                            @if ($pump['Data']['NozzleUp'] > 0)
                            @if ($pump['Data']['NozzleUp'] === 1)
                            <h3 style="background-color: lightgreen"> {{$pump['Id']}} <a>NOZZLE <a style="font-size:14px;color:red">(Premium)</a> </a></h3>
                            @elseif ($pump['Data']['NozzleUp'] === 2)
                            <h3 style="background-color: lightgreen"> {{$pump['Id']}} <a>NOZZLE <a style="font-size:14px;color:red">(Diesel)</a> </a></h3>
                            @elseif ($pump['Data']['NozzleUp'] === 3)
                            <h3 style="background-color: lightgreen"> {{$pump['Id']}} <a>NOZZLE <a style="font-size:14px;color:red">(Regular)</a> </a></h3>
                            @else
                            <h3 style="background-color: lightgreen"> {{$pump['Id']}} <a>NOZZLE </a></h3>
                            @endif

                            @else
                            <h3 style="background-color:#FFD580"> {{$pump['Id']}} <a>IDLE</a></h3>
                            @endif
                            @elseif ($pump['Type']==='PumpOfflineStatus')
                            <h3 style="background-color: #FFCCCB"> {{$pump['Id']}} <a>OFFLINE</a></h3>
                            @elseif ($pump['Type']==='PumpFillingStatus')
                            <h3 style="background-color: lightblue"> {{$pump['Id']}} <a>Filling</a></h3>
                            @endif

                            <div class="label-input-group">
                                <input type="hidden" name="pumpid" value="{{$pump['Id']}}">
                                <label for="price">Price:</label>
                                @if ($pump['Type']==='PumpIdleStatus')
                                <input readonly type="text" id="price" name="price" value="{{$pump['Data']['LastPrice']}}" />
                                @elseif ($pump['Type']==='PumpOfflineStatus')
                                <input readonly type="text" id="price" name="price" value="0" />
                                @elseif ($pump['Type']==='PumpFillingStatus')
                                <input readonly type="text" id="price" name="price" value="{{$pump['Data']['Price']}}" />
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
                                @endif
                            </div>
                            <div class="button-group">
                                <button type="submit" class="start-button" style="background-color: #00cc00; color: #fff">
                                    Authorize
                                </button>
                                <button class="stop-button" style="background-color: #ff0000; color: #fff">
                                    Stop
                                </button>
                        </form>
                    </div>
                    <button class="pt-button" style="background-color: #007bff; color: #fff" onclick="openPendingTransactionModal()">
                        Pending Transaction
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        </div>

        <!-- MODAL -->
        <div id="pending-transaction-modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closePendingTransactionModal()">&times;</span>
                <h2>Pending Transaction Details</h2>
                <div class="table-container">
                    <div class="item-display-container">
                        <table class="item-table">
                            <thead>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="pos-buttons">
            <button>Pumps</button>
            <button>Manual</button>
            <button>MoP</button>
            <button>Non-Fuel</button>
            <button>Reports</button>
            <button>Config</button>
        </div>

        <script>
            const myinterval = setInterval(refresh, 500);

            function refresh() {
                $('#pump-column').load(document.URL + " #pump-column");
            }
            var pumpdiv = document.getElementById("pumps-column");
            var mopdiv = document.getElementById("mop-column");
            var reportsdiv = document.getElementById("reports-column");
            var nonfueldiv = document.getElementById("nonfuel-column");
            var manualdiv = document.getElementById("manual-column")

            function mop() {
                reportsdiv.style.display = "none";
                pumpdiv.style.display = "none";
                nonfueldiv.style.display = "none";
                manualdiv.style.display = "none"
                mopdiv.style.display = "block";
            }

            function reports() {
                pumpdiv.style.display = "none";
                mopdiv.style.display = "none";
                nonfueldiv.style.display = "none";
                manualdiv.style.display = "none"
                reportsdiv.style.display = "block";
            }

            function nonfuel() {
                pumpdiv.style.display = "none";
                mopdiv.style.display = "none";
                reportsdiv.style.display = "none";
                manualdiv.style.display = "none"
                nonfueldiv.style.display = "block";
            }

            function pumps() {
                mopdiv.style.display = "none";
                reportsdiv.style.display = "none";
                nonfueldiv.style.display = "none";
                manualdiv.style.display = "none"
                pumpdiv.style.display = "block";
            }

            function manual() {
                mopdiv.style.display = "none";
                reportsdiv.style.display = "none";
                nonfueldiv.style.display = "none";
                pumpdiv.style.display = "none";
                manualdiv.style.display = "block"
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