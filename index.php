<?php 
	$update = false;
	//intialize errors variable
	$errors ="";
	$task="";
	$id = 0;

	//connection.
	$db = mysqli_connect('localhost', 'root', 'nithin@123N', 'todo_list');


	//on submit insert 
	if (isset($_POST['submit'])) 
	{
		if(empty($_POST['Task']))
		{
			$errors = "You must fill in the task";
		}
		else
		{
			$task = $_POST['Task'];
			mysqli_query($db, "INSERT INTO task (Task) VALUES ('$task')");
			$_SESSION['message'] = "TASK SAVED"; 
			//header('location: index.php');
		}	
	}

	
	//delete
	if (isset($_GET['del'])) 
	{
		$id = $_GET['del'];
		mysqli_query($db, "DELETE FROM task WHERE id=$id"); 
		$_SESSION['message'] = "TASK DELETED SUCCESSFULLY";
		//header('location: index.php');
	}

	//EDIT
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM task WHERE id=$id");

		if ($record -> num_rows == 1 ) {
			$n = mysqli_fetch_array($record);
			$task = $n['Task'];
			$_SESSION['message'] = "TASK FETCHED SUCCESSFULLY";
		}
	}

	 //update
	 if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $task = $_POST['Task'];
    
        mysqli_query($db, "UPDATE task SET `Task`='$task' WHERE `id`=$id");
		//header('location: index.php');
		$_SESSION['message'] = "TASK UPDATED SUCCESSFULLY";
    }


?>
   

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
	<title>CRUD: CReate, Update, Delete PHP MySQL</title>
</head>
<body>
	<?php if (isset($_SESSION['message'])): ?>
		<div class="msg">
			<?php 
				echo $_SESSION['message']; 
				unset($_SESSION['message']);
			?>
		</div>
	<?php endif ?>
    <!---form-->
    <form method="post" action="index.php" >
		<div class="input-group">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<label>Task:</label>
			<input type="text" name="Task" value="<?php echo $task; ?>">
		</div>
		
		<div class="input-group">
			<?php if ($update == true): ?>
                <button class="btn" type="submit" name="update" style = "background-color:blue">update</button>
            <?php else: ?>
				<button class="btn" type="submit" name="submit" style = "background-color:green">Add Task</button>
			<?php endif ?>
		</div>
	</form>

    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th >Task</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        
        <?php 
            $results = mysqli_query($db, "SELECT * FROM task"); 
            $i = 1;while ($row = mysqli_fetch_array($results)) { ?>
            <tr>
                <td> <?php echo $i; ?> </td>
                <td><?php echo $row['Task']; ?></td>
				<td>
				    <a href="index.php?edit=<?php echo $row['id']; ?>" class="edit_btn" style="background-color:rgba(255, 99, 71, 0.5);color:black;">Edit</a>
			    </td>
                <td>
                    <a href="index.php?del=<?php echo $row['id']; ?>" class="del_btn">Delete</a>
                </td>
            </tr>
        <?php $i++; } ?>
    </table>

</body>
</html>