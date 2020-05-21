<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="<?php echo CURADDRESS; ?>" class="navbar-brand text-bold text-white"><?php echo TITLE; ?></a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="position.php">MANAGE POSITION</a></li>
                    <li><a href="candidate.php">MANAGE CANDIDATE</a></li>
                    <li><a href="voterslist.php">VOTERS LIST</a></li>

                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-power-off"></i> <?php echo strtoupper($email); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <ul class="menu">
                                    <li><a href="logout.php">LOG OUT</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>