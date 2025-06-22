      <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
          <div class="">© 2025 All rights reserved by Team 467</div>
          <div>Done by Dorcas Mbonyimbuga.</div>
        </div>
      </footer>
    </div>
  </div>


  <!-- Conteneur alert -->
  <div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1055; width: 320px;"></div>

<!-- 1. Inclusion des modals (HTML, pas encore de JS ici) -->
<?php include '../process/modals.php'; ?>

<!-- 2. jQuery (toujours d'abord) -->
<script src="../assets/js/core/jquery-3.7.1.min.js"></script>

<!-- 3. Bootstrap et ses dépendances -->
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>

<!-- 4. SweetAlert2 (important avant main.js !) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- 5. Autres plugins JS -->
<script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="../assets/js/plugin/datatables/datatables.min.js"></script>

<!-- 6. Kaiadmin JS (si nécessaire pour l’UI) -->
<script src="../assets/js/kaiadmin.min.js"></script>

<!-- 7. Ton script principal contenant toute la logique AJAX -->
<script src="../process/main.js"></script>



</body>

</html>