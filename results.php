<?php
/**
 * Created by PhpStorm.
 * User: Spark
 * Date: 02.05.2019
 * Time: 14:43
 */

$searchQuery='https://api.github.com/search/repositories?q=';

$search = json_decode($_POST['searchform'], true);
for ($i=0;$i<sizeof($search);$i+=3){
    $op =$search[$i+1]['value']=='='?'':$search[$i+1]['value'];
    $searchQuery.=$search[$i]['value'].":".$op.$search[$i+2]['value']."+";
}
// на випадок висилання даних формою, а не JSON
//for ($i=0;$i<sizeof($_POST['type']);$i++){
//    $op =$_POST['operator'][$i]=='='?'':$_POST['operator'][$i];
//    $searchQuery.=$_POST['type'][$i].":".$op.$_POST['value'][$i]."+";
//}

$returnTable = "<table class='GHtable'><thead>
<tr>
<th>
Name
</th>
<th>
Repo Link
</th>
<th>
Size
</th>
<th>
Stars
</th>
<th>
Forks
</th>
<th>
Followers
</th>
</tr></thead>";
$curl = curl_init($searchQuery);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt( $curl, CURLOPT_USERAGENT, 'curl/' . $curl['version'] );
$data = curl_exec($curl);
$datasearch = json_decode($data, true);
foreach ($datasearch['items'] as $item){
    $returnTable.= "<tr><td>".$item['name']."</td><td><a href='{$item['html_url']}'>Repo link</a></td><td>{$item['size']}</td><td>{$item['stargazers_count']}</td><td>{$item['forks']}</td><td>{$item['watchers']}</td></tr>";
}
$returnTable.="</table>";
print $returnTable;
curl_close($curl);

