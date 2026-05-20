<?php
$folder = "uploads/";

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

if (isset($_GET['hapus'])) {
    $file = basename($_GET['hapus']);
    $path = $folder . $file;

    if (file_exists($path)) {
        unlink($path);
        echo "<script>alert('File berhasil dihapus.'); window.location.href='lihat_file.php';</script>";
    } else {
        echo "<script>alert('File tidak ditemukan.'); window.location.href='lihat_file.php';</script>";
    }
}

if (isset($_GET['download'])) {
    $file = basename($_GET['download']);
    $path = $folder . $file;

    if (file_exists($path)) {
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . basename($path) . "\"");
        header("Content-Length: " . filesize($path));
        readfile($path);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lihat File Upload</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="halaman-file">

<div class="container">

    <h2>Daftar File yang Sudah Diupload</h2>

    <a href="index.html">
        <button>Kembali ke Halaman Upload</button>
    </a>

    <br><br>

    <div class="file-list">

    <?php
    $files = array_diff(scandir($folder), array('.', '..'));

    if (count($files) > 0) {
        foreach ($files as $file) {
            $path = $folder . $file;
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            echo "<div class='file-card'>";

            echo "<div class='preview'>";
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "<img src='" . $path . "'>";
            } else {
                echo "<p>Tidak ada preview</p>";
            }
            echo "</div>";

            echo "<div class='file-info'>";
            echo "<h3>" . htmlspecialchars($file) . "</h3>";

            echo "<div class='aksi'>";
            echo "<a href='lihat_file.php?download=" . urlencode($file) . "'>
                    <button>Download</button>
                  </a>";

            echo "<a href='lihat_file.php?hapus=" . urlencode($file) . "'
                    onclick=\"return confirm('Yakin ingin menghapus file ini?')\">
                    <button>Hapus</button>
                  </a>";
            echo "</div>";

            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>Belum ada file yang diupload.</p>";
    }
    ?>

    </div>

</div>

</body>
</html>