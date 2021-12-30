<?php
use School\StudentTable;

require realpath(__DIR__ . '/../../vendor') .'/autoload.php';

$baseUrl = '/view/student/';

foreach(StudentTable::getInstance()->getAll() as $row):
?>
<tr>
<td><a href="<?=$baseUrl?>edit.php?id=<?=$row->id?>"><?=$row->id?></a></td>
<td><?=$row->name?></td>
<td><?=$row->schoolClass->name?></td>
<td><a href="<?=$baseUrl?>delete.php?id=<?=$row->id?>">Remove</a></td>
</tr>
<?php
endforeach;