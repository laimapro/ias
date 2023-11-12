<?php
$directory = 'instancias';  // Folder to save the files

// Ensure the directory exists
if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
}

$data = json_decode(file_get_contents("php://input"), true);

if ($data && isset($data['title'])) {
    $fileName = $directory . '/' . $data['title'] . '.json';
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

    if (file_put_contents($fileName, $jsonData)) {
        echo "File saved successfully.";
    } else {
        echo "Failed to save the file.";
    }
} else {
    echo "Invalid data.";
}
?>
