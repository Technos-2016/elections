<div id = "edit<?php echo $row['ID']; ?>" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Edit Details</h4>
            </div>
            <form method = "POST" action = "voters/updatevoter.php"> 
                <div class="modal-body">
                    <input type="hidden" name="userid" value="<?php echo $row['ID']; ?>">
                    <label>Name</label>
                    <input type="text" name = "name" class="form-control required" required value = "<?php echo $row['Name']; ?>" >
                    <label>Email</label>
                    <input type="text" name = "email"  class="form-control required" required value = "<?php echo $row['Email']; ?>">
                    <label>Password</label>
                    <input type="text" name = "pass"  class="form-control required" required value = "<?php echo $row['Password']; ?>">
                    <label>Mobile</label>
                    <input type="text" name = "mobile"  class="form-control required" required value = "<?php echo $row['Mobile']; ?>">
                </div>
                <div class="modal-footer bg-red">
                    <button type="button" class="btn bg-red pull-left" data-dismiss="modal">Close</button>
                    <button  name = "update" class="btn bg-red">Update Voters</button>
                </div>
            </form>
        </div>
    </div>
</div>