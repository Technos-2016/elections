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
                        Please
                        <small> Vote</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo CURADDRESS; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Voters Position</li>
                    </ol>
                </section>



                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            
                            <form action="postvote.php" method="post" >
                                <input type="hidden" name="uid" value="<?php echo $_SESSION['ID'] ?>" >
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h5>
                                                <i class="fa fa-info-circle text-red"></i>  
                                                District Governor
                                            </h5>
                                        </div>
                                        <div class="box-body">
                                            <div class="form-group">
                                                <?php
                                                $sql = mysqli_query($connection, "select * from candidates WHERE PositionID = 1");
                                                while ($row = mysqli_fetch_assoc($sql)) {
                                                    ?>
                                                    <div class="col-sm-6">
                                                        <img src="../dist/<?php echo $row['Photo']; ?>" width="100" class="img thumbnail" alt="Candidate Image" >
                                                        <label  class="control-label">
                                                            <?php echo $row['CandidateName']; ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="control-label">YES <i class="fa fa-thumbs-up text-green"></i></label>
                                                        <input type="radio" id="<?php echo $row['PositionID']; ?>" name="vote[<?php echo $row['PositionID']; ?>]" value="Yes,<?php echo $row['CID']; ?>" class="minimal-red" style="width:30px;" required>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>NO <i class="fa fa-thumbs-down text-red"></i></label>
                                                        <input type="radio" id="<?php echo $row['PositionID']; ?>" name="vote[<?php echo $row['PositionID']; ?>]" value="No,<?php echo $row['CID']; ?>" class="minimal-red" style="width:30px;" required>
                                                    </div>
                                                    <br/><br/>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h5><i class="fa fa-info-circle text-blue"></i>  
                                                1st Vice District Governor
                                            </h5>
                                        </div>
                                        <div class="box-body">
                                            <div class="form-group">
                                                <?php
                                                $sql = mysqli_query($connection, "select * from candidates WHERE PositionID = 2");
                                                while ($row = mysqli_fetch_assoc($sql)) {
                                                    ?>
                                                    <div class="col-sm-6">
                                                        <img src="../dist/<?php echo $row['Photo']; ?>" width="100" class="img thumbnail" alt="Candidate Image" >
                                                        <label  class="control-label">
                                                            <?php echo $row['CandidateName']; ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>YES <i class="fa fa-thumbs-up text-green"></i></label>
                                                        <input type="radio" id="<?php echo $row['PositionID']; ?>" name="vote[<?php echo $row['PositionID']; ?>]" value="Yes,<?php echo $row['CID']; ?>" class="minimal-red" style="width:30px;" required>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>NO <i class="fa fa-thumbs-down text-red"></i></label>
                                                        <input type="radio" id="<?php echo $row['PositionID']; ?>" name="vote[<?php echo $row['PositionID']; ?>]" value="No,<?php echo $row['CID']; ?>" class="minimal-red" style="width:30px;" required>
                                                    </div>
                                                    <br/><br/>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">

                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h5><i class="fa fa-info-circle text-green"></i>  
                                                2nd Vice District Governor - Only One
                                            </h5>
                                        </div>
                                        <div class="box-body">

                                            <?php
                                            $sql = mysqli_query($connection, "select * from candidates WHERE PositionID = 3");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                <div class="form-group clearfix">
                                                    <div class="col-sm-6">
                                                        <img src="../dist/<?php echo $row['Photo']; ?>" width="100" class="img thumbnail" alt="Candidate Image" >
                                                        <label  class="control-label">
                                                            <?php echo $row['CandidateName']; ?>
                                                        </label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label>YES <i class="fa fa-thumbs-up text-green"></i></label>
                                                        <input type="radio" id="<?php echo $row['PositionID']; ?>" name="vote[<?php echo $row['PositionID']; ?>]" value="Yes,<?php echo $row['CID']; ?>" class="minimal-red" style="width:30px;" required>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-12">
                                    <button type="submit" id="submit" name="submit" class="btn btn-sm bg-red">Submit Vote</button>
                                </div>
                            </form>
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