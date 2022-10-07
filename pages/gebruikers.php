<?php
$pageTitle = 'Gebruikers';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

$objGebruiker = new Gebruiker($dbconn);
$gebruikers = $objGebruiker->getGebruikers();
$aantal = $gebruikers->rowCount();
?>

<script>
    document.getElementById('aantal').innerHTML = "<?php echo $aantal . ' records gevonden'; ?>";
</script>

<?php
echo '<div class="content">';
?>

<?php if(perm('GEB_BEKIJKEN')): ?>

<table class="flex-table">
    <thead>
        <tr>
            <th></th>
            <th>Naam</th>
            <th>Email</th>
            <th>Rol</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

<?php
$table = '';
if ($aantal > 0) {
    foreach ($gebruikers as $row) {
      if(perm('GEB_BEWERKEN')) { 
         $edit = "<a class='edit-dark' href='/pages/gebruiker/edit.php?id=".$row['id']."'><img src='/images/icons/edit-dark.png'></a>"; 
      } else {
         $edit = '';
      }
        $table .= "<tr>
                      <td><div class='image-wrapper-table'><img src='/images/fotos/foto-01.jpg'></div></td>
                      <td data-label='Naam'>".$row['naam']."</td>
                      <td data-label='Email'>".$row['email']."</td>
                      <td data-label='Rol'>".$row['rol']."</td>
                      <td><div class='image-wrapper-link'><a href='mailto:".$row['naam']."'>Contact</a><img src='/images/icons/mail.png'></div>".$edit."</td>
                  </tr>";
    }
}

else {
    $table = '<tr>
                  <td>Geen gegevens</td>
              </tr>';
}

$table .= '</table></tbody>';
echo $table;
echo '</div>';
?>

<div class="add">
    <a href="gebruiker/new.php">Nieuwe gebruiker<img src="/images/icons/new.png"></a>
</div>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om dit te bekijken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>

<?php
include '../include/footer.php';
?>

