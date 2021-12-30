<?php
use School\SchoolClassTable;

require realpath(__DIR__ . '/../../vendor') .'/autoload.php';

$baseUrl = '/view/schoolclass/';

foreach(SchoolClassTable::getInstance()->getAll() as $row):
?>
<tr>
<td><a href="<?=$baseUrl?>edit.php?code=<?=$row->code?>"><?=$row->code?></a></td>
<td><?=$row->name?></td>
<td><a href="<?=$baseUrl?>delete.php?code=<?=$row->code?>">Remove</a></td>
</tr>
<?php
endforeach;