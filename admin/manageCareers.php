<?php
require_once "../db.php";

echo "action=".$_POST["action"]."id=".$_POST["id"];

switch ($_POST['action'])
{
	case 'add':
		$database->addCareer($_POST['name'], $_POST['location'], $_POST['maxStudents']);
	break;
	
	case 'del':
		$database->removeCareer($_POST['id']);
	break;
}


$careers = $database->getCareers();
?>
<table class="centered" id="info" border="1">
		<tr>
			<td><span class="columnHeader">Name</span></td>
			<td><span class="columnHeader">Location</span></td>
			<td><span class="columnHeader">Limit</span></td>
			<td><span class="columnHeader">Actions</span></td>
		</tr>
<?php
foreach ( $careers as $career )
{
?>
	<tr>
		<form>
			<input type="hidden" name="action" value="del">
			<input type="hidden" name="id" value="<?php echo $career['id']; ?>">
			<td><?php echo $career['name']; ?></td>
			<td><?php echo $career['location']; ?></td>
			<td><?php echo $career['maxStudents']; ?></td>
			<td><button type="button" onclick="deleteCareer(<?php echo $career['id']; ?>)">Delete</button></td>
		</form>
	</tr>
<?php
}
?>
	<tr>
		<form>
			<input type="hidden" name="action" value="add">
			<input type="hidden" name="id" value="<?php echo $career['id']; ?>">
			<td><input type="text" name="name" class="tableInput"></td>
			<td><input type="text" name="location" class="tableInput"></td>
			<td><input type="text" name="maxStudents" class="tableInput"></td>
			<td><input type="submit" value="Add" class="tableInput"></td>
		</form>
	</tr>
</table>