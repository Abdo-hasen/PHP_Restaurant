<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "restaurant_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["save_supplier"])) {
       
        $supplier_id = isset($_POST["supplier_id"]) && $_POST["supplier_id"] !== "" ? $_POST["supplier_id"] : null;
        $supplier_name = trim($_POST["supplier_name"]);
        $contact_email = trim($_POST["contact_email"]);
        $phone = trim($_POST["phone"]);

        if ($supplier_id) {
            
            $stmt = $conn->prepare("UPDATE suppliers SET supplier_name=?, contact_email=?, phone=? WHERE supplier_id=?");
            $stmt->bind_param("sssi", $supplier_name, $contact_email, $phone, $supplier_id);
        } else {
            
            $stmt = $conn->prepare("INSERT INTO suppliers (supplier_name, contact_email, phone) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $supplier_name, $contact_email, $phone);
        }

        $stmt->execute();
        $stmt->close();
    }

    if (isset($_POST["delete_supplier"])) {
        $supplier_id = $_POST["supplier_id"];
        $stmt = $conn->prepare("DELETE FROM suppliers WHERE supplier_id = ?");
        $stmt->bind_param("i", $supplier_id);
        $stmt->execute();
        $stmt->close();
    }
}


$suppliers = $conn->query("SELECT * FROM suppliers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Suppliers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2 class="text-center mb-4">Supplier Management</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Supplier Name</th>
                <th>Contact Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="supplierTable">
            <?php while ($row = $suppliers->fetch_assoc()): ?>
                <tr id="supplier-<?= $row['supplier_id']; ?>">
                    <td><?= htmlspecialchars($row['supplier_name']); ?></td>
                    <td><?= htmlspecialchars($row['contact_email']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editSupplier(<?= $row['supplier_id']; ?>, '<?= htmlspecialchars($row['supplier_name']); ?>', '<?= htmlspecialchars($row['contact_email']); ?>', '<?= htmlspecialchars($row['phone']); ?>')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSupplier(<?= $row['supplier_id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    
    <div class="card p-4">
        <h3 id="formTitle">Add New Supplier</h3>
        <form id="supplierForm" method="POST">
            <input type="hidden" name="supplier_id" id="supplier_id">
            
            <label>Supplier Name:</label>
            <input type="text" name="supplier_name" id="supplier_name" class="form-control" required><br>
            
            <label>Contact Email:</label>
            <input type="email" name="contact_email" id="contact_email" class="form-control" required><br>
            
            <label>Phone:</label>
            <input type="text" name="phone" id="phone" class="form-control" required><br>
            
            <button type="submit" name="save_supplier" class="btn btn-primary">Save Supplier</button>
            <button type="button" class="btn btn-secondary" onclick="resetForm()">Cancel</button>
        </form>
    </div>

    <script>
        function editSupplier(id, name, email, phone) {
            document.getElementById("formTitle").innerText = "Edit Supplier";
            document.getElementById("supplier_id").value = id;
            document.getElementById("supplier_name").value = name;
            document.getElementById("contact_email").value = email;
            document.getElementById("phone").value = phone;
        }

        function deleteSupplier(id) {
            if (!confirm("Are you sure you want to delete this supplier?")) return;

            let row = document.getElementById(`supplier-${id}`);
            row.remove();

            let form = document.createElement("form");
            form.method = "POST";
            form.action = "";

            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "supplier_id";
            input.value = id;

            let deleteInput = document.createElement("input");
            deleteInput.type = "hidden";
            deleteInput.name = "delete_supplier";
            deleteInput.value = "1";

            form.appendChild(input);
            form.appendChild(deleteInput);
            document.body.appendChild(form);
            form.submit();
        }

        function resetForm() {
            document.getElementById("formTitle").innerText = "Add New Supplier";
            document.getElementById("supplier_id").value = "";
            document.getElementById("supplier_name").value = "";
            document.getElementById("contact_email").value = "";
            document.getElementById("phone").value = "";
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
