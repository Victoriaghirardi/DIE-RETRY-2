<?PHP
include_once "connection.php";
class User {
	private $user_id, $name, $email, $mobile_no, $gender, $disability, $description;
	protected $hobbies = array();
	protected $connection;
	public function getUserId() {
		return ($this->user_id);
	}

	public function setUserId($userId) {
		$this->user_id = $userId;
	}

	public function getUserName() {
		return ($this->name);
	}

	public function setUserName($userName) {
		$this->name = $userName;
	}

	public function getEmail() {
		return ($this->email);
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getMobileNo() {
		return ($this->mobile_no);
	}

	public function setMobileNo($mobileNo) {
		$this->mobile_no = $mobileNo;
	}
	public function getGender() {
		return ($this->gender);
	}
	public function setGender($gender) {
		$this->gender = $gender;
	}
	public function getDisability() {
		return ($this->disability);
	}
	public function setDisability($disability) {
		$this->disability = $disability;
	}
	public function getDescription() {
		return ($this->description);
	}
	public function setDescription($description) {
		$this->description = $description;
	}

	public function setHobby($hobby) {
		$this->hobbies[$hobby] = $hobby;
	}
	public function getHobby($hobby) {
		return $this->hobbies[$hobby]; //return the value of hobby
	}

	function create() {
		$this->connection = new Connection();
		$conn = $this->connection->openConnection();

		$insert = $conn->prepare("INSERT INTO `videogames` (`Id`, `Title`, `ReleaseDate`, `idPlatform`, `idPublisher`, `idDeveloper`) VALUES (NULL, :name, :email, :mobile_no, :gender, :disability, :description)");

		try {
			$conn->beginTransaction();
			$result = $insert->execute(array('name' => $this->getUserName(),
				'email' => $this->getEmail(),
				'mobile_no' => $this->getMobileNo(),
				'gender' => $this->getGender(),
				'disability' => $this->getDisability(),
				'description' => $this->getDescription()));

			if ($result) {
				$id = $conn->lastInsertId();

				foreach ($this->hobbies as $hobby) {
					if (!empty($hobby)) {
						$insertHobby = $conn->prepare("INSERT INTO `hobbies` (`hobby_id`, `user_id`, `hobby`) VALUES (NULL,:user_id,:hobby)");

						$resultH = $insertHobby->execute(
							array('user_id' => $id,
								'hobby' => $hobby));
					}
				}
				$conn->commit(); //Saving data permanantly
				echo "<i style='color:green'>User Saved Successfully..! <i>";

			} else {

				echo "<i style='color:red'>There are some problem while saving the Data...! <i>";

			}
		} catch (PDOExecption $e) {
			$conn->rollback();
			print "Error!: " . $e->getMessage() . "</br>";
		}

		$this->connection->closeConnection();

	}

	function read() {

		$this->connection = new Connection();
		$conn = $this->connection->openConnection();

		$read = $conn->prepare("SELECT *FROM videogames");
		$read->execute();

		if ($read->rowCount() > 0) {
			return $read->fetchAll(PDO::FETCH_ASSOC);

		} else {
			echo "<i style='color:red'>No Record Found<i>";
			return (false);
		}

		$this->connection->closeConnection();

	}
	function update() {

		$this->connection = new Connection();
		$conn = $this->connection->openConnection();

		$insert = $conn->prepare("UPDATE `videogames` SET
		 `id`=:id, `Title`=:Title, `ReleaseDate`=:ReleaseDate, `idDeveloper`=:idDeveloper, `idPublisher`=:idPublisher, `idPlatform`=:idPlatform WHERE videogames=:videogames");

		try {
			$conn->beginTransaction();
			$result = $insert->execute(array(
				'id' => $this->getUserId(),
				'Title' => $this->getUserName(),
				'ReleaseDate' => $this->getEmail(),
				'idPlatform' => $this->getMobileNo(),
				'idPublisherd' => $this->getGender(),
				'idDeveloper' => $this->getDisability()));

			if ($result) {
				//$id = $conn->lastInsertId();

				//first delete all hobbies of the user then insert new one
				$delete = $conn->prepare("DELETE from videogames where Title=:Title");
				$delete->execute(
					array('Title' => $this->getUserId()));

				foreach ($this->hobbies as $hobby) {
					if (!empty($hobby)) {

						$insertHobby = $conn->prepare("INSERT INTO `videogames` (`id`, `Title`, `ReleaseDate`, 'idPlatform', 'idPublisher', 'idDeveloper') VALUES (NULL,:id,:videogames)");

						$resultH = $insertHobby->execute(
							array('id' => $this->getUserId(),
								'videogames' => $hobby));
					}
				}
				$conn->commit(); //Saving data permanantly
				echo "<i style='color:green'>User Record Updated Successfully..! <i>";

			} else {

				echo "<i style='color:red'>There are some problem while updating the Data...! <i>";

			}
		} catch (PDOExecption $e) {
			$conn->rollback();
			print "Error!: " . $e->getMessage() . "</br>";
		}

		$this->connection->closeConnection();

	}
	function delete($user_id) {

		$this->connection = new Connection();
		$conn = $this->connection->openConnection();
		//here first we have to delete all hobbies of the user

		try {

			$deleteHobbies = $conn->prepare("DELETE FROM videogames where id=:id");
			$conn->beginTransaction();

			$re = $deleteHobbies->execute(
				array('id' => $id));

			if ($re) {
				//$id = $conn->lastInsertId();

				//first delete all hobbies of the user then insert new one
				$deleteUser = $conn->prepare("DELETE from videogames where id=:id");
				$deleteUser->execute(
					array('id' => $id));

				$conn->commit();
				echo "<i style='color:green'>User Record deleted Successfully..! <i>";

			} else {

				echo "<i style='color:red'>There are some problem while updating the Data...! <i>";

			}
		} catch (PDOExecption $e) {
			$conn->rollback();
			print "Error!: " . $e->getMessage() . "</br>";
		}

		$this->connection->closeConnection();

	}

	function getHobbies($user_id) {
		$this->connection = new Connection();
		$conn = $this->connection->openConnection();

		$read = $conn->prepare("SELECT *FROM videogames where id=:Id");
		$read->execute(array('Id' => $user_id));

		if ($read->rowCount() > 0) {
			return $read->fetchAll(PDO::FETCH_ASSOC);

		} else {
			//echo "<i style='color:red'>No Record Found<i>";
			return (false);
		}

		$this->connection->closeConnection();
	}

	function selectUser($user_id) {
		$this->connection = new Connection();
		$conn = $this->connection->openConnection();

		$read = $conn->prepare("SELECT *FROM users where user_id=:userId");
		$read->execute(array('userId' => $user_id));

		if ($read->rowCount() > 0) {
			return $read->fetch(PDO::FETCH_ASSOC);

		} else {
			//echo "<i style='color:red'>No Record Found<i>";
			return (false);
		}

		$this->connection->closeConnection();

	}

}
?>