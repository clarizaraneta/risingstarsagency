<style>

/* Styles for main container */
.main-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 400px; /* Adjust the height as needed */
        background-color: gray; /* Set the background color to gray */
    }
    
/* Styles for stopwatch, buttons, and message banner */
.stopwatch {
    position: absolute;
    top: 100px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 50px;
}

    .button1 {
        background-image: url('assets/Logo/Clock in.png');
        background-repeat: no-repeat;
        background-size: 100% 100%;
        width: 200px;
        height: 200px;
        border: none;
        position: absolute;
        top: 170px;
        left: 35%;
        transition: transform .2s; /* Animation */
    }

    .button1:hover {
        transform: scale(1.1); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }

    .button2 {
        background-image: url('assets/Logo/Clock out.png');
        background-repeat: no-repeat;
        background-size: 100% 100%;
        width: 200px;
        height: 200px;
        border: none;
        position: absolute;
        top: 170px;
        left: 52%;
        transition: transform .2s; /* Animation */
    }

    .button2:hover {
        transform: scale(1.1); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }

    .button3 {
        /* Styles for Show DTR button */
        padding: 10px 20px;
        font-size: 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        position: absolute;
        top: 470px; /* Adjust the vertical position as needed */
        left: 50%; /* Position at the center */
        transform: translateX(-50%);
    }

    .button3:hover {
        background-color: #45a049;
    }

    .message-banner {
        width: 100%;
        padding: 20px;
        background-color: #f8d7da;
        color: #721c24;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Styles for the modal */
    .modal {
        display: none; /* Hide the modal by default */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.8); /* Black background with transparency */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* Center the modal */
        padding: 20px;
        border: 1px solid #888;
        width: 60%;
        border-radius: 8px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>


<form method="post" action="">
    <button type="submit" class="button1" name="punch_in" aria-label="Clock In"></button>
    <button type="submit" class="button2" name="punch_out" aria-label="Punch Out"></button>
</form>

<div class="stopwatch">00:00:00:00</div>

<!-- <button onclick="showDTR()" class="button3">Show DTR</button> -->

<!-- Modal to display the user's login records -->
<div id="DTRModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>User's  Login Records</h2>
    <div id="DTRContent"></div>
  </div>
</div>

<?php
require 'header.php';
require_once('config.php');

// Check if emp_id exists in the session or fetch it from wherever it's set
if (!isset($_SESSION['emp_id'])) {
  // Redirect to login or set emp_id based on your authentication process
  header("Location: index.php");
  exit();
}

$emp_id = $_SESSION['emp_id'];


// Function to format time in HH:MM:SS format
function formatTime($milliseconds)
{
    $seconds = floor($milliseconds / 1000);
    $hours = floor($seconds / 3600);
    $seconds %= 3600;
    $minutes = floor($seconds / 60);
    $seconds %= 60;
    $milliseconds = floor($milliseconds % 1000);

    // Return formatted time
    return sprintf('%02d:%02d:%02d:%02d', $hours, $minutes, $seconds, $milliseconds);
}
?>

<script>
    // Variables to handle stopwatch functionality
    let startTime = 0;
    let timerInterval;
    let storedElapsedTime = 0;


    // Modified function to start the stopwatch
    function startStopwatch() {
        startTime = Date.now() - storedElapsedTime;
        localStorage.setItem('startTime', startTime); // Save start time in localStorage
        updateStopwatch();
        timerInterval = setInterval(updateStopwatch, 10); // Update every 10 milliseconds
    }


    // Combined function to stop the stopwatch and send data to the server
    function stopStopwatch() {
    clearInterval(timerInterval);  // Stop the stopwatch

    // Calculate elapsed time
    storedElapsedTime = Date.now() - startTime;

    // Reset the stopwatch display
    document.querySelector('.stopwatch').textContent = "00:00:00:00";

    // Remove the start time from localStorage
    localStorage.removeItem('startTime');

    // Fetch stopwatch time and send it to the server via POST request
    let stopwatchTime = storedElapsedTime; // Get stopwatch time in milliseconds

    // Create an object with data to send to the server
    let data = {
        stopwatch_time: stopwatchTime
    };

    // Send a POST request to the server
    fetch('insert.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.text())
    .then(data => {
        console.log('Success:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


    // Function to update the stopwatch display
    function updateStopwatch() {
        let currentTime = Date.now();
        let elapsedTime = currentTime - startTime;
        let formattedTime = formatTime(elapsedTime);
        document.querySelector('.stopwatch').textContent = formattedTime;
    }

    // Function to format time in HH:MM:SS:mm format
    function formatTime(milliseconds) {
        let seconds = Math.floor(milliseconds / 1000);
        let hours = Math.floor(seconds / 3600);
        seconds %= 3600;
        let minutes = Math.floor(seconds / 60);
        seconds %= 60;
        milliseconds = Math.floor(milliseconds % 1000);

        return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}:${String(milliseconds).padStart(3, '0').substring(0, 2)}`;
    }

 // Event listener for the "Punch In" button

    document.querySelector('.button1').addEventListener('click', function (event) {
    event.preventDefault();

    let emp_id = <?php echo json_encode(intval($emp_id)); ?>;

    fetch('check_punch.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'emp_id=' + emp_id,
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response: ', data); // Log the response to the console for debugging
        console.log(emp_id); 

      //  if (data.trim() == 'ALLOW') {
            // Employee can punch in for the day
            fetch('insert.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'emp_id=' + emp_id + '&punchType=1',
            })
            .then(response => response.text())
            .then(data => {
                console.log('Success:', data);
                startStopwatch(); // Start the stopwatch upon successful punch-in
            })
            .catch(error => {
                console.error('Error:', error);
            });
        // } else  { //if (data.trim() == 'DENY')
        //     // Employee already punched in for the day
        //     console.log('You have already punched in for the day.');
        //     window.alert('You have already punched in for the day.');
        // }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

    // Event listener for the "Punch Out" button
    document.querySelector('.button2').addEventListener('click', function (event) {
    event.preventDefault();

    // Assuming $emp_id is available in PHP context
    let emp_id = <?php echo json_encode(intval($emp_id)); ?>; // Cast emp_id as an integer

    // Check if the elapsed time is less than 8 hours (in milliseconds)
    let elapsedTime = storedElapsedTime || 0; // Get stored elapsed time or default to 0
    let eightHoursInMillis = 8 * 60 * 60 * 1000; // 8 hours in milliseconds

    if (elapsedTime > eightHoursInMillis) {
        // If elapsed time is less than 8 hours, proceed with punching out without confirmation
        punchOut(emp_id);
    } else {
        // If elapsed time is less 8 hours, prompt the user for confirmation
        if (confirm("You've worked for less than 8 hours. Are you sure you want to punch out?")) {
            punchOut(emp_id);
        }
        // If the user cancels, do nothing (don't punch out)
    }
});

function punchOut(emp_id) {
    // Send a POST request to the server with emp_id and '1' for 'Punch Out'
    fetch('update.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'emp_id=' + emp_id + '&punchType=1', // '1' signifies 'Punch Out'
    })
        .then(response => response.text())
        .then(data => {
            console.log('Success:', data);
            location.reload()
        })
        .catch(error => {
            console.error('Error:', error);
        });

    stopStopwatch();
    
}

// Function to show the modal
function showDTR() {    
  // Get emp_id from session or wherever it's stored
  let emp_id = <?php echo json_encode(intval($emp_id)); ?>;

  // Fetch user's login records
  fetch('get_login_records.php?emp_id=' + emp_id)
    .then(response => response.text())
    .then(data => {
      document.getElementById('DTRContent').innerHTML = data;
      document.getElementById('DTRModal').style.display = 'block';
    })
    .catch(error => {
      console.error('Error fetching login records:', error);
    });
}

// Function to close the modal
function closeModal() {
  document.getElementById('DTRModal').style.display = 'none';
}



// Function to resume stopwatch from previous state
function resumeStopwatch() {
    let savedStartTime = localStorage.getItem('startTime');
    if (savedStartTime) {
        startTime = parseInt(savedStartTime);
        storedElapsedTime = Date.now() - startTime;
        updateStopwatch();
        timerInterval = setInterval(updateStopwatch, 10);
    }
}

// Call this function when the page loads
document.addEventListener('DOMContentLoaded', (event) => {
    resumeStopwatch();
});



</script>






