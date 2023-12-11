<?php

session_start();

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
<table>
            <tr id = "title">
                <td colspan="5"><a href="home.php">SWOLKOUT</a></td>
            </tr>
            <tr id = "meniu">
            <td><a href="addweight.php">add weight</a></td>
                <td><a href="addworkout.php">add workout</a></td>
                <td><a href="history.php">workout history</a></td>
                <td><a href="set_reminders.php">set reminders</a></td>
                <td><a href="logout.php">log out</a></td>
            </tr>
            <tr id = "body">
                <td colspan="5">
                    <div id="continutWorkout">
                    <form action="submitExercises.php" method="POST">
                        <table id="exerciseTable">
                            <tbody id="toBeAdded">
                            </tbody>
                        </table>
                            <table>
                                <tr>
                                    <td>
                                        <select name="exercises[]" id="mySelect"></select>  
                                        <button type="button" id="addEx">add exercise</button>  
                                        <button type="button" id="remEX">remove exercise</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><button type="submit" onclick="alerta()">add to database</button></td>
                                </tr>
                            </table>
                        </table>
                    </form>
                    </div>
                </td>
            </tr>
        </table>
    <script>
        function loadOptions() {
            fetch(`exerciselist.txt?nocache=${new Date().getTime()}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(text => {
                    const select = document.getElementById('mySelect');
                    const lines = text.split(/\r?\n/);
                    lines.forEach(line => {
                        if (line.trim().length > 0) {
                            const option = document.createElement('option');
                            option.textContent = line;
                            select.appendChild(option);
                        }
                    });
                })
                .catch(error => console.error('Error loading options:', error));
        }

        document.addEventListener('DOMContentLoaded', loadOptions);

        document.getElementById('addEx').addEventListener('click', function () {
            const tbody = document.getElementById('toBeAdded');
            const select = document.getElementById('mySelect');
            const exerciseName = select.options[select.selectedIndex].text;

            const exerciseRow = document.createElement('tr');
            const exerciseNameCell = document.createElement('td');
            exerciseNameCell.textContent = exerciseName;
            const exerciseRow2 = document.createElement('tr');
            const exerciseCell2 = document.createElement('td');
            exerciseCell2.colSpan = '1';
            exerciseRow2.appendChild(exerciseCell2);

            const setCell = document.createElement('td');
            const addSetButton = document.createElement('button');
            addSetButton.textContent = 'add set';
            addSetButton.type = 'button';
            addSetButton.onclick = function () {
                addSet(exerciseRow2, exerciseName); 
            };

            const deleteSetButton = document.createElement('button');
            deleteSetButton.textContent = 'delete set';
            deleteSetButton.type = 'button';
            deleteSetButton.onclick = function () {
                deleteSet(exerciseRow2);
            };

            setCell.appendChild(addSetButton);
            setCell.appendChild(deleteSetButton);

            exerciseRow.appendChild(exerciseNameCell);
            exerciseRow.appendChild(setCell);

            tbody.appendChild(exerciseRow);
            tbody.appendChild(exerciseRow2);

            

        });

        document.getElementById('remEX').addEventListener('click', function () {
            removeLastExercise();
        });

        function removeLastExercise() {
            const tbody = document.getElementById('toBeAdded');
            if (tbody.lastElementChild) {
                tbody.removeChild(tbody.lastElementChild);
            }
        }


function addSet(exerciseRow, exerciseName) { 
    const setRow = document.createElement('tr');
    setRow.classList.add('generated-element');
    const setNumberCell = document.createElement('td');
    const inputCell = document.createElement('td');

    const setNumber = exerciseRow.querySelectorAll('.set-row').length + 1;
    setNumberCell.textContent = 'set ' + setNumber;

    const repsInput = document.createElement('input');
    repsInput.type = 'text';
    repsInput.name = 'exercises[' + exerciseName + '][reps][]';
    repsInput.placeholder = 'repetitions';

    const weightInput = document.createElement('input');
    weightInput.type = 'text';
    weightInput.name = 'exercises[' + exerciseName + '][weight][]';
    weightInput.placeholder = 'weight';

    inputCell.appendChild(repsInput);
    inputCell.appendChild(weightInput);

    setRow.classList.add('set-row');

    setRow.appendChild(setNumberCell);
    setRow.appendChild(inputCell);
    
    exerciseRow.parentNode.insertBefore(setRow, exerciseRow.nextSibling);
    setRow.classList.add('set-row');
    exerciseRow.appendChild(setRow);
    
}


        function deleteSet(exerciseRow) {
        const lastSetRow = exerciseRow.querySelector('.set-row:last-child');
        if (lastSetRow) {
            lastSetRow.remove();
        }
    }

    document.getElementById('toBeAdded').addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('delete-set-button')) {
            const exerciseRow = event.target.closest('.exercise-row');
            if (exerciseRow) {
                deleteSet(exerciseRow); 
            }
        }
    });


    function alerta() {
            alert("workout saved successfully");
        }
    </script>
</body>
</html>
