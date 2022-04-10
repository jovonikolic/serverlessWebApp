<?php
echo "Hello World! This is my web app \n";
$serverName = "mysqldatabasebac1.mysql.database.azure.com";
$username = "testadmin";
$password = "Test123!";
$errors = null;

$dbconn = new mysqli($serverName, $username, $password, "db1");
mysqli_set_charset($dbconn, "UTF8");

if ($dbconn->connect_error) {
    die("Connection failed: " . $dbconn->connect_error);
} else {
    echo "Connection successful";
}

if (isset($_POST['submit'])) {
    if (empty($_POST['todo'])) {
        $errors = "No input in todo";
    } else {
        $todo = $_POST['todo'];
        $postQuery = "INSERT INTO todos (description) VALUES( '" . $todo . "')";
        var_dump($postQuery);
        mysqli_query($dbconn, $postQuery);
        header('location: todo.php');
    }
}
if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];
    $deleteQuery = "DELETE FROM todos WHERE id = " . $id;

    mysqli_query($dbconn, $deleteQuery);
    header('location: todo.php');
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <title>TODO List</title>
    <link rel="stylesheet" type="text/css" href="styling.css">
</head>
<body>
<div class="header">
    <h2>Manage your todo's</h2>
</div>
<form method="post" action="todo.php" class="input_form">
    <input type="text" name="todo" class="todo_input">
    <button type="submit" name="submit" id="add_btn" class="add_btn">Add Todo</button>
</form>
<!-- DISPLAYING THE TODOS !-->
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Description</th>
        <th style="width: 1rem;">Action</th>
    </tr>
    </thead>

    <tbody>
    <?php
    $todos = mysqli_query($dbconn, "SELECT * FROM todos");
    for($i = 1; $row = mysqli_fetch_array($todos); $i++) {
        ?>
        <tr>
            <td> <?php echo $i; ?> </td>
            <td class="todo"> <?php echo $row['description']; ?> </td>
            <td class="delete">
                <a href="todo.php?del_task=<?php echo $row['id'] ?>">x</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
<?php if (isset($errors)) { ?>
    <p><?php echo $errors; ?></p>
<?php } ?>
