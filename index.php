
<?PHP
include_once "User.php";

$user = new User();
$data = $user->read();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Read operation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>


<div class="container">
  <img src="logo.jpg">
  <h2>List of Users</h2>

  <div ><a href="create.php" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Create New User</a></div>
  <form  method="get" action="search.php">
      <table border="1" class="tablesearch">
    <tr>
      <th>
      <input name="var1" type="text" id="var1">
      <input type="submit" value="search"></th>
    </tr>
  </table>
</form>
  <table class="table table-striped table-responsive">
    <thead>
      <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Release Date</th>
        <th>Plateform</th>
        <th>Publisher</th>
        <th>Developer</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $row) {
	?>
   <tr>
    <form name="userForm" <?php echo $row['id']; ?> role="form" method="POST" action="UserController.php">
    <input type="hidden" name="user_id" value=""<?php echo $row['id']; ?>">
    <td><?php echo $row["id"] ?></td>
    <td><?php echo $row["Title"] ?></td>
    <td><?php echo $row["ReleaseDate"] ?></td>
    <td><?php echo $row["idPlatform"] ?></td>
    <td><?php echo $row["idPublisher"] ?></td>
     <td><?php echo $row["idDeveloper"] ?></td>

    <td><?php $hobbies = $user->getHobbies($row['id']);

	if ($hobbies != NULL) {

		foreach ($hobbies as $hobby) {
			echo $hobby['id'] . ", ";
		}
	}

	?>


     </td>
     <td>
      <?php echo $row["description"]; ?>
     </td>
    <td>
      <button type="submit" id="edit"  name="edit" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</button>
      <button type="submit" id="delete"  name="delete" class="btn btn-danger"><span class="glyphicon glyphicon-trash"> Delete </span></button>
    </td>
  </form>
   </tr>

<?php
}?>
    </tbody>
  </table>
</div>

</body>
</html>
