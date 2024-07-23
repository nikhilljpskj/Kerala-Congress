<?php
session_start(); // Ensure session is started


require_once "connect.php";
require_once __DIR__ . '/vendor/autoload.php'; // Include Composer autoload file

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile = $_POST['mobile'];

    if (!empty($mobile)) {
        // Query to check the status of the member
        $statusQuery = "SELECT status FROM members WHERE mobile = ?";
        $stmt = $con->prepare($statusQuery);
        $stmt->bind_param("s", $mobile);
        $stmt->execute();
        $statusResult = $stmt->get_result();

        if ($statusResult->num_rows > 0) {
            $statusRow = $statusResult->fetch_assoc();
            $status = $statusRow['status'];

            if ($status == 0) {
                // Status is 0, show the message
                $message = "Your verification is under process.";
            } else if ($status == 1) {
                // Status is 1, proceed with fetching member details
                $detailsQuery = "SELECT * FROM members WHERE mobile = ?";
                $stmt = $con->prepare($detailsQuery);
                $stmt->bind_param("s", $mobile);
                $stmt->execute();
                $detailsResult = $stmt->get_result();

                if ($detailsResult->num_rows > 0) {
                    $member = $detailsResult->fetch_assoc();
                    $message = "ID card generated successfully!";
                    // You can also process member details here as needed
                } else {
                    $message = "No member found with registration number " . htmlspecialchars($mobile);
                }
            } else {
                $message = "Invalid status for member.";
            }
        } else {
            $message = "No member found with registration number " . htmlspecialchars($mobile);
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerala Congress::Political Party in Kerala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/mega-menu-style.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="owl/dist/assets/owl.carousel.min.css">
    <link rel="shortcut icon" href="images/pjjoseph.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.6.0/jspdf.umd.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            overflow: visible;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
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
    <!-- Section: Header -->
    <header class="header">
        <div class="container-fluid">
            <section class="wrapper">
                <div class="header-item-left">
                    <h3 class="title ms-sm-3"><a href="index.html" class="brand">Kerala Congress</a></h3>
                </div>
                <!-- Navbar Menu -->
                <div class="header-item-center">
                    <div class="overlay"></div>
                    <nav class="menu" id="menu">
                        <div class="menu-mobile-header">
                            <button type="button" class="menu-mobile-arrow"><i class="ion ion-ios-arrow-back"></i></button>
                            <div class="menu-mobile-title"></div>
                            <button type="button" class="menu-mobile-close"><i class="ion ion-ios-close"></i></button>
                        </div>
                        <ul class="menu-section">
                            <li class="menu-item"><a href="index.html">Home</a></li>
                            <li class="menu-item-has-children">
                                <a href="#">Organizations<i class="ion ion-ios-arrow-down"></i></a>
                                <div class="menu-subs menu-mega menu-column-4">
                                    <div class="list-item text-center">
                                        <a href="./youthfront/index.html">
                                            <h4 class="title" onclick="window.location.href='/youthfront/index.html'">Kerala Youth Front(KYF)</h4>
                                        </a>
                                    </div>
                                    <div class="list-item text-center">
                                        <a href="./kitproc/index.html">
                                            <h4 onclick="window.location.href='/kitproc/index.html'" class="title">Kerala IT & Professional Congress(KITPROC)</h4>
                                        </a>
                                    </div>
                                    <div class="list-item text-center">
                                        <a href="./kitproc/index.html">
                                            <h4 class="title">Kerala Student Congress (KSC)</h4>
                                        </a>
                                    </div>
                                    <div class="list-item text-center">
                                        <a href="#">
                                            <h4 class="title" onclick="window.location.href='organizations.html'">Frontal organizations</h4>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="menu-item">
                                <a href="about.html">About us <i class="ion ion-ios-arrow-down"></i></a>
                            </li>
                            <li class="menu-item-has-children"><a href="media.html">Media</a></li>
                            <li class="menu-item"><a href="contact.html">Contact Us</a></li>
                            <li class="menu-item"><a href="./regform.html">Join Us</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="header-item-right">
                    <button type="button" class="menu-mobile-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </section>
        </div>
    </header>

    <div class="main-content">
        <div class="content-header">
            <h2>Membership Status</h2>
        </div>

        <form id="regForm" method="post">
            <div class="form-group">
                <label for="mobile">Enter Your Registered Mobile Number:</label>
                <input type="text" class="form-control" id="mobile" name="mobile" required>
            </div>
            <br>
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

    <footer>
        <p class="footer">Kerala Congress (Joseph) Copyright &copy; 2021</p>
    </footer>

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
        printWindow.document.write('@media print { .no-print { display: none; }');
        printWindow.document.write('.id-card-header { background-color: maroon !important; color: white !important; }');
        printWindow.document.write('.id-card-footer { background-color: grey !important; color: white !important; }');
        printWindow.document.write('}');

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
