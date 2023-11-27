<?php

header("Cache-Control: no-cache, must-revalidate");
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}elseif ($_SESSION["email"] == "admin@example.com") {
    header('Location: admin.php');
    exit;
}elseif ($_SESSION["otpOK"] == "nu") {
    header('Location: otp.php');
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>New Workout</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
    </head>
    <body>
        <div>
            <h1>ADD WORKOUT</h1>
            <div class="contents">
                <form action="submitExercises.php" method="POST">
                    <table>
                    
                        <div id="toBeAdded"></div>
                        <tr>
                             <select name="newExercise" id="mySelect"></select>  
                             <button type="button" id="addEx">add</button>  
                        </tr>
                        <tr>
                             <button type="submit">add to database</button>  
                        </tr>
                
                    </table>
                </form>
            </div> 
        </div>
        <script>

            function loadOptions() {
                fetch(`exerciselist.txt?nocache=${new Date().getTime()}`);
                fetch('exerciselist.txt')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();})
                    .then(text => {
                        const lines = text.split(/\r?\n/);
                        lines.forEach(line => {
                            if (line.trim().length > 0) { 
                                const option = document.createElement('option');
                                option.textContent = line;
                                document.getElementById('mySelect').appendChild(option);
                            }
                        });
                    })
                    .catch(error => console.error('Error loading options:', error));
            }

            document.addEventListener('DOMContentLoaded', loadOptions);

            let selectedValues = [];
            let select = document.getElementById('mySelect');

            document.getElementById('addEx').addEventListener('click', function() {
                let table = document.getElementById('toBeAdded');
                let tr = document.createElement('tr');
                
                // Create the first cell for exercise name
                let td1 = document.createElement('td');
                let span = document.createElement('span');
                span.textContent = select.options[select.selectedIndex].text;
                td1.appendChild(span);

                // Include a hidden input to send exercise name
                let hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'exercises[]';
                hiddenInput.value = select.options[select.selectedIndex].text;
                td1.appendChild(hiddenInput);

                // Create the second cell for input field
                let td2 = document.createElement('td');
                let input = document.createElement('input');
                input.type = 'text';
                input.name = 'values[]'; // Important: This allows you to receive this as an array in PHP
                input.placeholder = 'repsxweight;';
                td2.appendChild(input);

                // Append cells to the row
                tr.appendChild(td1);
                tr.appendChild(td2);

                // Append the row to the table
                table.appendChild(tr);
            });
        

        </script>
    </body>
</html>