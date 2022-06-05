<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['first_name']) && isset($_POST['password']) &&
        isset($_POST['last_name']) && isset($_POST['email']) &&
        isset($_POST['user_name']) && isset($_POST['confirm_password'])) {
        
        $first_name = $_POST['first_name'];
        $password = $_POST['password'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $user_name = $_POST['user_name'];
        $confirm_password = $_POST['confirm_password'];

        $host = "localhost";
        $dbfirst_name = "root";
        $dbPassword = "";
        $dbName = "signuppage";

        $conn = new mysqli($host, $dbfirst_name, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(first_name, last_name,user_name, email, password, confirm_password) values(?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssss",$first_name, $last_name,$user_name, $email, $password, $confirm_password);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>