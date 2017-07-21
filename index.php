<?php
$type=$_GET['type'];
?>
<form style="margin-top:50px; " name="form2" method="post" enctype="multipart/form-data" action="a.php">
<input type="hidden" name="leadExcel" value="true">
<table align="center" width="90%" border="0">
<tr>
   <td>
    <input type="file" name="inputExcel"><input type="submit" name="import" value="导入数据">
       <input type="hidden" name="type" value="<?=$type?>" />
   </td>
</tr>
</table>
</form>