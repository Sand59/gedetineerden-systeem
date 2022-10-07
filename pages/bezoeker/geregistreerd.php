<?php
$pageTitle = 'Bezoekers';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

$objBezoeker = new Bezoeker($dbconn);
$bezoekers = $objBezoeker->getBezoekers();

echo '<div class="content">';
?>

<?php if(perm('BEZ_BEKIJKEN')): ?>

<table class="flex-table no-photo">
    <thead>
        <tr>
            <th>Naam</th>
            <th>RFID ID</th>
            <th>Aankomst</th>
            <th>Vertrek</th>
            <th>Ingecheckt</th>
        </tr>
    </thead>
    <tbody>

<?php
$html = '';
foreach ($bezoekers as $row) {
    $html .= "<tr>
                <td data-label='Naam'>".$row['naam']."</td>
                <td data-label='RFID ID'>".$row['rfid_id']."</td>
                <td data-label='Aankomst'>".$row['aankomst']."</td>
                <td data-label='Vertrek'>".$row['vertrek']."</td>
                <td data-label='Ingecheckt'>".$row['ingecheckt']."</td>
              </tr>";
}

$html .= '</table></tbody>';
echo $html;
?>

<div class="add">
    <a href="/pages\bezoeker\geregistreerd\new.php">Registreer een nieuwe druppel<img src="/images/icons/new.png"></a>
</div>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om dit te bekijken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>
