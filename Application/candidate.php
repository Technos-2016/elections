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
                        Manage Candidate
                        <small>Create Candidate</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo CURADDRESS; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Voting Candidate</li>
                    </ol>
                </section>

                <?php
                error_reporting(1);

                function compressImage($source, $destination, $quality) {
                    $info = getimagesize($source);
                    if ($info['mime'] == 'image/jpeg')
                        $image = imagecreatefromjpeg($source);
                    elseif ($info['mime'] == 'image/gif')
                        $image = imagecreatefromgif($source);
                    elseif ($info['mime'] == 'image/png')
                        $image = imagecreatefrompng($source);
                    imagejpeg($image, $destination, $quality);
                }

                if (isset($_POST['UpdateCan'])) {
                    $dir = "../dist/img/";
                    $cid = mysqli_real_escape_string($connection, $_POST['cid']);
                    $ucname = mysqli_real_escape_string($connection, $_POST['ucname']);
                    $upname = mysqli_real_escape_string($connection, $_POST['upname']);
                    $posuid = mysqli_real_escape_string($connection, $_POST['posuid']);

                    $multi = mysqli_real_escape_string($connection, $_POST['multi']);

                    $sqlcheck = mysqli_query($connection, "select count(*)total from candidates where PositionID = '$posuid'");
                    $getcount = mysqli_fetch_array($sqlcheck);
                    if ($getcount['total'] == 1 AND $multi == 0) {
                        $uerror = "You Cannot Update Candidate to other Position";
                    } else {
                        $previmg = $_POST['img'];
                        $image = $_FILES['uimage']['name'];
                        $valid_ext = array('png', 'jpeg', 'jpg');
                        $pathdb = "img/$image";
                        $path = $dir . $image;
                        $file_extension = pathinfo($path, PATHINFO_EXTENSION);
                        $file_extension = strtolower($file_extension);
                        $tmp_name = $_FILES['uimage']['tmp_name'];
                        mysqli_autocommit($connection, FALSE);

                        if ($_FILES['uimage']['size'] == 0) {
                            $update = "UPDATE candidates SET CandidateName = '$ucname',PositionID='$posuid',PositionName = '$upname' WHERE CID = '$cid'";
                        } else {
                            if (in_array($file_extension, $valid_ext)) {
                                compressImage($tmp_name, $path, 60);
                                unlink($previmg);
                            } else {
                                $uerror = "Invalid file type.";
                            }
                            $update = "UPDATE candidates SET CandidateName = '$ucname', Photo = '$pathdb',PositionID='$posuid',PositionName = '$upname' WHERE CID = '$cid'";
                        }
                        $checkupdate = mysqli_query($connection, $update) or die(print_r(mysqli_error($connection)));
                        if ($checkupdate == true) {
                            mysqli_commit($connection);
                            $umsg = "Candidate has been Updated";
                        } else {
                            mysqli_rollback($connection);
                            $uerror = "Error while Updating the Candidate..";
                        }
                    }
                }



                if (isset($_POST['AddCandidate'])) {
                    $dir = "../dist/img/";
                    If (!is_dir($dir)) {
                        mkdir($dir);
                        chmod($dir, 0777);
                    }

                    $cname = mysqli_real_escape_string($connection, $_POST['cname']);
                    $pname = mysqli_real_escape_string($connection, $_POST['pname']);
                    $posid = mysqli_real_escape_string($connection, $_POST['posid']);
                    $allow = mysqli_real_escape_string($connection, $_POST['allowmulti']);

                    $sqlcheck = mysqli_query($connection, "select count(*)total from candidates where PositionID = '$posid'");
                    $getcount = mysqli_fetch_array($sqlcheck);
                    if ($getcount['total'] == 1 AND $allow == 0) {
                        $error = "You Cannot Add Candidate to this Position";
                    } else if ($allow == 1) {
                        $image = $_FILES['image']['name'];
                        $valid_ext = array('png', 'jpeg', 'jpg');
                        $pathdb = "img/$image";
                        $path = $dir . $image;
                        $file_extension = pathinfo($path, PATHINFO_EXTENSION);
                        $file_extension = strtolower($file_extension);
                        $tmp_name = $_FILES['image']['tmp_name'];

                        if (in_array($file_extension, $valid_ext)) {
                            compressImage($tmp_name, $path, 60);
                            mysqli_autocommit($connection, FALSE);
                            $insert = "INSERT INTO candidates(CandidateName,Photo,PositionID,PositionName)VALUES('$cname','$pathdb','$posid','$pname')";
                            $checkinsert = mysqli_query($connection, $insert) or die(mysqli_error($connection));
                            if ($checkinsert == true) {
                                mysqli_commit($connection);
                                $msg = "Candidate has been added";
                            } else {
                                mysqli_rollback($connection);
                                $error = "Error while adding the Candidate..";
                            }
                        } else {
                            $error = "Invalid file type.";
                        }
                    }
                }
                ?>

                <section class="content">
                    <div class="row">
                        <?php
                        if (isset($_GET['editid'])) {
                            $usql = mysqli_query($connection, "select * from candidates i left join position d on(d.PID = i.PositionID) WHERE i.CID = '" . $_GET['editid'] . "'");
                            $uprow = mysqli_fetch_assoc($usql);
                            ?>
                            <div class="col-lg-3 col-md-4 col-xs-12">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <div class="box-tools">
                                            <?php
                                            if (isset($umsg)) {
                                                echo "<span class='text-success pull-right'>$umsg</span>";
                                                echo "<script>setTimeout(\"location.href = 'candidate.php';\",2000);</script>";
                                            } else if (isset($uerror)) {
                                                echo "<span class='text-warning pull-right'>$uerror</span>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <form   action="" method="POST" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <input type="hidden" name="cid"  id="cid" class="form-control required" value="<?php echo $uprow['CID']; ?>">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Candidate Name</label>
                                                    <input type="text" name="ucname"  id="ucname" class="form-control" required value="<?php echo $uprow['CandidateName']; ?>" >
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Select Position</label>
                                                    <select name="posuid" id="posuid" class="form-control select2" required >
                                                        <option value="">Please Select Position</option>
                                                        <?php
                                                        $sqlur = mysqli_query($connection, "select * from position");
                                                        while ($getur = mysqli_fetch_assoc($sqlur)) {
                                                            ?>
                                                            <option value="<?php echo $getur['PID']; ?>" <?php
                                                            if ($uprow['PositionID'] == $getur['PID']) {
                                                                echo "selected";
                                                            }
                                                            ?> data-upname="<?php echo $getur['Name']; ?>" data-uallow="<?php echo $getur['AllowMulti']; ?>"><?php echo $getur['Name']; ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <input type="hidden" name="upname"  id="upname" value="<?php echo $uprow['PositionName']; ?>">
                                            <input type="text" name="multi"  id="multi" >

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Upload Image</label>
                                                    <input type="file" name="uimage"  id="uimage"  onchange="loadFile(event)" class="form-control"  accept="image/*">
                                                    <input type="hidden" name="img" value="<?php echo "../uploads/" . $uprow['Photo']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <img id="output" src="<?php echo "../dist/" . $uprow['Photo']; ?>" class="img thumbnail"  style="width:100px;"/>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" name="UpdateCan" class="btn btn-sm bg-blue pull-right"><i class="fa fa-arrow-up"></i> Update Candidate</button>
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
                                        <div class="box-tools">
                                            <?php
                                            if (isset($msg)) {
                                                echo "<span class='text-success pull-right'>$msg</span>";
                                                echo "<script>setTimeout(\"location.href = 'candidate.php';\",3000);</script>";
                                            } else if (isset($error)) {
                                                echo "<span class='text-warning pull-right'>$error</span>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <form   action="" method="POST" enctype="multipart/form-data">
                                        <div class="box-body">

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Candidate Name</label>
                                                    <input type="text" name="cname"  id="cname" class="form-control" required  placeholder="Enter Candidate Name">
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Select Position</label>
                                                    <select name="posid" id="posid" class="form-control select2" required >
                                                        <option value="">Please Select Position</option>
                                                        <?php
                                                        $sqlu = mysqli_query($connection, "select * from position");
                                                        while ($getu = mysqli_fetch_assoc($sqlu)) {
                                                            ?>
                                                            <option value="<?php echo $getu['PID']; ?>" data-allow="<?php echo $getu['AllowMulti']; ?>" data-pname="<?php echo $getu['Name']; ?>"><?php echo $getu['Name']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="pname"  id="pname" >
                                            <input type="hidden" name="allowmulti"  id="allowmulti" >

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Upload Image</label>
                                                    <input type="file" name="image"  id="image"  onchange="loadFile(event)" class="form-control"  accept="image/*">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <img id="output" src="" class="img thumbnail"  style="width:200px; display: none;"/>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" name="AddCandidate" class="btn btn-sm bg-red pull-right"><i class="fa fa-save"></i> Add Candidate</button>
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
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $queryi = mysqli_query($connection, "select * from candidates i left join position il on(il.PID = i.PositionID)  Order By i.CID ASC") or die(mysqli_error($connection));
                                                while ($rowi = mysqli_fetch_assoc($queryi)) {
                                                    ?>
                                                    <tr>
                                                        <td><img  src="../dist/<?php echo $rowi['Photo']; ?>" class="img img-circle"  style="width:70px;"/></td>
                                                        <td><?php echo $rowi['CandidateName']; ?></td>
                                                        <td><?php echo $rowi['Name']; ?></td>
                                                        <td>
                                                            <a href="candidate.php?editid=<?php echo $rowi['CID']; ?>" class="btn btn-xs btn-flat text-red" title="Edit Candidate"><i class="fa fa-edit"></i> Edit</a>
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
                                                            var loadFile = function (event) {
                                                                var image = document.getElementById('output');
                                                                image.style.display = 'block';
                                                                image.src = URL.createObjectURL(event.target.files[0]);
                                                            };

                                                            $("#posid").on('change', function () {
                                                                var id = document.getElementById('posid').value;
                                                                if (id == '0') {
                                                                    alert("Please Select Other Position");
                                                                    $('input[name="pname"]').val("");
                                                                    $('input[name="allowmulti"]').val(0);
                                                                    return false;
                                                                } else {
                                                                    pname = $(this).children(':selected').data('pname');
                                                                    $('input[name="pname"]').val(pname);
                                                                    allow = $(this).children(':selected').data('allow');
                                                                    $('input[name="allowmulti"]').val(allow);
                                                                }
                                                            });

                                                            $("#posuid").on('change', function () {
                                                                var pid = document.getElementById('posuid').value;
                                                                if (pid == '0') {
                                                                    alert("Please Select Other Position");
                                                                    $('input[name="upname"]').val("");
                                                                    $('input[name="multi"]').val(0);
                                                                    return false;
                                                                } else {
                                                                    upname = $(this).children(':selected').data('upname');
                                                                    $('input[name="upname"]').val(upname);
                                                                    uallow = $(this).children(':selected').data('uallow');
                                                                    $('input[name="multi"]').val(uallow);
                                                                }
                                                            });

                                                        });


    </script>
</body>
</html>