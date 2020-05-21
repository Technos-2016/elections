<?php
include 'top.php';
include 'toplinks.php';
?>
<link href="../plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
<style>
    .activate:hover{
        background-color: #01ff70;
    }
    .inactive:hover{
        background-color: #CCCCCC;
    }
</style>
<body class="hold-transition skin-red layout-top-nav">
    <div class="wrapper">
        <?php include_once 'topheader.php'; ?>
        <!-- Full Width Column -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <section class="content-header">
                    <h1>
                        Manage Position
                        <small>Create Position</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo CURADDRESS; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Voting Position</li>
                    </ol>
                </section>

                <?php
                error_reporting(1);
                if (isset($_POST['UpdatePosition'])) {
                    $pid = mysqli_real_escape_string($connection, $_POST['pid']);
                    $upname = mysqli_real_escape_string($connection, $_POST['upname']);
                    $umulti = mysqli_real_escape_string($connection, $_POST['umulti']);
                    $update = "UPDATE position SET Name = '$upname',AllowMulti='$umulti' WHERE PID = '$pid'";
                    $checkupdate = mysqli_query($connection, $update) or die(print_r(mysqli_error($connection)));
                    if ($checkupdate == true) {
                        $umsg = "Position has been Updated";
                    } else {
                        $uerror = "Error while Updating the Position..";
                    }
                }

                if (isset($_POST['AddPosition'])) {
                    $pname = mysqli_real_escape_string($connection, $_POST['pname']);
                    $multi = mysqli_real_escape_string($connection, $_POST['multi']);
                    $insert = "INSERT INTO position(Name,AllowMulti)VALUES('$pname','$multi')";
                    $checkinsert = mysqli_query($connection, $insert) or die(mysqli_error($connection));
                    if ($checkinsert == true) {
                        $msg = "Position has been added";
                    } else {
                        mysqli_rollback($connection);
                        $error = "Error while adding the Position..";
                    }
                }
                ?>

                <section class="content">
                    <div class="row">
                        <?php
                        if (isset($_GET['editid'])) {
                            $usql = mysqli_query($connection, "select * from position WHERE PID = '" . $_GET['editid'] . "'");
                            $uprow = mysqli_fetch_assoc($usql);
                            ?>
                            <div class="col-lg-3 col-md-4 col-xs-12">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h5><i class="fa fa-edit text-red"></i> UPDATE POSITION</h5>
                                        <div class="box-tools">
                                            <?php
                                            if (isset($umsg)) {
                                                echo "<span class='text-success pull-right'>$umsg</span>";
                                                echo "<script>setTimeout(\"location.href = 'position.php';\",2000);</script>";
                                            } else if (isset($uerror)) {
                                                echo "<span class='text-warning pull-right'>$uerror</span>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <form   action="" method="POST" >
                                        <div class="box-body">
                                            <input type="hidden" name="pid"  id="pid" class="form-control" value="<?php echo $uprow['PID']; ?>">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Candidate Name</label>
                                                    <input type="text" name="upname"  id="upname" class="form-control" required value="<?php echo $uprow['Name']; ?>" >
                                                </div>
                                               
                                                <div class="form-group">
                                                    <label>Select Value</label>
                                                    <select name="umulti" id="umulti" class="form-control select2" required >
                                                        <option value="">Please Select Value</option>
                                                        <option value="1" <?php if($uprow['AllowMulti'] == 1){echo "selected";}?> >Allow Multiple</option>
                                                        <option value="0" <?php if($uprow['AllowMulti'] == 0){echo "selected";}?>>Allow Single</option>
                                                    </select>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" name="UpdatePosition" class="btn btn-sm bg-blue pull-right"><i class="fa fa-arrow-up"></i> Update Position</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="col-lg-3 col-md-4 col-xs-12">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h5><i class="fa fa-plus-square-o text-red"></i> Create Position</h5>
                                        <div class="box-tools">
                                            <?php
                                            if (isset($msg)) {
                                                echo "<span class='text-success pull-right'>$msg</span>";
                                                echo "<script>setTimeout(\"location.href = 'position.php';\",3000);</script>";
                                            } else if (isset($error)) {
                                                echo "<span class='text-warning pull-right'>$error</span>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <form   action="" method="POST" >
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Position Name</label>
                                                    <input type="text" name="pname"  id="pname" class="form-control" required  placeholder="Enter Position Name">
                                                </div>

                                                <div class="form-group">
                                                    <label>Select Value</label>
                                                    <select name="multi" id="multi" class="form-control select2" required >
                                                        <option value="">Please Select Value</option>
                                                        <option value="1" >Allow Multiple</option>
                                                        <option value="0" >Allow Single</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" name="AddPosition" class="btn btn-sm bg-red pull-right"><i class="fa fa-save"></i> Add Position</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                        }
                        ?>


                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-solid">
                                <div class="box-header">
                                    <span class="text-bold" ><i class="fa fa-info text-red"></i> Candidate List</span>
                                </div>
                                <div class="box-body" >
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-condensed text-center">
                                            <thead class="bg-red">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Position</th>
                                                    <th>AllowMulti</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $queryi = mysqli_query($connection, "select * from position") or die(mysqli_error($connection));
                                                while ($rowi = mysqli_fetch_assoc($queryi)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $rowi['PID']; ?></td>
                                                        <td><?php echo $rowi['Name']; ?></td>
                                                        <td><?php echo $rowi['AllowMulti']; ?></td>
                                                        <td>
                                                            <a href="position.php?editid=<?php echo $rowi['PID']; ?>" class="btn btn-xs btn-flat text-red" title="Edit Position"><i class="fa fa-edit"></i> Edit</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

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
    <script src="../plugins/select2/select2.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $(".select2").select2();
        });


    </script>
</body>
</html>