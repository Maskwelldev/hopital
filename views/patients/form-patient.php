<!-- Main Content -->
<div id="content">

<?php if(isset($errors['global'])) {?>
    
    <div class="alert alert-warning" role="alert">
        <?= nl2br($errors['global'])?>
    </div>

<?php } 

// Si le patient existe (update, ou si ajout d'un nouveau patient)
if ($patient){
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <h1 class="h2 text-primary mb-5"><?= (isset($id)) ? 'Modifier' : 'Ajouter'?> un patient</h1>
                <!-- On peut ajouter un attribut 'novalidate' dans la balise form pour désactiver temporairement tous les required et pattern -->
                <form class="mb-5" novalidate method="POST" action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>?id=<?=$id ?? ''?>">
                
                    <div class="form-floating mb-4">
                        <label for="lastname" class="form-label">Nom*</label>
                        <input
                            type="text"
                            value="<?= $patient->lastname ?? $lastname ?? '' ?>" 
                            class="form-control <?= isset($errors['lastname']) ? 'is-invalid' : ''?>" 
                            id="lastname" 
                            name="lastname" 
                            required
                            pattern="<?=REGEXP_STR_NO_NUMBER?>"
                            placeholder="Dupond"
                            />
                        <div class="error"><?=$errors['lastname'] ?? ''?></div>
                    </div>

                    <div class="form-floating mb-4">
                        <label for="firstname" class="form-label">Prénom*</label>
                        <input 
                            type="text" 
                            value="<?= $patient->firstname ?? $firstname ?? '' ?>" 
                            class="form-control <?= isset($errors['firstname']) ? 'is-invalid' : ''?>" 
                            id="firstname" 
                            required 
                            name="firstname"  
                            required
                            pattern="<?=REGEXP_STR_NO_NUMBER?>"
                            placeholder="Jean"
                            />
                        <div class="error"><?=$errors['firstname'] ?? ''?></div>
                    </div>    

                    <div class="form-floating mb-4">
                        <label for="mail" class="form-label">Email*</label>
                        <input 
                            type="email"
                            autocomplete="email"
                            value="<?= $patient->mail ?? $mail ?? '' ?>" 
                            class="form-control <?= isset($errors['mail']) ? 'is-invalid' : ''?>"
                            id="mail" 
                            name="mail" 
                            required 
                            placeholder="dupondjean@gmail.com"
                            />
                        <div class="error"><?=$errors['mail'] ?? ''?></div>
                    </div>

                    <div class="form-floating mb-4">
                        <label for="birthdate" class="form-label">Date de naissance*</label>
                        <input 
                            type="date" 
                            value="<?= $patient->birthdate ?? $birthdate ?? '' ?>" 
                            class="form-control <?= isset($errors['birthdate']) ? 'is-invalid' : ''?>" 
                            id="birthdate" 
                            name="birthdate" 
                            required
                            />
                        <div class="error"><?=$errors['birthdate'] ?? ''?></div>
                    </div>

                    <div class="form-floating mb-4">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input 
                            type="text" 
                            value="<?= $patient->phone ?? $phone ?? '' ?>" 
                            class="form-control <?= isset($errors['phone']) ? 'is-invalid' : ''?>" 
                            id="phone" 
                            name="phone" 
                            pattern="<?=REGEXP_PHONE?>"
                            placeholder="06XXXXXXXX"
                        />
                        <div class="invalid-feedback-2"><?=$errors['phone'] ?? ''?></div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Enregistrer le patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php }