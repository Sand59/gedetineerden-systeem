<?php
$rol = strtolower(htmlspecialchars($_SESSION['rol'])) ?? null;
$url = $_SERVER['PHP_SELF'];

if (strpos($url,'/pages/home') !== false) {
    $home = "active";
}
else {
    $home = "";
}

if (strpos($url,'/pages/gedetineerde') !== false) {
    $gedetineerde = "active";
}
else {
    $gedetineerde = "";
}

if (strpos($url,'/pages/cel') !== false) {
    $cel = "active";
}
else {
    $cel = "";
}

if (strpos($url,'/pages/bezoeker') !== false) {
    $bezoeker = "active";
}
else {
    $bezoeker = "";
}

if (strpos($url,'/pages/zaken') !== false) {
    $zaken = "active";
}
else {
    $zaken = "";
}

if (strpos($url,'/pages/gebruiker') !== false) {
    $gebruiker = "active";
}
else {
    $gebruiker = "";
}

if (strpos($url,'/pages/rollen') !== false) {
   $rollen = "active";
}
else {
   $rollen = "";
}
?>

<div id="sidebar" class="sidebar">
   <ul>
      <li class="<?php echo $home ?>">
         <a href="/pages/home.php"><img src="/images/icons/menu/home.png" alt="">Home</a>
      </li>

      <?php if(perm('GED_BEKIJKEN')) {
         echo '<li class="'.$gedetineerde.'">
                  <a href="/pages/gedetineerden.php"><img src="/images/icons/menu/gedetineerde.png" alt="">Gedetineerden</a>
               </li>';
      } ?>

      <?php if(perm('CEL_BEKIJKEN')) {
         echo '<li class="'.$cel.'">
                  <a href="/pages/cellen.php"><img src="/images/icons/menu/cel.png" alt="">Cellen</a>
               </li>';
      } ?>

      <?php if(perm('BEZ_BEKIJKEN')) {
         echo '<li class="'.$bezoeker.'">
                  <a href="/pages/bezoekers.php"><img src="/images/icons/menu/bezoeker.png" alt="">Bezoekers</a>
               </li>';
      } ?>

      <?php if(perm('ZAKEN_BEKIJKEN')) {
         echo '<li class="'.$zaken.'">
                  <a href="/pages/zaken.php"><img src="/images/icons/menu/zaak.png" alt="">Zaken</a>
               </li>';
      } ?>

      <?php if(perm('GEB_BEKIJKEN')) {
         echo '<li class="'.$gebruiker.'">
                  <a href="/pages/gebruikers.php"><img src="/images/icons/menu/gebruiker.png" alt="">Gebruiker</a>
               </li>';
      } ?>

      <?php if(perm('ROL_AANPASSEN')) {
         echo '<li class="'.$rollen.'">
                  <a href="/pages/rollen.php"><img src="/images/icons/menu/rollen.png" alt="">Rollen</a>
               </li>';
      } ?>
   </ul>
</div>
