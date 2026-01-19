<?php
require_once __DIR__ . '/../../db.php';

function getAllEmployees()
{
    global $pdo;
    return $pdo->query("SELECT * FROM employees")
               ->fetchAll(PDO::FETCH_ASSOC);
}

function getEmployeeById($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insertEmployee($name, $title, $skills)
{
    global $pdo;
    $stmt = $pdo->prepare(
        "INSERT INTO employees (name, title, skills) VALUES (?, ?, ?)"
    );
    $stmt->execute([$name, $title, $skills]);
}

function updateEmployee($id, $name, $title, $skills)
{
    global $pdo;
    $stmt = $pdo->prepare(
        "UPDATE employees SET name = ?, title = ?, skills = ? WHERE id = ?"
    );
    $stmt->execute([$name, $title, $skills, $id]);
}

function deleteEmployee($id)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->execute([$id]);
}
