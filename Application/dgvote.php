<?php
include 'top.php';
include 'toplinks.php';
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
                                    <h5><i class="fa fa-list-alt text-red"></i> Voters List for District Governor</h5>
                                </div>

                                <div class="box-body">
                                    <?php
                                    $sqlSelect = "SELECT * from poll p LEFT JOIN voterslist v ON(v.ID = p.UserID)  WHERE  p.PositionID = 1 AND v.Status = 1";
                                    $result = mysqli_query($connection, $sqlSelect);
                                    if (!empty($result)) {
                                        ?>

                                        <table class='table table-bordered table-condensed text-center'>
                                            <thead class="bg-red">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>MobileNo</th>
                                                    <th>Club</th>
                                                    <th>VoteCast</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            While ($row = mysqli_fetch_array($result)) {
                                                ?>                  
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $row['Name']; ?></td>
                                                        <td><?php echo $row['Email']; ?></td>
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