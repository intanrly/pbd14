<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro|PT+Mono" rel="stylesheet">
    <title>Customer List by City</title>
</head>
<style>
    form {
        margin-top: 20px;
    }
    body {
        background: #fff;
        color: #222;
        font-family: 'Source Sans Pro', sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .code {
        font-family: 'PT Mono', serif;
        color: #090;
    }
    .writing {
        width: 74%;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }
    @media (max-width: 560px) {
        .writing {
            width: 96%;
        }
    }
    .background-oregon-grapes {
        background-color: #0e4c92;
        background-size: 100%;
        height: 420px;
        width: 420px;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        background-attachment: fixed;
        margin-left: auto;
        margin-right: auto;
        margin-top: 50px;
    }
    @media (max-width: 767px) {
        .background-oregon-grapes {
            height: 330px;
            width: 330px;
        }
    }
    img {
        height: 100%;
        width: 100%;
    }
    h1 {
        color: #0e4c92;
    }

    p {
    padding-bottom: 25px;
    color: rgb(53, 162, 162);
    }
    h1 {
        color: #0e4c92; 
    }
    body {
        background: #fff;
        color: #222;
        font-family: 'Source Sans Pro', sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    form {
        text-align: center;
    }
    label {
        color: #0e4c92;
        text-align: center;
    }

    input {
        background-color: #0e4c92;
        color: #ffffff;
        padding: 5px 10px;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 10px;
        justify-content: center;
        align-items: center;
    }

    input#city {
        background-color: #0e4c92;
        color: #ffffff; /* Ubah warna teks menjadi putih */
        padding: 5px 10px;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 10px;
        justify-content: center;
        align-items: center;
    }

    button {
        background-color: #0e4c92;
        color: #ffffff;
        padding: 5px 10px;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 10px;
        justify-content: center;
        align-items: center;
    }
    table {
        border-collapse: collapse;
        width: 80%;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #0e4c92;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #0e4c92;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #ddd;
    }
     a {
        margin-top: 20px;
        float: center;
    }

    a {
        display: inline-block;
        background-color: #0e4c92;
        color: white;
        text-decoration: none;
        padding: 8px 10px;
        border-radius: 10px;
        margin: 10 0px;
        transition: background-color 0.3s ease;
    }

    a:hover {
        background-color: #87cdee;
    }
    button:hover {
        background-color: #87cdee;
    }
</style>
<body>
    <h1>Customer Name by City</h1>

    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="city">City :</label>
        <input type="text" id="city" name="city">
        <button type="submit">Submit</button>
    </form>

    <?php
    // Koneksi ke database
    $servername = "mysql-intanrly.alwaysdata.net";
    $username = "intanrly";
    $password = "pbdcoba";
    $dbname = "intanrly_pbd14";
    $port = 3306;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Ambil kota dari form input
    $city = isset($_GET['city']) ? $_GET['city'] : '';

    // Query untuk mengambil daftar customer berdasarkan kota
    $sql = "SELECT customerName, city FROM customers WHERE city = '$city'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Customer Name</th><th>City</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["customerName"] . "</td><td>" . $row["city"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No customers found for the city : " . $city;
    }

    $conn->close();
    ?>

    <h1>Customers with Shipped Date</h1>

    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="shippedDate">Shipped Date :</label>
        <input type="date" id="shippedDate" name="shippedDate" required>
        <button type="submit">Submit</button>
    </form>

    <?php
    // Koneksi ke database
    $servername = "mysql-intanrly.alwaysdata.net";
    $username = "intanrly";
    $password = "pbdcoba";
    $dbname = "intanrly_pbd14";
    $port = 3306;

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Create connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Ambil Shipped Date dari form input
    $shippedDate = isset($_GET['shippedDate']) ? $_GET['shippedDate'] : '';

    if (!empty($shippedDate)) {
        // Query untuk mengambil daftar customer berdasarkan Shipped Date
        $sql = "
            SELECT c.customerName, o.shippedDate
            FROM customers c
            JOIN orders o ON c.customerNumber = o.customerNumber
            WHERE o.shippedDate = '$shippedDate'
            GROUP BY c.customerName, o.shippedDate
        ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Customer Name</th><th>Shipped Date</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["customerName"] . "</td><td>" . $row["shippedDate"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No customers found for the Shipped Date: " . $shippedDate;
        }
    }

    $conn->close();
    ?>
    <a href="http://intanrly.alwaysdata.net/pbd14/utama.html" class="btn">Back To Home</a>
    <div class="background-oregon-grapes">
        <img src="https://aeoneal.com/imagery/brain-reverse-cutout.svg">
    </div>
</body>
</html>
