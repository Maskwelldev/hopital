<!-- Main Content -->
<div id="content">

<?php if(isset($errorsArray['global'])) {?>

    <div class="alert alert-warning" role="alert">
        <?= nl2br($errorsArray['global'])?>
    </div>

<?php } else { ?>
    <h1 class="h2 text-primary mb-3">Numéros utiles</h1>

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
                <th scope="col">Service</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Email</th>
                <!-- <th scope="col">Actions</th> -->
            </tr>
        </thead>
        <tbody>

        <?php 
        foreach($services as $service) {
            ?>
            <tr>
                <td><?=htmlentities($service->id)?></td>
                <td><?=htmlentities($service->service_name)?></td>
                <td><a href="tel:<?=htmlentities($service->service_phone)?>"><?=htmlentities($service->service_phone)?></a></td>
                <td><a href="mailto:<?=htmlentities($service->service_mail)?>"><?=htmlentities($service->service_mail)?></a></td>
                <!-- <td>
                    <a href="/controllers/edit-patientCtrl.php?id=<?=htmlentities($service->id)?>"><i
                            class="far fa-edit mr-3"></i></a>
                    <a href="/controllers/delete-patientCtrl.php?id=<?=$result->id?>"><i class="fas fa-trash ml-3 fs-5"></i></a>
                </td> -->
            </tr>
            <?php } ?>

        </tbody>
    </table>
    </div>

<?php } ?>
<nav>
        <ul class="pagination justify-content-center pt-3 pb-3">
            <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                <a href="../../controllers/list-patientCtrl.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
            </li>
            <?php for ($page = 1; $page <= $pages; $page++) : ?>
                <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                    <a href="../../controllers/list-patientCtrl.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                </li>
            <?php endfor ?>
            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
            <li class="page-item <?= ($currentPage == $pages || $pages == 0) ? "disabled" : "" ?>">
                <a href="../../controllers/list-patientCtrl.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
            </li>
        </ul>
    </nav>