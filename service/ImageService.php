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

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $validExtensions)) {
            $message = 'Hanya file dengan ekstensi JPG, JPEG, atau PNG yang diizinkan.';
            return array(false, $message);
        }

        if ($fileSize > $maxFileSize) {
            $message = 'Ukuran file melebihi batas maksimum 2MB';
            return array(false, $message);
        }

        $newFileName = $fileName;
        $destPath = $uploadPath . '/' . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            $message = 'Gagal mengupload file.';
            return array(false, $message);
        }

        return array(true, str_replace('../', '', $destPath));
    }
}
