<!-- Affichage d'un message d'erreur personnalisé -->
<?php if (isset($errors['global'])) { ?>

    <div class="alert alert-warning" role="alert">
        <?= nl2br($errors['global']) ?>
    </div>

<?php } ?>

<!-- -------------------------------------------- -->

<div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <h1 class="text-primary mb-5"><?= (isset($id)) ? 'Modifier' : 'Ajouter'?> un rdv</h1>
                <!-- On peut ajouter un attribut 'novalidate' dans la balise form pour désactiver temporairement tous les required et pattern -->
                <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>?id=<?= $id ?? '' ?>" novalidate>

                    <div class="form-floating mb-4">
                        <label for="date" class="form-label">Date*</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?= isset($appointmentObj) ? date('Y-m-d', strtotime($appointmentObj->dateHour)) : '' ?>" required>
                        <div class="error"><?= $errors['date_error'] ?? '' ?></div>
                    </div>
                                

                    <div class="form-floating mb-4">
                        <label for="hour" class="form-label">Heure*</label>
                        <select class="form-select" name="hour" id="hour" required>
                            <?php
                            for ($i = 3; $i <= 20; $i++) {
                                $isSelected = isset($appointmentObj) && date('H', strtotime($appointmentObj->dateHour)) == $i ? 'selected' : '';
                                echo '<option value="' . $i . '" ' . $isSelected . '>' . $i . 'h</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-floating mb-4">
                        
                        <label for="min" class="form-label">Minutes*</label>
                        <select class="form-select" name="min" id="min" required>
                            <?php
                            for ($i = 0; $i <= 45; $i += 15) {
                                $isSelected = isset($appointmentObj) && date('i', strtotime($appointmentObj->dateHour)) == $i ? 'selected' : '';
                                echo '<option value="' . $i . '" ' . $isSelected . '>' . $i . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-floating mb-4">
                        <label for="idPatients" class="form-label">Patient*</label>
                        <select class="form-select col-4" name="idPatients" id="idPatients" required>
                            <?php
                            foreach ($allPatients as $patient) {
                                $state = isset($appointmentObj) && ($patient->id == $appointmentObj->idPatients) ? "selected" : "";
                                echo '<option value="' . $patient->id . '" ' .  $state  . '>' . $patient->lastname . ' ' . $patient->firstname . '</option>';
                            } ?>

                        </select>
                        <div class="error"><?= $errors['idPatients_error'] ?? '' ?></div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Enregistrer le rendez-vous</button>
                    </div>
                </form>
            </div>
        </div>
</div>