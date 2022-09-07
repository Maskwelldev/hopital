<!-- Main Content -->
<div id="content">

<?php if(isset($errorsArray['global'])) {?>

    <div class="alert alert-warning" role="alert">
        <?= nl2br($errorsArray['global'])?>
    </div>

<?php } else { ?>
    <h1 class="h2 text-primary mb-3">Liste des médecins</h1>

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
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Spécialité</th>
                <th scope="col">Email</th>
                <th scope="col">Téléphone</th>
            </tr>
        </thead>
        <tbody>

        <?php 
        foreach($results as $result) {
            ?>
            <tr>
                <td><?=htmlentities($result->lname)?></td>
                <td><?=htmlentities($result->fname)?></td>
                <td><?=htmlentities($result->name)?></td>
                <td><a href="mailto:<?=htmlentities($result->mail)?>"><?=htmlentities($result->mail)?></a></td>
                <td><a href="tel:<?=htmlentities($result->phone)?>"><?=htmlentities($result->phone)?></td>
                <td>
                    <a href="/controllers/edit-patientCtrl.php?id=<?=htmlentities($result->id)?>"><i
                            class="far fa-edit"></i></a>
                    <a href="/controllers/delete-patientCtrl.php?id=<?=$result->id?>"><i class="fas fa-trash fs-5"></i></a>
                </td>
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