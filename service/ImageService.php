<?php

class ImageService
{
    public function uploadImage($image, $folder)
    {
        $uploadPath = '../assets/img/' . $folder;

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $validExtensions = ['jpg', 'jpeg', 'png'];
        $maxFileSize = 2 * 1024 * 1024;

        $fileTmpPath = $image['tmp_name'];
        $fileName = $image['name'];
        $fileSize = $image['size'];
        $fileError = $image['error'];

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $validExtensions)) {
            echo "<script>alert('Error: Hanya file dengan ekstensi JPG, JPEG, atau PNG yang diizinkan.'); window.history.back();</script>";
            return false;
        }

        if ($fileSize > $maxFileSize) {
            echo "<script>alert('Error: Ukuran file melebihi batas maksimum 2MB.'); window.history.back();</script>";
            return false;
        }

        $newFileName = $fileName;
        $destPath = $uploadPath . '/' . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            echo "<script>alert('Error: Gagal mengupload file.'); window.history.back();</script>";
            return false;
        }

        return str_replace('../', '', $destPath);
    }
}
