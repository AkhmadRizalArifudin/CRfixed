<?php
include "functions.php";
session_start();
$token = filter_input(INPUT_POST, 'token', FILTER_UNSAFE_RAW);
// var_dump($_SESSION['user']);
if (!isset($_SESSION['user']) && (!$token || $token !== $_SESSION['token'])) {
    header("location: login.php");
} else {
    $pdo = pdo_connect();
    $stmt = $pdo->prepare('SELECT * FROM contacts');
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <?= style_script() ?>
        <script>
            $(document).ready(function() {
                $('#employee').DataTable();
            });
        </script>

        <title>Dashboard</title>
    </head>

    <body>
        <div class="container">
            <h2>Dashboard</h2>
            <div class="row">
                <div class="col">
                    <a type="button" class="btn btn-primary create-contact" href="create.php">Create Contact</a>
                    <a type="button" class="btn btn-danger float-right" href="logout.php">Sign out</a>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col">
                    <table class="table table-striped" id="employee">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Title</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contacts as $contact) : ?>
                                <tr>
                                    <td><?= $contact['id'] ?></td>
                                    <td><?= $contact['name'] ?></td>
                                    <td><?= $contact['email'] ?></td>
                                    <td><?= $contact['phone'] ?></td>
                                    <td><?= $contact['title'] ?></td>
                                    <td><?= $contact['created'] ?></td>
                                    <td class="actions">
                                        <a type="button" class="btn btn-sm btn-outline btn-success" href="update.php?id=<?= $contact['id'] ?>" class="edit">edit</a>
                                        <a type="button" class="btn btn-sm btn-outline btn-danger" href="delete.php?id=<?= $contact['id'] ?>" class="trash" onclick="return confirm('Are you sure you want to delete this item?');">delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Title</th>
                                <th>Created</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-center">
            <p class="mt-5 mb-3 text-muted">hk &copy; 2021</p>
        </div>
    </body>

    </html>
<?php } ?>