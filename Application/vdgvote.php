<?php
error_reporting(1);
include 'top.php';
include 'toplinks.php';
$pid = $_GET['pid'];
?>
<body class="hold-transition skin-red layout-top-nav">
    <div class="wrapper">
        <?php include_once 'topheader.php'; ?>
        <!-- Full Width Column -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <section class="content-header">
                    <h1>
                        Create Voters
                        <small>Upload Voters</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo CURADDRESS; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Voters List</li>
                    </ol>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h5>
                                        <i class="fa fa-list-alt text-red"></i>
                                        <?php
                                        if ($pid == 1) {
                                            echo "Voters List of District Governor";
                                        }
                                        if ($pid == 2) {
                                            echo "Voters List of First Vice District Governor";
                                        } else if ($pid == 3) {
                                            echo "Voters List of Second Vice District Governor";
                                        }
                                        ?>
                                    </h5>
                                </div>

                                <div class="box-body">
                                    <?php
                                    if ($pid) {
                                        $sqlSelect = "SELECT * from poll p LEFT JOIN voterslist v ON(v.ID = p.UserID)   WHERE  p.PositionID = '$pid' AND p.PollRemarks = 'Yes' AND v.Status = 1";
                                    } else {
                                        $sqlSelect = "SELECT * from poll p LEFT JOIN voterslist v ON(v.ID = p.UserID)   WHERE   v.Status = 1 AND p.PollRemarks = 'Yes'";
                                    }
                                    $result = mysqli_query($connection, $sqlSelect);
                                    if (!empty($result)) {
                                        ?>

                                        <table class='table table-bordered table-condensed text-center'>
                                            <thead class="bg-red">
                                                <tr>
                                                    <th>Photo</th>
                                                    <th>CandidateName</th>
                                                    <th>VoterName</th>
                                                    <th>MobileNo</th>
                                                    <th>Club</th>
                                                    <th>Vote Cast</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            While ($row = mysqli_fetch_array($result)) {
                                                $sql = mysqli_query($connection, "select * from candidates where CID = '" . $row['CandidateID'] . "'");
                                                $row2 = mysqli_fetch_array($sql);
                                                ?>                  
                                                <tbody>
                                                    <tr>
                                                        <td><img src="../dist/<?php echo $row2['Photo']; ?>" alt="Candidate Image" class="img img-rounded" width="50"/></td>
                                                        <td><?php echo $row2['CandidateName']; ?></td>
                                                        <td><?php echo $row['Name']; ?></td>
                                                        <td><?php echo $row['Mobile']; ?></td>
                                                        <td><?php echo $row['Club']; ?></td>
                                                        <td><?php
                                                            if ($row['Status'] == 0) {
                                                                echo "NO";
                                                            } else {
                                                                echo "Yes";
                                                            }
                                                            ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                    ?>
                                </div>

                            </div>


                        </div>
                    </div>
                </section>

            </div>
        </div>
        <?php include 'footerbottom.php'; ?>
    </div>
    <?php include 'bottomlinks.php'; ?>
</body>
</html>