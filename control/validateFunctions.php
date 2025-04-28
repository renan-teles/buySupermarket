<?php
//Validate Functions
function validateName(string $name): bool
{
    return preg_match("/^[A-Za-zÀ-ÿ\s]{3,}$/", $name);
}

function validateEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL)? true : false;
}

function validatePassword(string $password): bool
{
    return strlen($password) >= 7 && !empty($password);
}

function validateAction(string $currentAction, array $actionsNames): bool
{
    if (!$currentAction) 
    {
        return false;
    }
    if (!in_array($currentAction, $actionsNames)) 
    {
        return false;
    }
    return true;
}

function sanitizeFloat(?string $value): float
{
    if (is_null($value)) {
        return 0.0;
    }

    $value = str_replace('.', '', $value);
    $value = str_replace(',', '.', $value);

    if (is_numeric($value)) {
        return floatval($value);
    }

    return 0.0;
}

function validateLogin(): void
{
    if(!isset($_SESSION['userData']))
    {
        header('Location: ../../index.php');
        exit;
    }
}

function showMessage(): void
{
    if (isset($_SESSION['msg-errors'])) 
    {
        foreach ($_SESSION['msg-errors'] as $error) {
            echo "<div class='alert alert-danger text-center' role='alert'><i class='bi-exclamation-triangle-fill me-2'></i>$error</div>"; 
        }
        unset($_SESSION['msg-errors']);
    }
    if (isset($_SESSION['msg-success'])) 
    {
        $msg = $_SESSION['msg-success'];
        echo "<div class='alert alert-success text-center' role='alert'><i class='bi-check-circle-fill me-2'></i>$msg</div>"; 
        unset($_SESSION['msg-success']);
    }
}