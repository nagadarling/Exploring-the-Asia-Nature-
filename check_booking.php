<?php
$host = 'localhost';
$db = 'travel'; 
$user = 'root'; 
$pass = ''; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT persons, days, places FROM bookings WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f8f9fa;
                color: #333;
                margin: 0;
                padding: 20px;
            }
            .container {
                max-width: 800px;
                margin: auto;
                padding: 20px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
            h2 {
                color: #007bff;
                margin-bottom: 20px;
            }
            .card {
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                margin-bottom: 20px;
                transition: transform 0.2s;
            }
            .card:hover {
                transform: scale(1.02);
            }
            .card-body {
                padding: 15px;
            }
            .card-title {
                font-size: 1.25rem;
                margin-bottom: 10px;
            }
            .card-text {
                margin-bottom: 10px;
            }
            .btn {
                background-color: #007bff;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                text-decoration: none;
                transition: background-color 0.3s;
            }
            .btn:hover {
                background-color: #0056b3;
            }
          </style>';

    echo '<div class="container mt-5">';
    if ($result->num_rows > 0) {
        echo '<h2>Booking Details</h2>';
        echo '<div class="row">';

        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Booking for ' . htmlspecialchars($row['places']) . '</h5>';
            echo '<p class="card-text">Number of Persons: ' . htmlspecialchars($row['persons']) . '</p>';
            echo '<p class="card-text">Number of Days: ' . htmlspecialchars($row['days']) . '</p>';
            echo '</div></div></div>';
        }

        echo '</div>'; 

        echo '<a href="dashbord.html" class="btn mt-4">Go to Your Dashboard</a>'; 
    } else {
        echo '<h3>No bookings found for this email.</h3>';
        echo '<a href="dashbord.html" class="btn mt-4">Go to Your Dashboard</a>'; 
    }

    echo '</div>'; 

    $stmt->close();
}

$conn->close();
?>