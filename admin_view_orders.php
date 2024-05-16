<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OG Tech PC - Admin View Orders</title>
</head>
<?php
  include "header.php";
  include "static/pages/side_nav.html";
  include "static/pages/admin_nav.php";
?>
<body>
  <!-- manage users -->
  <div class="container" style="margin-top: 150px">
    <h3 class="page-title white-text">View Customers Cart/Orders </h3>
    <div class="row" style="padding-bottom: 10px;">
      <div class="rounded-card-parent">
        <div class="card rounded-card">
          <div class="card-content white-text">
            <span class="orange-text center" style="font-size: 24px">
              Customers Orders List - Sorted by latest 
              <small style="font-size: 20px; margin-top: 10px">(Autosync table)</small>
            </span>
            <form class="row" action="admin_view_orders.php" method="POST" style="margin: 0px;">
              <div class="input-field col s3 white-text">
                <input name="search_members" id="search_members" type="text" class="validate; white-text" maxlength="20">
                <label for="search_members">Search member by Name or Email</label>
                <span class="helper-text" data-error="text only" data-success="correct"></span>
              </div>
            </form>
            <div class="grid" style="margin-right: 300px">
              <div class="grid" style="margin-right: 150px">
                <h6 class="blue-text bold center">Username</h6>
              </div>
              <div class="grid" style="margin-right: 150px">
                <h6 class="blue-text bold center">Email</h6>
              </div>
              <div class="grid" style="margin-right: 150px">
                <h6 class="blue-text bold center">OrderID</h6>
              </div>
              <div class="grid" style="margin-right: 150px">
                <h6 class="blue-text bold center">Payment Date</h6>
              </div>
            </div>
            <table class='responsive-table' style='table-layout: fixed; width: 100%;' id='pagination'>
              <tbody>
                <?php 
                  $admin = new adminContr(); 
                  $admin->showSearchMember();
                ?>
              </tbody>
            </table>
