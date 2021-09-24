<?php

require_once 'vendor/autoload.php';
require_once 'app/isset.php';

use App\DataHandler;
use App\Validate\CheckValidity;

$validate = new CheckValidity();
$humanRegister = new DataHandler('data/data.csv');
$records = $humanRegister->getCsv()->getRecords();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php

if (isset($_POST['submit'])) {
    if ($validate->checkInsertForm('name', 'surname', 'idNo')) {
        $humanRegister->insert('name', 'surname', 'idNo', 'info');
    }
}
?>

<a href="app/insert.html">Insert</a>

<br><br>
<form action="/" method="get">
    <label for="search">Search by ID number: </label><br>
    <input type="text" name="search" id="search">
</form>

<br><br>
<table>
    <tbody>

    <?php foreach ($humanRegister->getCsv()->getHeader() as $header): ?>
        <th id="header"> <?= $header ?></th>
    <?php endforeach; ?>

    <?php if (isset($_GET['search']) && $_GET['search'] !== '') echo "<th>Delete</th>"; ?>

    </tbody>

    <?php foreach ($records as $record):

        if ($record['idNo'] === $_GET['search'] || !isset($_GET['search']) || $_GET['search'] === ''): ?>

            <tbody>

            <td> <?= $record['name'] ?> </td>
            <td> <?= $record['surname'] ?> </td>
            <td id="idNumber"> <?= $record['idNo'] ?> </td>
            <td> <?= $record['information'] ?> </td>

            <?php if (isset($_GET['search']) && $_GET['search'] !== '') {
                echo "<td><form method='post'><input type='submit' name='delete' id='delete' value='Delete'></form></td>";
            }

            if (isset($_POST['delete'])) {
                $humanRegister->delete($record);
                echo "<b>Record Deleted!</b><br><br>";
            }

            ?>

            </tbody>

        <?php endif; ?>
    <?php endforeach; ?>

</table>

</body>
</html>