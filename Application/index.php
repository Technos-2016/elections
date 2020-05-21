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
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <?php
                $sql1 = mysqli_query($connection, "select COUNT(ID)NoOfCandidate from voterslist");
                $count1 = mysqli_fetch_array($sql1);

                $totalsql = mysqli_query($connection, "select count(PollID)totalpoll from poll Where PollRemarks = 'Yes'");
                $rowtotal = mysqli_fetch_array($totalsql);

                $sql2 = mysqli_query($connection, "select COUNT(PollID)DG from poll WHERE PositionID = 1 AND PollRemarks = 'Yes'");
                $count2 = mysqli_fetch_array($sql2);

                $sql3 = mysqli_query($connection, "select COUNT(PollID)VDG1 from poll WHERE PositionID = 2 AND PollRemarks = 'Yes'");
                $count3 = mysqli_fetch_array($sql3);

                $sql4 = mysqli_query($connection, "select COUNT(PollID)VDG2 from poll WHERE PositionID = 3");
                $count4 = mysqli_fetch_array($sql4);
                ?>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- Small boxes (Stat box) -->
                        <div class="col-lg-12">
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-maroon">
                                    <div class="inner">
                                        <h3><?php echo $rowtotal['totalpoll']; ?></h3>
                                        <p>Total Vote Count</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-database"></i>
                                    </div>
                                    <a href="vdgvote.php" class="small-box-footer">
                                        More info <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3><?php echo $count2['DG']; ?></h3>
                                        <p>District Governor Votes</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-thumbs-o-up"></i>
                                    </div>
                                    <a href="vdgvote.php?pid=1" class="small-box-footer">
                                        More info <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-light-blue">
                                    <div class="inner">
                                        <h3><?php echo $count3['VDG1']; ?></h3>
                                        <p>1st Vice DG Candidate</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-thumbs-o-up"></i>
                                    </div>
                                    <a href="vdgvote.php?pid=2" class="small-box-footer">
                                        More info <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3><?php echo $count4['VDG2']; ?></h3>
                                        <p>2nd Vice DG Candidate</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-thumbs-o-up"></i>
                                    </div>
                                    <a href="vdgvote.php?pid=3" class="small-box-footer">
                                        More info <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- /.maincol -->

                        <div class="col-lg-12">

                            <div class="col-lg-6 col-xs-12">
                                <div class="box box-solid">
                                    <div class="box-header with-border bg-red"><i class="fa fa-thumbs-o-up"></i> Poll Results</div>
                                    <div class="box-body" >
                                        <?php
                                        $actcount = mysqli_query($connection, "SELECT PositionID,CandidateID,count(PollID)PollID FROM poll WHERE  PollRemarks = 'Yes' GROUP BY CandidateID,PositionID");
                                        while ($rowuserwise = mysqli_fetch_array($actcount)) {
                                            $percentage = ( $rowuserwise["PollID"] / $rowtotal["totalpoll"] ) * 100;
                                            if (is_float($percentage)) {
                                                $percentage = number_format($percentage, 2);
                                            }

                                            $getcandidate = mysqli_query($connection, "select * from candidates where CID = '" . $rowuserwise['CandidateID'] . "' AND PositionID = '" . $rowuserwise['PositionID'] . "'");
                                            $row = mysqli_fetch_array($getcandidate);

                                            if ($rowuserwise['PositionID'] == 1) {
                                                $a = "progress-bar-yellow";
                                            } else if ($rowuserwise['PositionID'] == 2) {
                                                $a = "progress-bar-red";
                                            } else if ($rowuserwise['PositionID'] == 3) {
                                                $a = "progress-bar-green";
                                            }
                                            ?>
                                            <!-- /.col -->
                                            <div class="col-md-12">
                                                <div class="progress-group">
                                                    <span><img src="../dist/<?php echo $row['Photo'];?>" class="img img-circle" alt="Candidate Image" width="30"/></span>
                                                    <span class="progress-text"><?php echo $row['CandidateName'] . " - (" . $row['PositionName'] . ")"; ?></span>
                                                    <span class="progress-number"><b><?php echo $percentage . " %"; ?></b></span>
                                                    <div class="progress xs">
                                                        <div class="progress-bar <?php echo $a; ?>" style="width: <?php echo $percentage; ?>%"></div>
                                                    </div>
                                                </div>
                                                <br/>
                                                <br/>
                                            </div>
                                            
                                            <!-- /.col -->
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6 col-xs-12">
                                <div class="box box-solid">

                                    <?php
                                    $actcount = mysqli_query($connection, "SELECT PositionID,CandidateID,count(PollID)PollID FROM poll GROUP BY CandidateID,PositionID");
                                    $rowuserwise = mysqli_fetch_array($actcount);
                                    $percentage = ( $rowuserwise["PollID"] / $rowtotal["totalpoll"] ) * 100;
                                    if (is_float($percentage)) {
                                        $percentage = number_format($percentage, 2);
                                    }

                                    $getcandidate = mysqli_query($connection, "select * from candidates where CID = '" . $rowuserwise['CandidateID'] . "' AND PositionID = '" . $rowuserwise['PositionID'] . "'");
                                    $row = mysqli_fetch_array($getcandidate);

                                    if ($rowuserwise['PositionID'] == 1) {
                                        $a = "progress-bar-yellow";
                                    } else if ($rowuserwise['PositionID'] == 2 AND $rowuserwise['CandidateID'] == 2) {
                                        $a = "progress-bar-red";
                                    } else if ($rowuserwise['PositionID'] == 2 AND $rowuserwise['CandidateID'] == 3) {
                                        $a = "progress-bar-green";
                                    }
                                    ?>
                                    <!-- /.col -->

                                    <!-- BAR CHART -->
                                    <div class="box box-success">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Barchart Poll Evaluation</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="chart">
                                                <canvas id="barChart" ></canvas>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->

                                    <!-- /.col -->


                                </div>
                            </div>

                        </div>

                    </div><!-- /.row -->
                </section><!-- /.content -->
            </div><!-- /.container -->
        </div><!-- /.content-wrapper -->
        <?php include 'footerbottom.php'; ?>
    </div><!-- ./wrapper -->
    <?php include 'bottomlinks.php'; ?>
    <script src="../plugins/chartjs/Chart.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $.ajax({
                url: "show-poll.php",
                method: "GET",
                success: function (data) {
                    //console.log(data);
                    var CandidateName = [];
                    var Count = [];
                    var Position = [];

                    for (var i in data) {
                        CandidateName.push(data[i].CandidateName);
                        Count.push(data[i].PollID);
                        Position.push(data[i].PositionName);
                    }
                    
                    var pieChartData = {
                        labels: CandidateName,
                        datasets: [
                            {
                                label: Position,
                                fillColor: '#009333',
                                strokeColor: 'rgba(210, 214, 222, 1)',
                                pointColor: 'rgba(210, 214, 222, 1)',
                                pointStrokeColor: '#c1c7d1',
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                data: Count
                            }
                        ]
                    }

                    var barChartCanvas = $('#barChart').get(0).getContext('2d')
                    var barChart = new Chart(barChartCanvas)
                    var barChartData = pieChartData;
                    var barChartOptions = {
                        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                        scaleBeginAtZero: true,
                        //Boolean - Whether grid lines are shown across the chart
                        scaleShowGridLines: true,
                        //String - Colour of the grid lines
                        scaleGridLineColor: 'rgba(1,0,1,.05)',
                        //Number - Width of the grid lines
                        scaleGridLineWidth: 1,
                        //Boolean - Whether to show horizontal lines (except X axis)
                        scaleShowHorizontalLines: true,
                        //Boolean - Whether to show vertical lines (except Y axis)
                        scaleShowVerticalLines: true,
                        //Boolean - If there is a stroke on each bar
                        barShowStroke: true,
                        //Number - Pixel width of the bar stroke
                        barStrokeWidth: 1,
                        //Number - Spacing between each of the X value sets
                        barValueSpacing: 5,
                        //Number - Spacing between data sets within X values
                        barDatasetSpacing: 0.5,
                        //String - A legend template
                        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                        //Boolean - whether to make the chart responsive
                        responsive: true,
                        maintainAspectRatio: true
                    }

                    barChartOptions.datasetFill = false
                    barChart.Bar(barChartData, barChartOptions)
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
    </script>
</body>
</html>