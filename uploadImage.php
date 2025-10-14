<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("include/db.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method!"
    ]);
    exit;
}

if (isset($_FILES['image'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    $fileType = mime_content_type($_FILES['image']['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(["status" => "error", "message" => "Only JPG, JPEG and PNG files are allowed."]);
        exit;
    }

    $targetDir = "assets/receipt_images/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $uniqueId = bin2hex(random_bytes(6));
    $fileName = "img_" . time() . "_" . $uniqueId . "." . $extension;

    $targetFile = $targetDir . $fileName;
    $image_id = null;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {

        $sql = "INSERT INTO receipt_images (file_name, file_path, isFetched) 
                VALUES ('$fileName', '$targetFile', 0)";
        if (mysqli_query($conn, $sql)) {
            $image_id = mysqli_insert_id($conn);
            $imageData = base64_encode(file_get_contents($targetFile));

            $payload = [
                "fileName" => $fileName,
                "image_id" => $image_id,
                "base64"   => $imageData
            ];

            $ch = curl_init("https://api.geosynthai.com/api/process-receipts");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $apiResponse = json_decode($response, true);

            if (isset($apiResponse['status']) && $apiResponse['status'] === "success") {
                mysqli_query($conn, "UPDATE receipt_images SET isFetched = 1 WHERE image_id = $image_id");

                echo json_encode([
                    "status" => "success",
                    "message" => "Image uploaded & processed successfully."
                ]);
                mysqli_close($conn);
                exit;
            }
        }
    }

    // Rollback if failed
    if ($image_id) mysqli_query($conn, "DELETE FROM receipt_images WHERE image_id = $image_id");
    if (file_exists($targetFile)) unlink($targetFile);

    echo json_encode([
        "status" => "error",
        "message" => "Image upload failed!"
    ]);
    exit;

} else {
    echo json_encode([
        "status" => "error",
        "message" => "No image received!"
    ]);
    exit;
}

mysqli_close($conn);
?>
