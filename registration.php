<?php
// Include connect.php for database connection
include('connect.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve all form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $membership = $_POST['membership'];
    $aadhaar = $_POST['aadhaar'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $dateofbirth = $_POST['dateofbirth'];
    $fathername = $_POST['fathername'];
    $religion = $_POST['religion'];
    $caste = $_POST['caste'];
    $gender = $_POST['gender'];
    $blood = $_POST['blood'];
    $district = $_POST['sts'];
    $assembly = $_POST['state'];
    $selfgovt = $_POST['selfgovt'];
    $ward = $_POST['ward'];
    $reference = $_POST['reference'];
    $president = $_POST['president'];
    $secretary = $_POST['secretary'];

    // Check if the mobile number already exists
    $query = "SELECT COUNT(*) as count FROM members WHERE mobile = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo "Error: Mobile number already exists.";
        $stmt->close();
        $con->close();
        exit();
    }

    // Generate a unique 5-digit registration number
    function generateUniqueRegNo($con) {
        do {
            $reg_no = rand(10000, 99999);
            $query = "SELECT COUNT(*) as count FROM members WHERE reg_no = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $reg_no);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
        } while ($row['count'] > 0);

        return $reg_no;
    }

    $reg_no = generateUniqueRegNo($con);

    // Handle file upload for photo
    if(isset($_FILES['photo'])) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if directory exists or create it
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // // Check if file already exists
        // if (file_exists($targetFile)) {
        //     echo "Sorry, file already exists.";
        //     $uploadOk = 0;
        // }

        // Check file size
        if ($_FILES["photo"]["size"] > 2000000) {
            echo ".";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if(!in_array($imageFileType, $allowedTypes)) {
            echo "";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
                //echo "The file ". htmlspecialchars( basename( $_FILES["photo"]["name"])). " has been uploaded.";
            } else {
                echo "";
            }
        }
    } else {
        echo "No file uploaded.";
    }
    $president = $_POST['president'];
    $secretary = $_POST['secretary'];
    // Prepare and bind parameters including photo path, status, and reg_no
    $stmt = $con->prepare("INSERT INTO members (reg_no, fname, lname, membership, aadhaar, address, email, mobile, dateofbirth, fathername, religion, caste, gender, blood, photo, district, assembly, selfgovt, ward, president, secretary, reference, status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Error preparing statement: ' . $con->error);
    }

    $status = 0;
    $stmt->bind_param("isssisssssssssssssssssi", $reg_no, $fname, $lname, $membership, $aadhaar, $address, $email, $mobile, $dateofbirth, $fathername, $religion, $caste, $gender, $blood, $targetFile, $district, $assembly, $selfgovt, $ward, $president, $secretary, $reference, $status);

    // Execute the statement
    if ($stmt->execute()) {
        
        echo "Registration Successful";
    } else {
        echo "Error inserting record: " . $stmt->error;
    }

    $stmt->close();
}

$con->close();
?>