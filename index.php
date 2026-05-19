<?php
// Core Controller Entry Mappings Router Configuration
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/CheckoutController.php';
require_once __DIR__ . '/controllers/AdminOrderController.php';

$action = $_GET['action'] ?? 'login';

switch ($action) {
    case 'get_customer_history_json':
        $checkout = new CheckoutController();
        $checkout->getHistoryJSON();
        break;

    case 'login':
        $auth = new AuthController();
        $auth->login();
        break;

    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;

    case 'checkout':
        $checkout = new CheckoutController();
        $checkout->showCheckoutPage();
        break;

    case 'submit_checkout':
        $checkout = new CheckoutController();
        $checkout->submitCheckout();
        break;

    case 'confirmation':
        $checkout = new CheckoutController();
        $checkout->showConfirmation();
        break;

    case 'history':
        $checkout = new CheckoutController();
        $checkout->showPurchaseHistory();
        break;

    case 'admin_orders':
        $admin = new AdminOrderController();
        $admin->showOrders();
        break;

    case 'admin_update_status':
        $admin = new AdminOrderController();
        $admin->updateStatus();
        break;

    default:
        header("Location: index.php?action=login");
        exit();
}