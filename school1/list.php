<?php
use School\SchoolClass;

require 'vendor/autoload.php';

foreach(SchoolClass::getAll() as $row):
?>
<tr>
<td><a href="edit.php?code=<?=$row['code']?>"><?=$row['code']?></a></td>
<td><?=$row['name']?></td>
<td><a href="delete.php?code=<?=$row['code']?>">Remove</a></td>
</tr>
<?php
endforeach;