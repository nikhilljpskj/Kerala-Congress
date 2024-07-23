
<?php
session_start(); // Ensure session is started

if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("Location: dist_auth_log.html");
    exit;
}

require_once "connect.php";
require_once __DIR__ . '/vendor/autoload.php'; // Include Composer autoload file

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_no = $_POST['reg_no'];

    if (!empty($reg_no)) {
        // Query to check the status of the member
        $statusQuery = "SELECT status FROM members WHERE reg_no = ?";
        $stmt = $con->prepare($statusQuery);
        $stmt->bind_param("s", $reg_no);
        $stmt->execute();
        $statusResult = $stmt->get_result();

        if ($statusResult->num_rows > 0) {
            $statusRow = $statusResult->fetch_assoc();
            $status = $statusRow['status'];

            if ($status == 0) {
                // Status is 0, show the message
                $message = "The member registration is still pending for approval";
            } else if ($status == 1) {
                // Status is 1, proceed with fetching member details
                $detailsQuery = "SELECT * FROM members WHERE reg_no = ?";
                $stmt = $con->prepare($detailsQuery);
                $stmt->bind_param("s", $reg_no);
                $stmt->execute();
                $detailsResult = $stmt->get_result();

                if ($detailsResult->num_rows > 0) {
                    $member = $detailsResult->fetch_assoc();
                    $message = "ID card generated successfully!";
                    // You can also process member details here as needed
                } else {
                    $message = "No member found with registration number " . htmlspecialchars($reg_no);
                }
            } else {
                $message = "Invalid status for member.";
            }
        } else {
            $message = "No member found with registration number " . htmlspecialchars($reg_no);
        }
    } else {
        $message = "Please enter a registration number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Card</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            overflow: visible;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #3f4850;
            color: #fff;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #007bff;
            text-decoration: none;
        }
        .sidebar .sidebar-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            color: #343a40 !important;
        }
        .id-card {
            width: 400px;
            min-height: 250px; /* Ensure enough height */
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            margin: 0 auto;
            position: relative;
            overflow: visible;
            padding-bottom: 1px; /* Ensure footer space */
        }

        .id-card-header {
            background-color: maroon;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 18px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 60px;
        }
        .id-card-header h1 {
            margin: 0;
            font-size: 18px;
        }
        .id-card-header p {
            margin: 0;
            font-size: 14px;
        }
        .id-card-footer {
            background-color: grey;
            color: white;
            padding: 5px;
            font-size: 14px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 50px;
        }
        .id-card-footer p {
            margin-bottom: 2px;
        }
        .content {
            display: flex;
            padding: 10px 20px;
            flex: 1;
        }
        .photo {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .photo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2px solid #ccc;
        }
        .details {
            flex: 2;
            padding-left: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .details h2 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .details p {
            margin: 3px 0;
            font-size: 14px;
            color: #555;
        }
        .qr-code {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .qr-code img {
            width: 50px;
            height: 50px;
            margin-left: 10px;
            border-radius: 0;
        }
        .additional-info {
            display: flex;
            justify-content: space-between;
            margin-top: 2px;
            padding-top: 3px;
            border-top: 1px solid #ccc;
        }
        .additional-info p {
            margin: 2px;
            font-size: 12px;
            color: #555;
        }

        /* Print styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .id-card {
                width: auto;
                border: none;
                box-shadow: none;
                page-break-inside: avoid;
            }

            .no-print {
                display: none;
            }
        }

    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Kerala Congress</h3>
            <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="get_card.php"><i class="fas fa-id-card"></i> Get Card</a>
        <a href="#"><i class="fas fa-money-check-alt"></i> Checkout Payments</a>
        <a href="find_member.php"><i class="fas fa-users"></i> Find Members</a>
        <a href="#"><i class="fas fa-key"></i> Change Password</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </nav>

        
        <div class="content-header">
            <h2>Membership Status</h2>
        </div>

        <form id="regForm" method="post">
            <div class="form-group">
                <label for="reg_no">Registration Number:</label>
                <input type="text" class="form-control" id="reg_no" name="reg_no" required>
            </div>
            <button type="submit" class="btn btn-primary">Check Status</button>
        </form>

        <?php if (!empty($message)) : ?>
            <div class="alert alert-warning mt-3"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (!empty($member)) : ?>
            <div class="id-card" id="idCard">
                <div class="id-card-header">
                    <h1><?php echo htmlspecialchars($member['membership']); ?></h1>
                    <p>MEMBERSHIP CARD</p>
                </div>
                <div class="content">
                    <div class="photo">
                        <img src="<?php echo htmlspecialchars($member['photo']); ?>" alt="Member Photo">
                    </div>
                    <div class="details">
                        <h2><?php echo htmlspecialchars($member['fname'] . ' ' . $member['lname']); ?></h2>
                        <p>No: <?php echo htmlspecialchars($member['reg_no']); ?></p>
                        <p><?php echo htmlspecialchars($member['gender']) . ' ' . htmlspecialchars($member['blood']); ?></p>
                        <p>DOB: <?php echo htmlspecialchars($member['dateofbirth']); ?></p>
                    </div>
                    <div class="qr-code">
                        <img src="images/kc_qr.png" alt="QR Code">
                    </div>
                </div>
                <div class="additional-info">
                    <p>Contact<br><?php echo htmlspecialchars($member['mobile']); ?></p>
                    <!--<p>Ward<br><?php echo htmlspecialchars($member['ward']); ?></p>-->
                    <p>District<br><?php echo htmlspecialchars($member['district']); ?></p>
                    <p>Constituency<br><?php echo htmlspecialchars($member['assembly']); ?></p>
                    
                </div>
                <div class="id-card-footer">
                    <p>Secretary <br><?php echo htmlspecialchars($member['secretary']); ?></p>
                    <p>President <br><?php echo htmlspecialchars($member['president']); ?></p>
                </div>
            </div>
            <button id="printBtn" class="btn btn-success mt-3 no-print">Print ID Card</button>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlrzPjJ2MIrE+vmPjK/oRLsNbR0s6E9hD0eFxyU2P4UA5P52T0RzjaWczP9" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eydk7Xl7r6M3va31GxDIbMjzw6d8fYj76w4uhCZvQ+jrxhggdft/3ao" crossorigin="anonymous"></script>
    <script>
    document.getElementById('printBtn').addEventListener('click', function () {
        var content = document.getElementById('idCard').innerHTML;
        var printWindow = window.open('', '', 'height=600,width=600');
        printWindow.document.write('<html><head><title>Print ID Card</title>');
        printWindow.document.write('<style>');
        printWindow.document.write('body { font-family: Arial, sans-serif; margin: 150px; padding: 0; }');
        printWindow.document.write('.id-card { width: 400px; min-height: 250px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0 auto; padding: 20px; }');
        printWindow.document.write('.id-card-header { background-color: maroon; color: white; text-align: center; padding: 10px; font-size: 18px; border-top-left-radius: 8px; border-top-right-radius: 8px; }');
        printWindow.document.write('.id-card-header h1 { margin: 0; font-size: 18px; }');
        printWindow.document.write('.id-card-header p { margin: 0; font-size: 14px; }');
        printWindow.document.write('.id-card-footer { background-color: grey; color: white; padding: 5px; font-size: 14px; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; display: flex; justify-content: space-between; align-items: center; }');
        printWindow.document.write('.id-card-footer p { margin-bottom: 2px; }');
        printWindow.document.write('.content { display: flex; padding: 10px 20px; }');
        printWindow.document.write('.photo { flex: 1; display: flex; align-items: center; justify-content: center; }');
        printWindow.document.write('.photo img { width: 100px; height: 100px; border-radius: 50%; border: 2px solid #ccc; }');
        printWindow.document.write('.details { flex: 2; padding-left: 20px; display: flex; flex-direction: column; justify-content: center; }');
        printWindow.document.write('.details h2 { margin: 0; font-size: 20px; color: #333; }');
        printWindow.document.write('.details p { margin: 3px 0; font-size: 14px; color: #555; }');
        printWindow.document.write('.qr-code { display: flex; align-items: center; justify-content: center; }');
        printWindow.document.write('.qr-code img { width: 50px; height: 50px; margin-left: 10px; border-radius: 0; }');
        printWindow.document.write('.additional-info { display: flex; justify-content: space-between; margin-top: 2px; padding-top: 3px; border-top: 1px solid #ccc; }');
        printWindow.document.write('.additional-info p { margin: 2px; font-size: 12px; color: #555; }');
        printWindow.document.write('@media print { .no-print { display: none; } }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    });
</script>



</body>
</html>
