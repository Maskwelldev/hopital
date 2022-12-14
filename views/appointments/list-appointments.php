<!-- Main Content -->
<div id="content">

<div id="content-wrapper" class="d-flex flex-column">
    <h1 class="h2 text-primary mb-3">Liste des rendez-vous</h1>
    

    <?php
    if(SessionFlash::checkMessage()){
    ?>
        <div class="alert alert-primary" role="alert">
            <strong><?=SessionFlash::getMessage()?></strong>
        </div>
        
    <?php } ?>
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Heure</th>
                <th scope="col">Patient</th>
                <th scope="col">Docteur</th>
                <th scope="col">Service</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($appointments as $appointment) {
                $i++;
            ?>
                <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= date('d.m.Y', strtotime($appointment->dateHour)) ?></td>
                    <td><?= date('H:i', strtotime($appointment->dateHour)) ?></td>
                    <td><?= htmlentities($appointment->lastname . ' ' . substr($appointment->firstname, 0, 1) . '.')?></td>
                    <td>Dr. <?= htmlentities($appointment->lname) ?></td>
                    <td><?= htmlentities($appointment->service_name) ?></td>
                    <td class="text-center">
                        <a href="/controllers/edit-appointmentCtrl.php?id=<?= $appointment->id ?>"><i class="fas fa-edit fs-5 mr-3"></i></a>
                        <a href="/controllers/delete-appointmentCtrl.php?id=<?= $appointment->id?>"><i class="fas fa-trash fs-5"></i></a>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
    </div>

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">??</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>
