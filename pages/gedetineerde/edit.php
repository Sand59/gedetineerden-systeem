<?php
$pageTitle = 'Bewerken';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
else {
    header('location: ../gedetineerden.php');
}
?>

<div class="profiel-wrapper">

    <?php if(perm('GED_BEWERKEN')): ?>

    <div class="profiel-image-wrapper">
        <img src="../../images/profiel/gedetineerde.png">
    </div>
    <div class="profiel-gegevens no-border">
        <h2>Gegevens</h2>
        <form action="../../functions/verwerken.php?id=<?= $id ?>" method="POST">
            <input type="hidden" name="action" value="updateGedetineerde">
            <table class="profiel-edit-table">

<?php
$objGedetineerde = new Gedetineerde($dbconn);
$gedetineerde = $objGedetineerde->getGedetineerde($id);
$aantal = $gedetineerde->rowCount();

$table = '';
if ($aantal > 0) {
    foreach ($gedetineerde as $row) {
        $table .= "       <tr>
                            <th>Naam</th>
                            <td><input id='naam' type='text' name='naam' value='".$row["naam"]."' required></td>
                          </tr>
                          <tr>
                            <th>Geboortedatum</th>
                            <td><input id='geboortedatum' type='date' min='1920-01-01' name='geboortedatum' value='".$row["geboortedatum"]."'></td>
                          </tr>
                          <tr>
                            <th>Geslacht</th>
                            <td>
                            <select id='geslacht' name='geslacht' class='custom-select'>
                                <option value='".$row["geslacht"]."'>Geselecteerd: ".$row["geslacht"]."</option>
                                <option value='Man'>Man</option>
                                <option value='Vrouw'>Vrouw</option>
                                <option value='Anders'>Anders</option>
                            </select>
                            </td>
                          </tr>
                          <tr>
                              <th>Huidige cel</th>
                              <td>
                              <! -- loop database -->
                              <select id='huidige_cel' name='huidige_cel' class='custom-select'>
                                   <option value='".$row["huidige_cel"]."'>Huidige cel: ".$row["huidige_cel"]."</option>
                                   <option value='A1'>A1</option>
                                   <option value='A2'>A2</option>
                                   <option value='A3'>A3</option>
                                   <option value='B1'>B1</option>
                                   <option value='B2'>B2</option>
                               </select>
                               </td>
                          </tr>
                          <tr>
                            <th>Celgeschiedenis</th>
                            <td data-label='Celgeschiedenis'>Dit kan je niet bewerken</td>
                          </tr>
                          <tr>
                            <th>BSN-nummer 11 check</th>
                            <td><input id='bsn-nummer' name='bsn_nummer' type='text' value='".$row["bsn_nummer"]."' required maxlength='9'></td>
                          </tr>
                          <tr>
                            <th>Zaken</th>
                            <td><a href='zaken/view.php?id={$row['id']}'>Bekijk</a></td>
                          </tr>
                          <tr>
                            <th>Gedrag</th>
                            <td>
                              <select id='gedrag' name='gedrag' class='custom-select'>
                                <option value='".$row["gedrag"]."'>Huidig gedrag: ".$row["gedrag"]."</option>
                                <option value='Goed'>Goed</option>
                                <option value='Matig'>Matig</option>
                                <option value='Slecht'>Slecht</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <th>Bezoekers</th>
                            <td data-label='Bezoekers'>Dit kan je niet bewerken</td>
                          </tr>
                          <tr>
                            <th>Arrestatie</th>
                            <td><input id='datum_arrestatie' type='date' min='1920-01-01' name='datum_arrestatie' value='".$row["datum_arrestatie"]."'></td>
                          </tr>
                          <tr>
                            <th>Aankomst</th>
                            <td><input id='datum_aankomst' type='date' min='1920-01-01' name='datum_aankomst' value='".$row["datum_aankomst"]."'></td>
                          </tr>
                          <tr>
                            <th>Vrijlating</th>
                            <td><input id='datum_vrijlating' type='date' min='1920-01-01' name='datum_vrijlating' value='".$row["datum_vrijlating"]."'></td>
                          </tr>
                          <tr>
                            <th></th>
                            <td></td>
                          </tr>";
    }
}

else {
    $table = '<tr>
                        <td>Geen gegevens</td>
                     </tr>';
}

$table .= '<tr>
                     <th>
                        <button class="button" onclick="checkBsn()" type="submit" name="submit">Opslaan<img src="/images/icons/save.png"></button>
                     <th>
                  </tr>';
$table .= '</table>';
?>

<script>
  // todo: php validation
  function checkBsn() {  
    F=s=>!(i=1,t=s.reduceRight((t,v)=>t-v*++i),!t|t%11|(i|1)-9);

    [document.getElementById('bsn-nummer').value].forEach(t => {
      var r = F([...t]);
      console.log(t, r)

      if(r == false) {
        alert('Het BSN nummer is niet geldig...');
        event.preventDefault();
        btnError.style.display = 'block'
      }
    })
  }
</script>

<?php 
$table.='</form>';
echo $table;
?>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om dit te bewerken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>

<?php
echo "</div></div>";

include '../../include/footer.php';
?>
