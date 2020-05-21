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

                <?php
                ini_set('max_execution_time', 300);
                if (isset($_POST["Import"])) {

                    $filename = $_FILES["file"]["name"];
                    $handle = fopen($_FILES['file']['tmp_name'], "r");
                    $limit = 100;
                    $values = array();
                    $titles = array();
                    $titlesSet = false;

                    $count = 0;
                    if ($_FILES["file"]["size"] == 0) {
                        echo "<script>alert('No Data Available in CSV');window.location='voterslist.php'</script>";
                    }
                    while (($data = fgetcsv($handle, $limit, ",")) !== FALSE) {
                        $count++;
                        if ($count == 1) {
                            continue;
                        }
                        if (count($data) > 1) { // this means minimum 2 colums
                            $data = array_map('trim', $data);
                            $data = array_filter($data);
                            $sqlInsert = "INSERT into voterslist(Name,Email,Password,Pass,Mobile,Club)values ('" . $data[0] . "','" . $data[1] . "','" . $data[2] . "','" . md5($data[2]) . "','" . $data[3] . "','" . $data[4] . "')";
                            $result = mysqli_query($connection, $sqlInsert);
                            if ($titlesSet) {
                                $values[] = $data;
                            } else {
                                $titles[] = $data;
                                $titlesSet = true;
                            }
                        }
                    }
                    if ($values == true) {
                        echo "<script>alert('CSV UPDATED and total data was $count')</script>";
                        echo "<script>alert('successfully imported the voters data');window.location='voterslist.php'</script>";
                    } else {
                        echo "<script>alert('error importing the data');window.location='voterslist.php'</script>";
                    }
                    fclose($handle);
                }
                ?>

                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h5><i class="fa fa-plus-square-o text-red"></i> Upload Voters</h5>
                                    <div class="box-tools pull-right">
                                        <button type="button" id="minus" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="col-sm-12" id="collapse">
                                        <form action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                                            <div class="form-group-sm">
                                                <div class="col-sm-1">
                                                    <label class="control-label">Choose Excel</label> 
                                                </div>
                                                <div class="col-sm-3">
                                                    <input class="form-control" type="file" name="file" id="file" accept=".csv">
                                                </div>
                                                <div class="col-sm-1">
                                                    <button type="submit" id="submit" name="Import" class="btn btn-sm bg-red">Import</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>



                            <div class="box box-solid">
                                <div class="box-header">
                                    <div class="col-sm-4">
                                        <button type="button" name="bulk_email" class="btn btn-sm bg-red email_button" id="bulk_email" data-action="bulk">Send Bulk</button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <?php
                                    $sqlSelect = "SELECT * FROM voterslist";
                                    $result = mysqli_query($connection, $sqlSelect);
                                    if (!empty($result)) {
                                        ?>

                                        <table class='table table-bordered table-condensed text-center'>
                                            <thead class="bg-red">
                                                <tr>
                                                    <th><input type="checkbox" id="selectallboxes"></th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>MobileNo</th>
                                                    <th>Club</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $count = 0;
                                            While ($row = mysqli_fetch_array($result)) {
                                                $vid = $row['ID'];
                                                $count = $count + 1;
                                                ?>                  
                                                <tbody>
                                                    <tr>
                                                        <td><input type="checkbox" class="single_select" name="single_select"  data-email="<?php echo $row['Email']; ?>" data-name="<?php echo $row['Name']; ?>" data-password="<?php echo $row['Password']; ?>" ></td>
                                                        <td><?php echo $row['Name']; ?></td>
                                                        <td><?php echo $row['Email']; ?></td>
                                                        <td><?php echo $row['Mobile']; ?></td>
                                                        <td><?php echo $row['Club']; ?></td>
                                                        <td class="text-center">
                                                            <a href="#edit<?php echo $row['ID']; ?>" class="btn btn-xs bg-red" data-toggle = "modal" data-target="#edit<?php echo $row['ID']; ?>" title="Edit User Detail"><i class = "fa fa-pencil"></i></a>
                                                            &nbsp; | &nbsp;
                                                            <button type="button" name="email_button" class="btn bg-green btn-xs email_button" id="<?php echo $count; ?>" data-email="<?php echo $row['Email']; ?>" data-name="<?php echo $row['Name']; ?>" data-password="<?php echo $row['Password']; ?>" data-action="single">Send Single</button>
                                                        </td>  
                                                    </tr>
                                                    <?php include 'voters/update_detail.php'; ?>
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
    <script src="../plugins/select2/select2.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {

            $('.email_button').click(function () {
                $(this).attr('disabled', 'disabled');
                var id = $(this).attr("id");
                var action = $(this).data("action");
                var email_data = [];
                if (action == 'single')
                {
                    email_data.push({
                        email: $(this).data('email'),
                        name: $(this).data('name'),
                        password: $(this).data('password')
                    });
                } else
                {
                    $('.single_select').each(function () {
                        if ($(this).prop("checked") == true)
                        {
                            email_data.push({
                                email: $(this).data("email"),
                                name: $(this).data("name"),
                                password: $(this).data("password")
                            });
                        }
                    });
                }

                $.ajax({
                    url: "send_mail.php",
                    method: "POST",
                    data: {email_data: email_data},
                    beforeSend: function () {
                        $('#' + id).html('Sending...');
                        $('#' + id).addClass('btn-danger');
                    },
                    success: function (data) {
                        if (data == 'ok')
                        {
                            $('#' + id).text('Successfully Sent to all');
                            $('#' + id).removeClass('btn-danger');
                            $('#' + id).removeClass('btn-info');
                            $('#' + id).addClass('btn-success');
                            window.setTimeout(function(){location.reload()},2000)
                        } else
                        {
                            $('#' + id).text(data);
                        }
                        $('#' + id).attr('disabled', false);
                    }
                })

            });


            var collapse = document.getElementById('collapse');
            collapse.style.display = 'none';
            $('#minus').on('click', function () {
                collapse.style.display = 'block';
            });

            $('#selectallboxes').click(function (event) {
                if (this.checked) {
                    $('.single_select').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.single_select').each(function () {
                        this.checked = false;
                    });
                }
            });

            $(".select2").select2();

        });
    </script>
</body>
</html>