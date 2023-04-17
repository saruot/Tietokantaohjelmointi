<?php

    require_once './includes.php';

    $invoice_id = ''; // Tähän määriteltäisiin frontendistä tai jostain muualta poistettava ID joka haettaisiin esim $_POST['parametri'] metodilla ja määriteltäisiin muuttujaan.

    $conn = openDb();


    $sql = "DELETE FROM invoice_items WHERE InvoiceLineId = :invoice_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':invoice_id', $invoice_id);

    if ($stmt->execute()) {
        // If the invoice items are deleted successfully, delete the invoice
        $sql = "DELETE FROM invoices WHERE InvoiceId = :invoice_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':invoice_id', $invoice_id);

        if ($stmt->execute()) {
            echo "Invoice deleted successfully";
        } else {
            echo "Invoice not deleted";
        }
    } else {
        echo "Invoice items not deleted";
    }

    // Close connection
    $conn = null;