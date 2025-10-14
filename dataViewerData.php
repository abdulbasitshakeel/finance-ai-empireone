<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include "include/db.php";

$page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 7;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$supplierFilter = isset($_GET['supplier']) ? trim($_GET['supplier']) : "";
$expenseCategoryFilter = isset($_GET['expense_category']) ? trim($_GET['expense_category']) : "";

$where = [];
if ($search !== "") {
    $searchEscaped = $conn->real_escape_string($search);
    $where[] = "( 
        RD.date LIKE '%$searchEscaped%' 
        OR RD.order_or_reference_number LIKE '%$searchEscaped%'
        OR RD.supplier_name LIKE '%$searchEscaped%'
        OR RD.supplier_address LIKE '%$searchEscaped%'
		OR RD.supplier_register_name LIKE '%$searchEscaped%'
        OR RD.supplier_tin LIKE '%$searchEscaped%'
        OR RD.purchase_category LIKE '%$searchEscaped%'
		OR RD.expense_category LIKE '%$searchEscaped%'
        OR RD.gross_purchase_amount LIKE '%$searchEscaped%'
        OR RD.net_purchase_amount LIKE '%$searchEscaped%'
        OR RD.input_tax LIKE '%$searchEscaped%'
        OR RD.vat_exempt_purchases LIKE '%$searchEscaped%'
        OR RD.zero_rated_purchases LIKE '%$searchEscaped%'
        OR RD.added_at LIKE '%$searchEscaped%'
    )";
}

if ($supplierFilter !== "") {
    $supplierEscaped = $conn->real_escape_string($supplierFilter);
    $where[] = "RD.supplier_name LIKE '%$supplierEscaped%'";
}

if ($expenseCategoryFilter !== "") {
    $expenseCategoryEscaped = $conn->real_escape_string($expenseCategoryFilter);
    $where[] = "RD.expense_category LIKE '%$expenseCategoryEscaped%'";
}

$whereSql = "";
if (!empty($where)) {
    $whereSql = "WHERE " . implode(" AND ", $where);
}

$totalSql = "SELECT COUNT(*) as total 
             FROM reciepts_data RD 
             INNER JOIN receipt_images RI ON RI.image_id = RD.image_id 
             $whereSql";

$totalRes = $conn->query($totalSql);
if (!$totalRes) {
    echo json_encode([
        "status" => "error",
        "message" => "SQL Error: " . $conn->error
    ]);
    exit;
}

$totalRow = $totalRes->fetch_assoc();
$total = (int) $totalRow['total'];

$sql = "SELECT * 
        FROM reciepts_data RD 
        INNER JOIN receipt_images RI ON RI.image_id = RD.image_id 
        $whereSql 
        ORDER BY RD.id DESC 
        LIMIT $limit OFFSET $offset";

$res = $conn->query($sql);
if (!$res) {
    echo json_encode([
        "status" => "error",
        "message" => "SQL Error: " . $conn->error
    ]);
    exit;
}

$data = [];
while ($row = $res->fetch_assoc()) {
    $filePath = $row['file_path'];
    $imageUrl = $filePath && file_exists($filePath) ? $filePath : 'assets/no-image.png';

    $data[] = [
        "id" => (int) $row["id"],
        "image_id" => $row["image_id"],
        "date" => $row["date"],
        "orderNumber" => $row["order_or_reference_number"],
        "supplierName" => $row["supplier_name"],
        "supplierAddress" => $row["supplier_address"],
		"supplier_register_name" => $row["supplier_register_name"],
        "supplierTIN" => $row["supplier_tin"],
        "purchaseCategory" => $row["purchase_category"],
		"expense_category" => $row["expense_category"],
        "grossAmount" => $row["gross_purchase_amount"],
        "netAmount" => $row["net_purchase_amount"],
        "inputTax" => $row["input_tax"],
        "vatExempt" => $row["vat_exempt_purchases"],
        "zeroRated" => $row["zero_rated_purchases"],
        "added_at" => $row["added_at"],
        "filename" => $row["file_name"],
        "imageUrl" => $imageUrl
    ];
}

if (empty($data)) {
    echo json_encode([
        "status" => "error",
        "message" => "No records found",
        "page" => $page,
        "limit" => $limit,
        "total" => $total,
        "total_pages" => ceil($total / $limit),
        "data" => []
    ]);
} else {
    echo json_encode([
        "status" => "success",
        "page" => $page,
        "limit" => $limit,
        "total" => $total,
        "total_pages" => ceil($total / $limit),
        "data" => $data
    ]);
}

$conn->close();
?>