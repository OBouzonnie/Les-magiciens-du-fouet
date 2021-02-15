<!-- Template des cartes affichées sur la page d'index et les paginations de la liste de toutes les recettes -->

<?php 
    require_once('./classes/recette.class.php')
?>

<a class="card" href="recette.php?id=<?= $data->idRecette ?>">
    <figure>
        <img class="card-img" src="./images/<?= $data->idRecette ?>.jpg" alt="image du plat">
    </figure>               
    <div class="card-content">
        <div class="level">
            <div>
                <?= Recette::euro($data->cout) ?>
            </div>
            <div>
                <?= Recette::fouet($data->difficulte) ?>
            </div>
        </div>
        <h3><?= $data->titre ?></h3>
        <h4>par <?= $data->prenom ?> <?= $data->nom ?></h4>
        <h5><span><?= Recette::temps($data->temps) ?></span><span>pour <?= $data->nbreConvives ?> personnes</span></h5>
        <p><?= $data->description ?></p>
    </div>
</a>
