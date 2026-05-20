<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$message = "";
$status = "";
$redirect = "";

// Periksa apakah berkas sebenarnya adalah gambar atau bukan
/*if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Berkas adalah gambar - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Berkas bukan gambar.";
        $uploadOk = 0;
    }
}
*/

// Periksa apakah berkas sudah ada
if (file_exists($target_file)) {
    $message = "Maaf, berkas sudah ada.";
    $uploadOk = 0;
}

// Periksa ukuran berkas (dalam byte, 500000 byte = 500KB)
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $message = "Maaf, berkas Anda terlalu besar.";
    $uploadOk = 0;
}

// Hanya izinkan format berkas tertentu
/*
if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
&& $fileType != "gif" ) {
    echo "Maaf, hanya berkas JPG, JPEG, PNG & GIF yang diperbolehkan.";
    $uploadOk = 0;
}
*/

// Periksa apakah $uploadOk bernilai 0 karena kesalahan
if ($uploadOk == 0) {
    $status = "Upload Gagal";
    $redirect = "index.html";
    if ($message == "") {
        $message = "Maaf, berkas Anda tidak dapat diunggah.";
    }
// Jika semua oke, coba unggah berkas
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $status = "Upload Berhasil";
        $message = "Berkas " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " telah diunggah.";
        $redirect = "lihat_file.php";
    } else {
        $status = "Upload Gagal";
        $message = "Maaf, terjadi kesalahan saat mengunggah berkas Anda.";
        $redirect = "index.html";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Status Upload</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="popup-overlay">
    <div class="popup-box">
        <h3><?php echo $status; ?></h3>
        <p><?php echo $message; ?></p>

        <a href="<?php echo $redirect; ?>">
            <button>OK</button>
        </a>
    </div>
</div>

</body>
</html>