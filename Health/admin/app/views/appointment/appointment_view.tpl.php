<?php include (DIR_ADMIN.'app/views/common/header.tpl.php'); ?>
<link rel="stylesheet" href="public/css/jquery.fancybox.min.css">
<script src="public/js/jquery.fancybox.min.js"></script>
<div class="page-title">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <h2 class="page-title-text d-inline-block"><?php echo $page_title; ?></h2>
            <div class="breadcrumbs d-inline-block">
                <ul>
                    <li><a href="<?php echo URL_ADMIN; ?>">Dashboard</a></li>
                    <li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'appointments'; ?>">Appointments</a></li>
                    <li><?php echo $page_title; ?></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="user-avtar">
                    <?php if (empty($result['doctor_picture'])  && file_exists(DIR.'public/uploads/'.$result['doctor_picture'])) { ?>
                        <img class="img-fluid" src="<?php echo URL.'public/uploads/'.$result['doctor_picture']; ?>" alt="">
                    <?php } else { ?>
                        <span><?php echo $result['doctor_name'][0]; ?></span>
                    <?php } ?>
                </div>
                <div class="user-details text-center pt-3">
                    <h3>Dr. <?php echo $result['doctor_name']; ?></h3>
                    <p class="mb-3 font-12"><i class="ti-email"></i> <?php echo $result['doctor_email']; ?> <i class="ti-mobile"></i> <?php echo $result['doctor_mobile']; ?></p>
                    <ul class="v-menu text-left pt-0 nav d-block">
                        <li><a href="#appointment-info" class="active" data-toggle="tab"><i class="ti-info-alt"></i> <span>Appointment Info</span></a></li>
                        <?php if ($page_notes) { ?>
                            <li><a href="#appointment-records" data-toggle="tab"><i class="ti-calendar"></i> <span>Clinical Notes</span></a></li>
                        <?php } if ($page_documents) { ?>
                            <li><a href="#appointment-documents" data-toggle="tab"><i class="ti-calendar"></i> <span>Documents</span></a></li>
                        <?php } if ($page_prescriptions) { ?>
                            <li><a href="#appointment-prescription" data-toggle="tab"><i class="ti-clipboard"></i> <span>Prescription</span></a></li>
                        <?php } if ($invoice_view || $invoice_add) { ?>
                            <li><a href="#appointment-invoice" data-toggle="tab"><i class="ti-receipt"></i> <span>Invoice</span></a></li>
                        <?php } if ($page_edit) { ?>
                            <li><a href="<?php echo URL_ADMIN.DIR_ROUTE.'appointment/edit&id='.$result['id']; ?>"><i class="ti-pencil-alt"></i> <span>Edit Appointment</span></a></li>
                        <?php } if ($page_sendmail) { ?>
                            <li><a href="#appointment-send-mail" data-toggle="tab"><i class="ti-email"></i> <span>Send Email</span></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="appointment-info">
                <div class="panel panel-default">
                    <div class="panel-head">
                        <div class="panel-title">Appointment Info</div>  
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped patient-table">
                                <tbody>
                                    <tr>
                                        <td>Date & Time</td>
                                        <td class="text-dark"><?php echo date_format(date_create($result['date']), $common['info']['date_format']). ' at ' .$result['time']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Reason/Problem</td>
                                        <td class="text-dark"><?php echo $result['message']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Patient Name</td>
                                        <td class="text-dark"><?php echo $result['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email Address</td>
                                        <td class="text-dark"><?php echo $result['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile Number</td>
                                        <td class="text-dark"><?php echo $result['mobile']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Bloodgroup</td>
                                        <td class="text-primary"><?php echo $result['bloodgroup']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td class="text-info"><?php echo $result['gender']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Age</td>
                                        <td class="text-success"><?php echo $result['age_year'].' Years '.$result['age_month'].' Month'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Medical History</td>
                                        <td class="text-danger"><?php if (!empty($result['history'])) { echo implode(', ', json_decode($result['history'], true)); } ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            <?php if ($result['status'] == 1) {
                                                echo '<span class="badge badge-sm badge-pill badge-danger">Cancelled</span>';
                                            } elseif ($result['status'] == 2) {
                                                echo '<span class="badge badge-sm badge-pill badge-info">In process</span>';
                                            } elseif ($result['status'] == 3) {
                                                echo '<span class="badge badge-sm badge-pill badge-success">Confirmed</span>';
                                            } elseif ($result['status'] == 4) {
                                                echo '<span class="badge badge-sm badge-pill badge-default">Completed</span>';
                                            } else {
                                                echo '<span class="badge badge-sm badge-pill badge-primary">New</span>';
                                            } ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($page_notes) { ?>
                <div class="tab-pane fade" id="appointment-records">
                    <div class="panel panel-default">
                        <div class="panel-head">
                            <div class="panel-title">Clinical Notes & Report/Documents</div>
                            <?php if (!empty($notes)) { ?>
                                <div class="panel-action">
                                    <a href="<?php echo URL_ADMIN.DIR_ROUTE.'records/pdf&id='.$notes['id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="ti-printer mr-2"></i>PDF/Print</a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="panel-body">
                            <div class="notes-container">
                                <div class="timeline-1 timeline-2">
                                    <div class="marker"></div>
                                    <div class="item item-left notes-problem">
                                        <div class="circle"><i class="ti-help-alt"></i></div>
                                        <div class="arrow"></div>
                                        <div class="item-content">
                                            <div class="title">Problems</div>
                                            <div class="descr">
                                                <ul>
                                                    <?php if (!empty($notes['notes']['problem'])) { foreach ($notes['notes']['problem'] as $key => $value) { ?>
                                                        <li><?php echo htmlspecialchars_decode($value); ?></li>
                                                    <?php } } ?>
                                                </ul>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="item item-left notes-observation">
                                        <div class="circle"><i class="ti-panel text-info"></i></div>
                                        <div class="arrow"></div>
                                        <div class="item-content">
                                            <div class="title">Observation</div>
                                            <div class="descr">
                                                <ul>
                                                    <?php if (!empty($notes['notes']['observation'])) { foreach ($notes['notes']['observation'] as $key => $value) { ?>
                                                        <li><?php echo htmlspecialchars_decode($value); ?></li>
                                                    <?php } } ?>
                                                </ul>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="item item-left notes-diagnosis">
                                        <div class="circle"><i class="ti-heart-broken text-secondary"></i></div>
                                        <div class="arrow"></div>
                                        <div class="item-content">
                                            <div class="title">Diagnosis</div>
                                            <div class="descr">
                                                <ul>
                                                    <?php if (!empty($notes['notes']['diagnosis'])) { foreach ($notes['notes']['diagnosis'] as $key => $value) { ?>
                                                        <li><?php echo htmlspecialchars_decode($value); ?></li>
                                                    <?php } } ?>
                                                </ul>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="item item-left notes-investigation">
                                        <div class="circle"><i class="ti-agenda text-success"></i></div>
                                        <div class="arrow"></div>
                                        <div class="item-content">
                                            <div class="title">Test Request/Investigation</div>
                                            <div class="descr">
                                                <ul>
                                                    <?php if (!empty($notes['notes']['investigation'])) { foreach ($notes['notes']['investigation'] as $key => $value) { ?>
                                                        <li><?php echo htmlspecialchars_decode($value); ?></li>
                                                    <?php } } ?>
                                                </ul>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="item item-left notes-notes">
                                        <div class="circle"><i class="ti-write text-primary"></i></div>
                                        <div class="arrow"></div>
                                        <div class="item-content">
                                            <div class="title">Notes</div>
                                            <div class="descr">
                                                <ul>
                                                    <?php if (!empty($notes['notes']['notes'])) { foreach ($notes['notes']['notes'] as $key => $value) { ?>
                                                        <li><?php echo $value; ?></li>
                                                    <?php } } ?>
                                                </ul>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } if ($page_documents) { ?>
                <div class="tab-pane fade" id="appointment-documents">
                    <div class="panel panel-default">
                        <div class="panel-head">
                            <div class="panel-title">Documents/Reports</div>
                        </div>
                        <div class="panel-body">
                            <div class="report-container">
                                <?php if (!empty($reports)) { foreach ($reports as $key => $value) { $file_ext = pathinfo($value['report'], PATHINFO_EXTENSION); if ($file_ext == "pdf") { ?>
                                    <div class="report-image report-pdf">
                                        <a href="../public/uploads/reports/<?php echo $value['report']; ?>" class="open-pdf font-12" style="display: block;">
                                            <img class="img-thumbnail" src="../public/images/pdf.png" alt="">
                                        </a>
                                    </div>
                                <?php } else {?>
                                    <div class="report-image">
                                        <a data-fancybox="gallery" href="../public/uploads/reports/<?php echo $value['report']; ?>"><img class="img-thumbnail" src="../public/uploads/reports/<?php echo $value['report']; ?>" alt=""></a>
                                    </div>
                                <?php } } } else { ?>
                                    <p class="text-danger text-center">No documents found !!!</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } if ($invoice_view || $invoice_add) { ?>
                <div class="tab-pane fade" id="appointment-invoice">
                    <div class="panel panel-default">
                        <div class="panel-head">
                            <div class="panel-title">Invoice</div>
                        </div>
                        <div class="panel-body">
                            <div class="text-center">
                                <?php if ($result['invoice_id']) { ?>
                                    <p>Invoice is Generated</p>
                                    <a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/view&id='.$result['invoice_id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="far fa-file-pdf mr-2"></i>View</a>
                                    <a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/pdf&id='.$result['invoice_id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="far fa-file-pdf mr-2"></i>PDF</a>
                                    <a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/print&id='.$result['invoice_id']; ?>" class="btn btn-success btn-sm" target="_blank"><i class="ti-printer mr-2"></i>Print</a>
                                    <a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/edit&id='.$result['invoice_id']; ?>" class="btn btn-info btn-sm" target="_blank"><i class="ti-pencil-alt mr-2"></i>Edit</a>
                                <?php } else { ?>
                                    <p>Invoice is not Generated</p>
                                    <a href="<?php echo URL_ADMIN.DIR_ROUTE.'invoice/add&appointment='.$result['id']; ?>" class="btn btn-primary btn-sm" target="_blank"><i class="ti-plus pr-2"></i>Generate Invoice Now</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } if ($page_prescriptions) { ?>
                <div class="tab-pane fade" id="appointment-prescription">
                    <div class="panel panel-default">
                        <div class="panel-head">
                            <div class="panel-title">Prescription</div>
                            <?php if (!empty($prescription['prescription'])) { ?>
                                <div class="panel-action">
                                    <a href="<?php echo URL_ADMIN.DIR_ROUTE.'prescription/pdf&id='.$result['prescription_id']; ?>" class="btn btn-danger btn-sm" target="_blank"><i class="ti-printer mr-2"></i>PDF/Print</a>
                                </div>
                            <?php } ?> 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Medicine Name</th>
                                        <th>Dose</th>
                                        <th>Duration</th>
                                        <th>Instruction</th>
                                    </tr>
                                    <?php if (!empty($prescription['prescription'])) { foreach ($prescription['prescription'] as $key => $value) { ?>
                                        <tr>
                                            <td>
                                                <p class="font-14 text-primary m-0"><?php echo $value['name']; ?></p>
                                                <p class="font-12 m-0"><?php echo htmlspecialchars_decode($value['generic']); ?></p>
                                            </td>
                                            <td class="text-center"><p class="font-12"><?php echo $value['dose']; ?></p></td>
                                            <td class="text-center"><p class="font-12"><?php echo $value['duration'].' Day'; ?></p></td>
                                            <td class="text-center"><p class="font-12"><?php echo $value['instruction']; ?></p></td>
                                        </tr>
                                    <?php } } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } if ($page_sendmail) { ?>
                <div class="tab-pane fade" id="appointment-send-mail">
                    <div class="panel panel-default">
                        <div class="panel-head">
                            <div class="panel-title">Send Email to Patient</div>  
                        </div>
                        <form action="<?php echo URL_ADMIN.DIR_ROUTE.'appointment/sendmail'; ?>" method="post">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>To</label>
                                    <input type="text" value="<?php echo $result['name']; ?>" class="form-control" readonly>
                                    <input type="hidden" name="mail[id]" value="<?php echo $result['id']; ?>" readonly>
                                    <input type="hidden" name="_token" value="<?php echo $token; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input type="text" name="mail[subject]" class="form-control" placeholder="Enter SUbject . . .">
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea name="mail[message]" class="form-control mail-summernote" placeholder="Enter Message . . ."></textarea>
                                </div>
                            </div>
                            <div class="panel-footer text-center">
                                <button type="submit" name="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php if ($page_sendmail) { ?>
    <!-- include summernote css/js-->
    <link href="public/css/summernote-bs4.css" rel="stylesheet">
    <script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
    <script type="text/javascript" src="public/js/klinikal.summernote.js"></script>
<?php } ?>
<script>
    $("a.open-pdf").fancybox({
        'frameWidth': 800,
        'frameHeight': 800,
        'overlayShow': true,
        'hideOnContentClick': false,
        'type': 'iframe'
    });
</script>
<!-- Footer -->
<?php include (DIR_ADMIN.'app/views/common/footer.tpl.php'); ?>