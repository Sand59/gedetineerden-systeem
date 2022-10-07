<?php
$pageTitle = 'Bezoekers';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
else {
    header('location: ../bezoekers.php');
}

$objBezoeker = new Bezoeker($dbconn);
$bezoekers = $objBezoeker->getBezoeker($id);
$aantal = $bezoekers->rowCount();

echo '<div class="content">';
?>

<?php if(perm('BEZ_BEKIJKEN')): ?>

<table class="flex-table no-photo">
    <thead>
        <tr>
            <th>Naam</th>
            <th>Datum</th>
            <th>Van</th>
            <th>Tot</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

<?php
$table = '';
if ($aantal > 0) {
    foreach ($bezoekers as $row) {
        $table .= "<tr>
                            <td data-label='Naam'>".$row['naam']."</td>
                            <td data-label='Datum'>".$row['datum']."</td>
                            <td data-label='Van'>".$row['tijd_van']."</td>
                            <td data-label='Tot'>".$row['tijd_tot']."</td>
                            <td><a href='mailto:{$row['email']}'>Contact</a></td>
                          </tr>";
    }
}

else {
    $table = '<tr>
                        <td>Geen bezoekers geregistreerd</td>
                    </tr>';
}

$table .= '</table></tbody>';
echo $table;
?>

<div class="add">
    <a href="new.php?id=<?= $id ?>">Nieuwe bezoeker<img src="/images/icons/new.png"></a>
</div>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om dit te bekijken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>

<?php
echo '</div>';
include '../../include/footer.php';
?>
