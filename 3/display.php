<?php
/**
 * @author: chenxi
 * @date: 2015-08-05
 * @version: $Id$
 */
$dbc = mysqli_connect('localhost', 'root', '123456', 'cms');

$q = 'SELECT longitude, latitude FROM distance_demo';
$r = mysqli_query($dbc, $q);
if(mysqli_num_rows($r) > 0){
    echo '<table border="2" width="90%" cellspacing="3" cellpadding="3" align="center">';
    while(list($longitude, $latitude) = mysqli_fetch_array($r, MYSQLI_NUM)){
        echo '<tr>';
        echo "<td align=\"center\">$longitude</td><td align=\"center\">$latitude</td>";
        echo '</tr>';
    }
    echo '</table>';
}