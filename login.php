<?php
// Thiết lập thông tin kết nối đến database
$servername = "db-website.cremmqk8ij6y.ap-southeast-1.rds.amazonaws.com";
$username = "admin";
$password = "minhchi123";
$dbname = "myDB";

// Tạo kết nối đến database
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Kiểm tra nếu form đã submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị từ form
    $user = $_POST["username"];
    $pass = $_POST["password"];

    // Dùng prepared statement để truy vấn an toàn
    $stmt = $conn->prepare("SELECT * FROM User WHERE userName = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra số lượng bản ghi trả về
    if ($result->num_rows > 0) {
        echo "Bạn đã đăng nhập thành công";
    } else {
        echo "Bạn đã đăng nhập không thành công";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Tên đăng nhập:</label>
        <input type="text" name="username" required><br><br>
        <label>Mật khẩu:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Đăng nhập">
    </form>
</body>
</html>
