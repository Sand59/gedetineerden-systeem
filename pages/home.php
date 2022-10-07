<?php
$pageTitle = "Home";
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');
?>

<script>
    document.getElementById('aantal').innerHTML = "<?php echo "Status en laatste wijzigingen"; ?>";
</script>

<?php
$objGedetineerde = new Gedetineerde($dbconn);
$gedetineerde = $objGedetineerde->getGedetineerden();
$aantalGedetineerden = $gedetineerde->rowCount();

$objCellen = new Cellen($dbconn);
$cellen = $objCellen->getCellen();
$wijzigingen = $objCellen->getWijzigingen();
$aantalCellen = $cellen->rowCount();
?>


<div class='content status'>
    <div class="content-items">
        <h2>Status</h2>
        <?php if(!perm('GED_BEKIJKEN') && !perm('CEL_BEKIJKEN')): ?>
         <p>Je heb geen toegang om de status te bekijken</p>

         <?php else: ?>
            <div class='status-item'>
            <?php if(perm('GED_BEKIJKEN')): ?>
               <div class='status-items'>
                  <div class='status-top'>
                     <h2>Gedetineerden</h2>
                     <div class='status-img-wrapper'>
                           <a href='gedetineerden.php'><img src='/images/icons/arrow-right.png'></a>
                     </div>
                  </div>
                  <div class='status-content-row'>
                     <div class='status-content-col'>
                           <p>Aantal</p>
                     </div>
                     <div class='status-content-col'>
                           <p><?= $aantalGedetineerden ?> aanwezig</p>
                     </div>
                  </div>
               </div>
            <?php endif; ?>

            <?php if(perm('CEL_BEKIJKEN')): ?>
                <div class='status-items'>
                    <div class='status-top'>
                        <h2>Cellen</h2>
                        <div class='status-img-wrapper'>
                            <a href='cellen.php'><img src='/images/icons/arrow-right.png'></a>
                        </div>
                    </div>
                    <div class='status-content-row'>
                        <div class='status-content-col'>
                            <p>Beschikbaar</p>
                        </div>
                        <div class='status-content-col'>
                            <p><?= $aantalCellen ?> cellen</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
       
    </div>
    <div class="content-items">
        <h2>Laatste wijzigingen</h2>

        <?php if(perm('CEL_BEKIJKEN')): ?>

        <?php foreach ($wijzigingen as $row): ?>
            <div class="wijzigingen">
                <p><?= $row['naam']; ?> overgeplaatst naar <?= $row['cel_nummer']; ?></p>
                <p><?= $row['overplaatsing']; ?></p>
            </div>
        <?php endforeach; ?>

        <?php else: ?>
           <p>Je heb geen toegang om wijzigingen te bekijken</p>
        <?php endif; ?>

    </div>
</div>
