<?php
require_once '../config/koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['items']) || empty($input['name']) || empty($input['phone']) || empty($input['address'])) {
        echo json_encode(['success' => false, 'message' => 'Lengkapi seluruh data pemesanan!']);
        exit;
    }

    $name = $conn->real_escape_string($input['name']);
    $phone = $conn->real_escape_string($input['phone']);
    $address = $conn->real_escape_string($input['address']);
    $payment = $conn->real_escape_string($input['payment']);
    
    $total_amount = 0;
    foreach ($input['items'] as $item) {
        $total_amount += $item['price'] * $item['qty'];
    }

    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_phone, customer_address, payment_method, total_amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $name, $phone, $address, $payment, $total_amount);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        $stmt->close();

        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($input['items'] as $item) {
            $p_id = (int)$item['id'];
            $p_name = $item['name'];
            $p_price = (float)$item['price'];
            $p_qty = (int)$item['qty'];
            $subtotal = $p_price * $p_qty;

            $stmt_item->bind_param("iisdid", $order_id, $p_id, $p_name, $p_price, $p_qty, $subtotal);
            $stmt_item->execute();
        }
        $stmt_item->close();

        echo json_encode(['success' => true, 'order_id' => $order_id, 'message' => 'Pesanan berhasil disimpan ke database phpMyAdmin!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan pesanan: ' . $conn->error]);
    }
}
?>