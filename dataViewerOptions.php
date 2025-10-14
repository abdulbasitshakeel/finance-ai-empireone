<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include("include/db.php");

$supplierQuery = "SELECT DISTINCT supplier_name FROM reciepts_data WHERE supplier_name IS NOT NULL AND supplier_name <> '' ORDER BY supplier_name ASC";
$supplierResult = mysqli_query($conn, $supplierQuery);
$suppliers = [];
while ($row = mysqli_fetch_assoc($supplierResult)) {
    $suppliers[] = $row['supplier_name'];
}

$categoryQuery = "SELECT DISTINCT expense_category FROM reciepts_data WHERE expense_category IS NOT NULL AND expense_category <> '' ORDER BY expense_category ASC";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categories = [];
while ($row = mysqli_fetch_assoc($categoryResult)) {
    $categories[] = $row['expense_category'];
}

echo json_encode([
    "status" => "success",
    "suppliers" => $suppliers,
    "categories" => $categories
]);
?>