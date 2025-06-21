<?php

const MIME_FILTER = [
    'audio/mpeg', 'audio/mpeg3', 'audio/x-mpeg', 'audio/x-mpeg-3'
];

const MAX_FILE_SIZE = 10485760; // 10 MB

function uploadFile(array $file): void {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload error: ' . $file['error']);
    }

    if (! in_array($file['type'], MIME_FILTER)) {
        throw new Exception('Invalid file type: ' . $file['type']);
    }

    if ($file['size'] > MAX_FILE_SIZE) {
        throw new Exception('File size exceeds the limit of ' . (MAX_FILE_SIZE / 1024 / 1024) . ' MB');
    }

    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/files/' . basename($file['name']);

    if (! move_uploaded_file($file['tmp_name'], $uploadDirectory)) {
        throw new Exception('Failed to move uploaded file.');
    }

    echo 'File uploaded successfully: ' . htmlspecialchars($file['name']);
}