<?php include 'server/server.php' ?>
<?php 
    $id = $_GET['id'];
	$query = "SELECT * FROM tblresident WHERE id='$id'";
    $result = $conn->query($query);
    $resident = $result->fetch_assoc();

    $query1 = "SELECT * FROM tblofficials JOIN tblposition ON tblofficials.position=tblposition.id WHERE tblposition.position NOT IN ('SK Chairrman','Secretary','Treasurer')
                AND `status`='Active' ORDER BY `order` ASC";
    $result1 = $conn->query($query1);
    $officials = array();
	while($row = $result1->fetch_assoc()){
		$officials[] = $row; 
	}

    $c = "SELECT * FROM tblofficials JOIN tblposition ON tblofficials.position=tblposition.id WHERE tblposition.position='Captain'";
    $captain = $conn->query($c)->fetch_assoc();
    $s = "SELECT * FROM tblofficials JOIN tblposition ON tblofficials.position=tblposition.id WHERE tblposition.position='Secretary'";
    $sec = $conn->query($s)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Certificate of Indigency - BBQS BURU-UN</title>
    <style>
        @page  
        { 
            size: auto;   /* auto is the initial value */ 

            /* this affects the margin in the printer settings */ 
            margin: 20mm 20mm 20mm 20mm;  
        } 

    </style>
</head>
<body>
<?php include 'templates/loading_screen.php' ?>
	<div class="wrapper">
		<!-- Main Header -->
		<?php include 'templates/main-header.php' ?>
		<!-- End Main Header -->

		<!-- Sidebar -->
		<?php include 'templates/sidebar.php' ?>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white fw-bold">Generate Certificate</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner">
					<div class="row mt--2">
						<div class="col-md-12">

                            <?php if(isset($_SESSION['message'])): ?>
                                <div class="alert alert-<?php echo $_SESSION['success']; ?> <?= $_SESSION['success']=='danger' ? 'bg-danger text-light' : null ?>" role="alert">
                                    <?php echo $_SESSION['message']; ?>
                                </div>
                            <?php unset($_SESSION['message']); ?>
                            <?php endif ?>

                            <div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title">Certificate of Indigency</div>
										<div class="card-tools">
											<button class="btn btn-info btn-border btn-round btn-sm" onclick="printDiv('printThis')">
												<i class="fa fa-print"></i>
												Print Certificate
											</button>
										</div>
									</div>
								</div>
								<div class="card-body m-5" id="printThis">
                                    <div class="d-flex flex-wrap justify-content-around" style="border-bottom:1px solid red">
										<div class="text-center">
                                        <img src="assets/img/bb123456.png" height="120" width="1070" >
										</div>
									</div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="text-center mt-5">
                                            </div>
                                            <div class="text-center">
                                                <h1 class="mt-4 fw-bold mb-5" style="font-size:38px;color:darkblue">CERTIFICATE OF INDIGENCY</h1>
                                            </div>
                                            <h2 class="mt-5 fw-bold">TO WHOM IT MAY CONCERN:</h2>
                                            <h2 class="mt-3" style="text-indent: 40px;">THIS IS TO CERTIFY that <span class="mt-3" style="font-size:22px"><?= ucwords($resident['firstname'].' '.$resident['middlename'].' '.$resident['lastname']) ?></span>, 
                                            of legal age, and resident of <span class="mt-3" style="font-size:22px"><?= ucwords($resident['purok']) ?></span>, 
                                            <span class="mt-3" style="font-size:22px"><?= ucwords($brgy) ?></span>, 
                                            <h2 class="mt-3" style="text-indent: 40px;"><s></s><?= ucwords($resident['gender']) ?></span>, is one of the indigents of this barangay.</h2>
                                            <h2 class="mt-3" style="text-indent: 40px;">Issued this <span class="fw-bold" style="font-size:25px"><?=('CERTIFICATION') ?></span> 
                                            <span class="static-text">upon the request of</span> <span contenteditable="true" class="editable"></span> <span class="static-text">to support for his/her application for</span> <span contenteditable="true" class="editable"></span>.</p></h2>

                                            <style>
                                            .editable, .static-text {
                                                font-size: 22px; 
                                            }
                                            .editable {
                                                border-bottom: 1px solid;
                                                display: inline-block;
                                                min-width: 180px;
                                                letter-spacing: 1px;
                                            }
                                            .editable:focus {
                                                outline: none;
                                            }
                                            </style>

                                            <script>
                                            document.querySelectorAll('.editable').forEach(function(span) {
                                                span.addEventListener('input', function() {
                                                // Limit the number of characters based on the initial underscores
                                                const maxLength = span.textContent.length;
                                                if (span.textContent.length > maxLength) {
                                                    span.textContent = span.textContent.slice(0, maxLength);
                                                }
                                                });
                                            });
                                            </script>


                                            <h2 class="mt-5">Given this <span class="fw-bold" style="font-size:25px"><?= date('m/d/Y') ?></span> 
                                        <div class="col-md-12">
                                            <div class="p-3 text-right mr-5" style="margin-top:200px">
                                                <h1 class="fw-bold mb-0 text-uppercase"><?= ucwords($captain['name']) ?></h1>
                                                <p class="mr-5">PUNONG BARANGAY</p>
                                                <h2 class="mt-" style="text-align: left; margin-top: 50px;">“Not valid if without official seal”</h2>
                                                <div class="text-center">
                                                <img src="assets/img/bb7878.png" height="120" width="1070" style="margin-top: 200px;">
										</div>
                                            </div>
                                        </div>
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <!-- Modal -->
            <div class="modal fade" id="pment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="model/save_pment.php" >
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" class="form-control" name="amount" placeholder="Enter amount to pay" required>
                                </div>
                                <div class="form-group">
                                    <label>Date Issued</label>
                                    <input type="date" class="form-control" name="date" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <label>OR No</label>
                                    <input type="OR_No" class="form-control" name="OR_No" placeholder="Enter OR No" required>
                                </div>
                                <div class="form-group">
                                    <label>Payment Details(Optional)</label>
                                    <textarea class="form-control" placeholder="Enter Payment Details" name="details">Certificate of Indigency Payment</textarea>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" class="form-control" name="name" value="<?= ucwords($resident['firstname'].' '.$resident['middlename'].' '.$resident['lastname']) ?>">
                            <button type="button" class="btn btn-secondary" onclick="goBack()">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
			<!-- Main Footer -->
			<?php include 'templates/main-footer.php' ?>
			<!-- End Main Footer -->
			<?php if(!isset($_GET['closeModal'])){ ?>
            
                <script>
                    setTimeout(function(){ openModal(); }, 1000);
                </script>
            <?php } ?>
		</div>
		
	</div>
	<?php include 'templates/footer.php' ?>
    <script>
            function openModal(){
                $('#pment').modal('show');
            }
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
    </script>
</body>
</html>