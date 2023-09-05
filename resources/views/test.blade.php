<x-app-layout>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .pos-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
            padding: 20px;
        }

        .left-column,
        .right-column {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
        }

        .left-column {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .item-display h2,
        .pumps-display h2 {
            margin-bottom: 10px;
        }

        .calculator {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
        }

        .calculator-display-top {
            width: 100%;
            padding: 10px;
            font-size: 24px;
            text-align: right;
            margin-bottom: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: blue;
        }

        .calculator-buttons {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-gap: 0;
        }

        .calculator-button {
            padding: 15px;
            font-size: 10px;
            text-align: center;
            background-color: #ccc;
            border: 1px solid #999;
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
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .my-button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Media query for screens with a maximum width of 768px (adjust as needed) */
        @media (max-width: 768px) {
            .pos-container {
                grid-template-columns: 1fr;
                /* Single column layout for mobile view */
            }

            .left-column {
                display: none;
                /* Hide the left column */
            }

            .right-column {
                display: block;
                /* Display the right column */
            }

            /* Show the toggle button when screen is small */
            #toggle-button {
                display: block;
            }
        }

        /* Hide the toggle button by default for larger screens */
        #toggle-button {
            display: none;
        }
    </style>

    <div class="pos-container">
        <div class="left-column">
            <div class="item-display">
                <table>
                    <thead>
                        <tr>
                            <th>Items</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="items-info">
                        <!-- Display item information dynamically here using JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="calculator">
                <div class="calculator-display-top">
                    <input type="text" id="calculator-display" class="calculator-display" readonly>
                </div>
                <div class="calculator-buttons">
                    <button class="calculator-button" onclick="appendToDisplay('7')">7</button>
                    <button class="calculator-button" onclick="appendToDisplay('8')">8</button>
                    <button class="calculator-button" onclick="appendToDisplay('9')">9</button>
                    <button class="calculator-button" onclick="clearDisplay()">Clear</button>
                    <button class="calculator-button">void</button>
                    <button class="calculator-button">preset</button>
                    <button class="calculator-button" onclick="appendToDisplay('4')">4</button>
                    <button class="calculator-button" onclick="appendToDisplay('5')">5</button>
                    <button class="calculator-button" onclick="appendToDisplay('6')">6</button>
                    <button class="calculator-button">Open Drawer</button>
                    <button class="calculator-button">Sub ttl</button>
                    <button class="calculator-button">Void All</button>
                    <button class="calculator-button" onclick="appendToDisplay('1')">1</button>
                    <button class="calculator-button" onclick="appendToDisplay('2')">2</button>
                    <button class="calculator-button" onclick="appendToDisplay('3')">3</button>
                    <button class="calculator-button">Print Receipt</button>
                    <button class="calculator-button">User</button>
                    <button class="calculator-button">Puregold Disc</button>
                    <button class="calculator-button" onclick="appendToDisplay('0')">0</button>
                    <button class="calculator-button" onclick="appendToDisplay('00')">00</button>
                    <button class="calculator-button" onclick="appendToDisplay('.')">.</button>
                    <button class="calculator-button">Safe Drop</button>
                    <button class="calculator-button">All Stop</button>
                    <button class="calculator-button">All Auth</button>
                </div>
            </div>
        </div>
        <div class="right-column">
            <h2>Pumps Display</h2>
            <div id="pumps-info">
                <!-- Display pump information here -->
            </div>
        </div>
    </div>

    <div class="button-container">
        <button class="my-button">Pumps</button>
        <button class="my-button">Manual</button>
        <button class="my-button">MOP</button>
        <button class="my-button">Non-Fuel</button>
        <button class="my-button">Reports</button>
        <button class="my-button">Config</button>
    </div>

    <button id="toggle-button" class="my-button">Click here</button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

        const toggleButton = document.getElementById('toggle-button');
        const leftColumn = document.querySelector('.left-column');

        // Add a click event listener to the button
        toggleButton.addEventListener('click', function() {
            // Toggle the visibility of the left-column
            leftColumn.style.display = leftColumn.style.display === 'none' ? 'flex' : 'none';
        });
    </script>
</x-app-layout>