<x-app-layout>
    <style>
        @media screen and (min-width: 768px) and (max-width: 1024px) {
            .calculator-button{
                height: 80px;
                width: 70px;
            }
            .btn{
                height: 80px;
                width: 70px;
            }
            #items-info {
  max-height: 200px;
  overflow-y: auto;
}

}
@media (min-width: 768px) {
            .calculator-button{
                height: 80px;
                width: 70px;
            }
            .btn{
                height: 80px;
                width: 70px;
            }
            #items-info {
  max-height: 200px;
  overflow-y: auto;
}

}
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .pos-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .column {
            flex: 1;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
        }

        .left-column {
            margin-right: 20px;
        }

        .item-display-container,
        .calculator-container {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .calculator-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .calculator-buttons {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-gap: 0;
        }

        .calculator-button {
            padding: 15px;
            font-size: 12px;
            text-align: center;
            background-color: #ccc;
            border: 1px solid black;
            border-radius: 5px;
            cursor: pointer;
        }

        .calculator-button:hover {
            background-color: #ddd;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .my-button {
            padding: 10px 20px;
            font-size: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn{
            border: 1px solid black;
        }


        .my-button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
        }

        th {
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        input {
            width: 100%;
            height: 36px;
            border-radius: 4px;
            padding-left: 8px;
            font-size: 14px;
            font-weight: normal;
            border: 1px solid rgb(137, 151, 155);
            transition: border-color 150ms ease-in-out 0s;
            outline: none;
            color: rgb(33, 49, 60);
            background-color: rgb(255, 255, 255);
            padding-right: -30px;
            text-align: right;
        }

        input:hover {
            box-shadow: rgb(231, 238, 236) 0px 0px 0px 3px;
        }
        #items-info {
  max-height: 10px;
  overflow-y: auto;
}
    .items{
        max-height: 10px;
    overflow-y: auto;
    }
    .mop-column{
        display: none;
        flex: 1;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
    }
    </style>

    <div class="pos-container">
        <div class="column left-column">
            <div class="item-display-container">
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="items-info" class="items">
                        </tbody>
                </table>
            </div>
            <div class="calculator-container">
                <div class="calculator">
                    <div class="calculator-display-top">
                        <input type="text" id="calculator-display" placeholder="0" readonly>
                    </div>
                    <div class="calculator-buttons text-dark">
                        <button class="btn btn-warning " onclick="appendToDisplay('7')">7</button>
                        <button class="btn btn-warning" onclick="appendToDisplay('8')">8</button>
                        <button class="btn btn-warning" onclick="appendToDisplay('9')">9</button>
                        <button class="btn btn-danger text-dark" onclick="clearDisplay()">Clear</button>
                        <button class="btn btn-success text-dark">void</button>
                        <button class="btn btn-danger text-dark">preset</button>
                        <button class="btn btn-warning" onclick="appendToDisplay('4')">4</button>
                        <button class="btn btn-warning" onclick="appendToDisplay('5')">5</button>
                        <button class="btn btn-warning" onclick="appendToDisplay('6')">6</button>
                        <button class="calculator-button" style="background-color:darkgray;color:black">Open Drawer</button>
                        <button class="calculator-button text-dark">Sub ttl</button>
                        <button class="btn btn-success text-dark">Void All</button>
                        <button class="btn btn-warning" onclick="appendToDisplay('1')">1</button>
                        <button class="btn btn-warning" onclick="appendToDisplay('2')">2</button>
                        <button class="btn btn-warning" onclick="appendToDisplay('3')">3</button>
                        <button class="calculator-button" style="background-color:darkgray">Print Receipt</button>
                        <button class="calculator-button">User</button>
                        <button class="calculator-button" style="background-color: darkgreen;color:black">Puregold Disc</button>
                        <button class="btn btn-warning" onclick="appendToDisplay('0')">0</button>
                        <button class="btn btn-warning" onclick="appendToDisplay('00')">00</button>
                        <button class="btn btn-warning" onclick="appendToDisplay('.')">.</button>
                        <button class="btn btn-info">Safe Drop</button>
                        <button class="calculator-button">All Stop</button>
                        <button class="calculator-button">All Auth</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- PUMPS --}}
        <div class="column right-column" id="pumps-column">
            <h2>Pumps Display</h2>
            <div id="pumps-info">
                <div class="pump-item" id="pump-item-1" onclick="addItemToDisplay('Item 1', 10.00)">Item 1 - $10.00</div>
                <div class="pump-item" id="pump-item-2" onclick="addItemToDisplay('Item 2', 15.00)">Item 2 - $15.00</div>
                <!-- Add more pump items as needed -->
            </div>

        </div>
        {{-- MOP --}}
         <div class="mop-column" id="mop-column">
            <h2>Mode of Payment</h2>
            <div id="pumps-info">
                <button class="btn btn-light " onclick="appendToDisplay('7')">GCASH</button>
                <button class="btn btn-light" onclick="appendToDisplay('8')">BDO</button>
                <button class="btn btn-light" onclick="appendToDisplay('9')">BPI</button>
                <button class="btn btn-light text-dark" onclick="clearDisplay()">PAY<br>MAYA</button>

            </div>
        </div>
        {{-- REPORTS --}}
        <div class="mop-column" id="reports-column">
            <h2>Reports</h2>
            <div id="pumps-info">
                <button class="btn btn-light " onclick="appendToDisplay('7')">Close Cashdraw</button>
                <button class="btn btn-light" onclick="appendToDisplay('8')">Print Cashdraw</button>
                <button class="btn btn-light" onclick="appendToDisplay('9')">Att print shift</button>
                <button class="btn btn-light text-dark" onclick="clearDisplay()">Close shift</button>
                <button class="btn btn-light " onclick="appendToDisplay('7')">Print shift</button>
                <button class="btn btn-light" onclick="appendToDisplay('8')">Commulative shift </button>


            </div>
        </div>
        {{-- NON-FUEL --}}
        <div class="mop-column" id="nonfuel-column">
            <h2>None-Fuel</h2>
            <div id="pumps-info">
                <button class="btn btn-light " onclick="appendToDisplay('7')">LOREM IPSUM</button>
                <button class="btn btn-light" onclick="appendToDisplay('8')">LOREM IPSUM</button>
                <button class="btn btn-light" onclick="appendToDisplay('9')">LOREM IPSUM</button>
                <button class="btn btn-light text-dark" onclick="clearDisplay()">LOREM IPSUM</button>
                <button class="btn btn-light " onclick="appendToDisplay('7')">LOREM IPSUM</button>
                <button class="btn btn-light" onclick="appendToDisplay('8')">LOREM IPSUM </button>


            </div>
        </div>
        {{-- MANUAL --}}
        <div class="mop-column" id="manual-column">
            <h2>Manual</h2>
            <div id="pumps-info">
               <h1>Under Development</h1>

            </div>
        </div>
    </div>
    <div class="button-container">
        <button class="my-button" onclick="pumps()">Pumps</button>
        <button class="my-button" onclick="manual()" >Manual</button>
        <button class="my-button" onclick="mop()">MOP</button>
        <button class="my-button"  onclick="nonfuel()">Non-Fuel</button>
        <button class="my-button" onclick="reports()">Reports</button>
        <button class="my-button">Config</button>
    </div>


    <script>
var pumpdiv = document.getElementById("pumps-column");
var mopdiv = document.getElementById("mop-column");
var reportsdiv = document.getElementById("reports-column");
var nonfueldiv = document.getElementById("nonfuel-column");
var manualdiv = document.getElementById("manual-column")
        function mop(){
 reportsdiv.style.display = "none";
  pumpdiv.style.display = "none";
  nonfueldiv.style.display = "none";
  manualdiv.style.display = "none"
  mopdiv.style.display = "block";
    }
    function reports(){
        pumpdiv.style.display = "none";
        mopdiv.style.display = "none";
        nonfueldiv.style.display = "none";
        manualdiv.style.display = "none"
        reportsdiv.style.display = "block";

    }
    function nonfuel(){
        pumpdiv.style.display = "none";
        mopdiv.style.display = "none";
        reportsdiv.style.display = "none";
        manualdiv.style.display = "none"
        nonfueldiv.style.display = "block";
    }
    function pumps(){

        mopdiv.style.display = "none";
        reportsdiv.style.display = "none";
        nonfueldiv.style.display = "none";
        manualdiv.style.display = "none"
        pumpdiv.style.display = "block";
    }
    function manual(){
        mopdiv.style.display = "none";
        reportsdiv.style.display = "none";
        nonfueldiv.style.display = "none";
        pumpdiv.style.display = "none";
        manualdiv.style.display = "block"

    }

        document.addEventListener('DOMContentLoaded', function () {
            clearDisplay();
        });

        function appendToDisplay(value) {
            const display = document.getElementById('calculator-display');
            display.value += value;
        }

        function clearDisplay() {
            const display = document.getElementById('calculator-display');
            display.value = '';
        }

        function addItemToDisplay(itemName, itemPrice) {
            const itemsTableBody = document.getElementById('items-info');
            let existingRow = null;

            // Check if the item already exists in the table
            for (let i = 0; i < itemsTableBody.rows.length; i++) {
                if (itemsTableBody.rows[i].cells[0].textContent === itemName) {
                    existingRow = itemsTableBody.rows[i];
                    break;
                }
            }

            if (existingRow) {
                // If the item already exists, update quantity and total
                const itemQuantityCell = existingRow.cells[2];
                const itemTotalCell = existingRow.cells[3];

                let currentQuantity = parseInt(itemQuantityCell.textContent);
                currentQuantity++;
                itemQuantityCell.textContent = currentQuantity;

                let currentTotal = parseFloat(itemTotalCell.textContent);
                currentTotal += itemPrice;
                itemTotalCell.textContent = currentTotal.toFixed(2);
            } else {
                // If it's a new item, add a new row
                const newRow = itemsTableBody.insertRow();
                const itemNameCell = newRow.insertCell(0);
                const itemPriceCell = newRow.insertCell(1);
                const itemQuantityCell = newRow.insertCell(2);
                const itemTotalCell = newRow.insertCell(3);

                itemNameCell.textContent = itemName;
                itemPriceCell.textContent = itemPrice.toFixed(2);
                itemQuantityCell.textContent = '1';
                itemTotalCell.textContent = itemPrice.toFixed(2);
            }
        }
    </script>

</x-app-layout>
