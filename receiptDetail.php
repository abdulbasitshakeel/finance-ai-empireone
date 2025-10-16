<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include "include/db.php";

$action = $_POST['action'] ?? '';
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

$response = [];

switch ($action) {

    case 'view':
        $query = "SELECT * 
        FROM reciepts_data RD 
        INNER JOIN receipt_images RI ON RI.image_id = RD.image_id 
        WHERE id=$id";

        $result = $conn->query($query);

        $data = $result->fetch_assoc();
        $data['file_path'] = $data['file_path'] && file_exists($data['file_path']) ? $data['file_path'] : 'assets/images/no-image.jpg';

        $response = [
            'status' => 'success',
            'data' => $data
        ];
        break;

    case 'delete':
        if ($id > 0) {
            $sql = "SELECT image_id FROM reciepts_data WHERE id = $id LIMIT 1";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) == 0) {
                echo json_encode(["status" => "error", "message" => "Image Record not found."]);
                exit;
            }

            $row = mysqli_fetch_assoc($result);
            $image_id = $row['image_id'];

            $sqlImage = "SELECT file_path FROM receipt_images WHERE image_id = $image_id LIMIT 1";
            $resultImage = mysqli_query($conn, $sqlImage);

            if (mysqli_num_rows($resultImage) > 0)
            {
                $imageRow = mysqli_fetch_assoc($resultImage);
                $filePath = $imageRow['file_path'];

                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                mysqli_query($conn, "DELETE FROM receipt_images WHERE image_id = $image_id");
            }

            $query = "DELETE FROM reciepts_data WHERE id = $id";
            if ($conn->query($query)) {
                $response = ['status' => 'success', 'message' => 'Record deleted successfully'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to delete record'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Invalid ID'];
        }
        break;

    case 'update':
        if ($id > 0) {
            $date = $conn->real_escape_string($_POST['editDate'] ?? '');
            $order_no = $conn->real_escape_string($_POST['editOrderNumber'] ?? '');
            $supplier_name = $conn->real_escape_string($_POST['editSupplierName'] ?? '');
            $supplier_reg_name = $conn->real_escape_string($_POST['editSupplierRegisterName'] ?? '');
            $supplier_address = $conn->real_escape_string($_POST['editSupplierAddress'] ?? '');
            $supplier_tin = $conn->real_escape_string($_POST['editSupplierTIN'] ?? '');
            $purchase_category = $conn->real_escape_string($_POST['editPurchaseCategory'] ?? '');
            $expense_category = $conn->real_escape_string($_POST['editExpenseCategory'] ?? '');
            $gross = $conn->real_escape_string($_POST['editGrossAmount'] ?? '');
            $net = $conn->real_escape_string($_POST['editNetAmount'] ?? '');
            $input_tax = $conn->real_escape_string($_POST['editInputTax'] ?? '');
            $vat_exempt = $conn->real_escape_string($_POST['editVatExempt'] ?? '');
            $zero_rated = $conn->real_escape_string($_POST['editZeroRated'] ?? '');

            $query = "
                UPDATE reciepts_data SET
                    date = '$date',
                    order_or_reference_number = '$order_no',
                    supplier_name = '$supplier_name',
                    supplier_register_name = '$supplier_reg_name',
                    supplier_address = '$supplier_address',
                    supplier_tin = '$supplier_tin',
                    purchase_category = '$purchase_category',
                    expense_category = '$expense_category',
                    gross_purchase_amount = '$gross',
                    net_purchase_amount = '$net',
                    input_tax = '$input_tax',
                    vat_exempt_purchases = '$vat_exempt',
                    zero_rated_purchases = '$zero_rated'
                WHERE id = $id
            ";

            if ($conn->query($query)) {
                $response = ['status' => 'success', 'message' => 'Record updated successfully'];
            } else {
                $response = ['status' => 'error', 'message' => 'Update failed: ' . $conn->error];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Invalid ID'];
        }
        break;

    default:
        $response = ['status' => 'error', 'message' => 'Invalid action'];
        break;
}

echo json_encode($response);