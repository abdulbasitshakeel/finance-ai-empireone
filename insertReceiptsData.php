<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("include/db.php");

$json = file_get_contents("php://input");
$input = json_decode($json, true);

if (!$input) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input."]);
    exit;
}

$required = [
    "image_id", "date", "order_or_reference_number", "supplier_name", "supplier_address", "supplier_register_name", 
    "supplier_tin", "purchase_category", "expense_category", "gross_purchase_amount", 
    "net_purchase_amount", "input_tax", "vat_exempt_purchases", "zero_rated_purchases"
];

$hasData = false;
foreach ($required as $field) {
    if (isset($input[$field]) && $input[$field] !== '') {
        $hasData = true;
        break;
    }
}

if (!$hasData) {
    echo json_encode(["status" => "error", "message" => "At least one field must be filled."]);
    exit;
}

if($input['date'] != '' || $input['date'] != null)
{
	$dateInput = trim($input['date']);
	$timestamp = strtotime($dateInput);

	if ($timestamp === false) {
		echo json_encode([
			"status" => "error",
			"message" => "Invalid date format: $dateInput"
		]);
		exit;
	}

	$date = date("m/d/Y", $timestamp);
}
else $date = '';

$order_no              = $input['order_or_reference_number'] != '' ? mysqli_real_escape_string($conn, $input['order_or_reference_number']) : null;
$supplier_name         = $input['supplier_name'] != '' ? mysqli_real_escape_string($conn, $input['supplier_name']) : null;
$supplier_address      = $input['supplier_address'] != '' ? mysqli_real_escape_string($conn, $input['supplier_address']) : null;
$supplier_register_name      = $input['supplier_register_name'] != '' ? mysqli_real_escape_string($conn, $input['supplier_register_name']) : null;
$supplier_tin          = $input['supplier_tin'] != '' ? mysqli_real_escape_string($conn, $input['supplier_tin']) : null;
$purchase_category     = $input['purchase_category'] != '' ? mysqli_real_escape_string($conn, $input['purchase_category']) : null;
$expense_category     = $input['expense_category'] != '' ? mysqli_real_escape_string($conn, $input['expense_category']) : null;
$gross_purchase_amount = $input['gross_purchase_amount'] != '' ? mysqli_real_escape_string($conn, $input['gross_purchase_amount']) : null;
$net_purchase_amount   = $input['net_purchase_amount'] != '' ? mysqli_real_escape_string($conn, $input['net_purchase_amount']) : null;
$input_tax             = $input['input_tax'] != '' ? mysqli_real_escape_string($conn, $input['input_tax']) : null;
$vat_exempt_purchases  = $input['vat_exempt_purchases'] != '' ? mysqli_real_escape_string($conn, $input['vat_exempt_purchases']) : null;
$zero_rated_purchases  = $input['zero_rated_purchases'] != '' ? mysqli_real_escape_string($conn, $input['zero_rated_purchases']) : null;
$image_id              = $input['image_id'] != '' ? mysqli_real_escape_string($conn, $input['image_id']) : null;

// Insert query
$query = "INSERT INTO reciepts_data (
    image_id, date, order_or_reference_number, supplier_name, supplier_address, supplier_register_name,
    supplier_tin, purchase_category, expense_category, gross_purchase_amount, net_purchase_amount, 
    input_tax, vat_exempt_purchases, zero_rated_purchases, added_at
) VALUES (
    '$image_id', '$date', '$order_no', '$supplier_name', '$supplier_address', '$supplier_register_name',
    '$supplier_tin', '$purchase_category', '$expense_category', '$gross_purchase_amount', '$net_purchase_amount',
    '$input_tax', '$vat_exempt_purchases', '$zero_rated_purchases', NOW()
)";

if (mysqli_query($conn, $query)) {
    // mysqli_query($conn, "UPDATE receipt_images SET isFetched = 1 WHERE image_id = $image_id");
    echo json_encode([
        "status" => "success",
        "message" => "Receipt record inserted successfully."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . mysqli_error($conn)
    ]);
}

mysqli_close($conn);

?>
