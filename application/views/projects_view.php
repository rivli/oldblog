<h1>Projects</h1>
<p>
<?php
echo '<center>';
$id=1;
	foreach($data as $row)
	{
		echo '<div class="game">
    <table cellspacing="0">
    <tr><td><a href="#" class="urezann">
    '.$row['Gun'].'</div></td></tr>
    <tr><td>'.$row['Skin_name'].'</td></tr>
    <tr><td><img src="'.$row['logo'].'" alt="" width="100%"></td></tr>
    <tr><td>'.$row['price'].'</td></tr>
    <tr>
      <td><div  title="One Place Price" style="display:inline-block;">'.$row['oneplaceprice'].'</div><div style="float:right;">'.$row['places'].'/100</div></td>
    </tr>
    </table>
    </div>';
    $id++;
	}
  echo "</center>";
?>
</p>
