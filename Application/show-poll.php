<?php
header('Content-Type: application/json');
include('../db.php');
$q = sprintf("SELECT c.PositionName,c.CandidateName,count(p.PollID)PollID FROM `poll` p LEFT JOIN candidates c on (c.CID = p.CandidateID) WHERE p.PollRemarks = 'Yes' GROUP BY p.CandidateID,p.PositionID");
$run = mysqli_query($connection,$q);
$data = array();
while($row = mysqli_fetch_assoc($run)) {
    $data[] = $row;
}

//free memory associated with result
$run->close();

//close connection
$connection->close();

print json_encode($data, JSON_PRETTY_PRINT);
?>

