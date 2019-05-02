<?php
include_once 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$user = new User();
	if (isset($_POST['create'])) {

		//set the member values of user instance
		$user->setUserName($_POST["Id"]);
		$user->setEmail($_POST["Title"]);
		$user->setMobileNo($_POST["ReleaseDate"]);
		$user->setDisability($_POST["Plateform"]);
		//echo $user->getDisability();
		//die;
		$user->setGender($_POST["Publisher"]);
		$hobbies = $_POST["Developer"];

		//setting hobby array
		foreach ($hobbies as $hobby) {
			$user->setHobby($hobby);
		}
		// $user->setDescription($_POST["description"]);

		$user->create();

	} else if (isset($_POST['edit'])) {
		//First Create Conenction instance then pass to it to User instance
		if (!isset($_SESSION)) {
			session_start();
		}
		$_SESSION["id"] = $_POST['id'];
		header("Location: edit.php");
	} else if (isset($_POST["update"])) {

		//set the member values of user instance
		$user->setUserName($_POST["Id"]);
		$user->setEmail($_POST["Title"]);
		$user->setMobileNo($_POST["ReleaseDate"]);
		$user->setDisability($_POST["Plateform"]);
		//echo $user->getDisability();
		//die;
		$user->setGender($_POST["Publisher"]);
		$hobbies = $_POST["Developer"];

		//setting hobby array
		foreach ($hobbies as $hobby) {
			$user->setHobby($hobby);
		}
		$user->setDescription($_POST["description"]);

		$user->update();
	} else if (isset($_POST["delete"])) {

		$user->delete($_POST['user_id']);

	} else {
		echo "Please Fill the Form. ";
	}
}

?>