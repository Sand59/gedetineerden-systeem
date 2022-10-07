<?php
$pageTitle = "Rollen beheer";
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

$objPermissions = new Permissions($dbconn);

// get rollen
$rollen = $objPermissions->getRollen();
?>

<div class="content">
   <?php if(perm('ROL_AANPASSEN')): ?>
      <form action="/functions/verwerken.php" method="POST">
         <input type="hidden" name="action" value="updateRol">

         <div class="permissions" id="permissions">
            <?php foreach($rollen as $row): ?>
               <div class="permissions-col">
                  <div class="permissions-top">
                     <span id="contenteditable" class="rol-title" data-id="<?= $row['id']; ?>" role="textbox" maxlenght="2" contenteditable="true"><?= $row['rol']; ?></span>
                     <div class="permissions-top-image">
                        <img class="remove" data-id="<?= $row['id']; ?>" src="/images/icons/trash-red.png" alt="">
                     </div>
                  </div>
                  <?php $permissions = $objPermissions->getPermissions(); ?>
                  <?php foreach($permissions as $row2): ?>
                  
                  <!-- loop permissions -->
                  <?php $check = $objPermissions->checkPermissions($row['id'], $row2['perm_id']); ?> 
                     <div class="permissions-items">
                     <label class="container">
                        <input id="<?= $row['rol'].$row2['perm_id']; ?>" type="checkbox" name="<?= $row['rol'].$row2['perm_id']; ?>"
                           <?php foreach ($check as $row3) { echo "checked"; } ?>
                        >
                        <span class="checkmark"></span>
                        <label for="<?= $row['rol'].$row2['perm_id']; ?>"><?= $row2['perm_desc']; ?></label>
                     </div>
                  </label>
                  <?php endforeach; ?>
               </div>
            <?php endforeach; ?>
            <div class="permissions-col">
               <div class="permissions-last" id="add">
                  <img src="/images/icons/new-role.png" alt="">
               </div>
            </div>
         </div>
         <button class="button" type="submit" name="submit">Save<img src="/images/icons/save.png"></button>
      </form>
   <?php else: ?>
      <p>Je hebt niet de juiste rechten om dit te bekijken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
   <?php endif; ?>
</div>


<div class="overlay" id="overlay-remove">
   <div class="alert">
      <div class="alert-items">
         <h3>Weet je zeker dat je deze rol wilt verwijderen?</h3>
         <p>Als je het verwijderd is er geen enkele manier om alles terug te halen</p>
         <div class="button-wrapper">
            <div class="button-1" id="remove">Verwijder</div>
            <div class="button-2" id="close">Annuleer</div>
         </div>
      </div>
   </div>
</div>

<script>
   // add max request
   $(".rol-title").keyup(function(){
      const id = $(this).data("id")
      const rol = $(this).text()

      setTimeout(function(){
         $.ajax({
            url: 'https://www.43383.hbcdeveloper.nl/pages/rollen/update.php',
            type: 'POST',
            data: {
               id: id,
               rol: rol
            }
         })
      }, 2000)
   })

   const overlayRemove = document.getElementById('overlay-remove')
   const permissions = document.getElementById('permissions')
   
   const height = $(".permissions-col").height()
   $(".permissions-last").height(height)

   $("#add").click(function(){
      $.ajax({
         url: 'https://www.43383.hbcdeveloper.nl/pages/rollen/add.php',
         type: 'POST',
         success: function(response){
            window.location.reload()
         }
      })
   })

   $(".remove").click(function(){
      const id = $(this).data("id")
      overlayRemove.style.display = 'flex'
      
      $("#remove").click(function(){
         $.ajax({
            url: 'https://www.43383.hbcdeveloper.nl/pages/rollen/delete.php?id=' + id, 
            type: 'POST',
            success: function(response){
               window.location.reload()
            }
         })
      })
   })

   $("#close").click(function(){
      overlayRemove.style.display = 'none'
   })
</script>