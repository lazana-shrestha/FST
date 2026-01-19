<?php
require_once __DIR__ . '/../models/employee.php';

function handleEmployeeRequest() {

    $action = $_GET['action'] ?? 'index';

    if ($action === 'store') {
        insertEmployee($_POST['name'], $_POST['title'], $_POST['skills']);
        header("Location: index.php");
        exit;
    }

    if ($action === 'update') {
        updateEmployee($_POST['id'], $_POST['name'], $_POST['title'], $_POST['skills']);
        header("Location: index.php");
        exit;
    }

    if ($action === 'delete') {
        deleteEmployee($_GET['id']);
        header("Location: index.php");
        exit;
    }

    if ($action === 'edit') {
        return [
            'view' => 'employee.edit',
            'employee' => getEmployeeById($_GET['id'])
        ];
    }

    if ($action === 'create') {
        return ['view' => 'employee.create'];
    }

    return [
        'view' => 'employee.index',
        'employees' => getAllEmployees()
    ];
}