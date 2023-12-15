<div id="sidebar">
  <div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
      <div class="d-flex justify-content-between align-items-center">
        <div class="logo">
          <a href="index.php">
            <img src="logo.webp" alt="Logo" />
          </a>
        </div>
        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
          <div class="form-check form-switch fs-6">
            <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer" />
            <label class="form-check-label"></label>
          </div>

        </div>
        <div class="sidebar-toggler x">
          <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
        </div>
      </div>
    </div>
    <div class="sidebar-menu">
      <ul class="menu">
        <li class="sidebar-item">
          <a href="index.php" class="sidebar-link">
            <i class="bi bi-house"></i>
            <span>Inicio</span>
          </a>
        </li>
        <li class="sidebar-item has-sub">
          <a href="#" class="sidebar-link">
            <i class="bi bi-capsule"></i>
            <span>Medicamentos</span>
          </a>
          <ul class="submenu">
            <!-- <li class="submenu-item">
              <a href="nuevo_medicamento.php" class="submenu-link">Nuevo</a>
            </li> -->
            <li class="submenu-item">
              <a href="ver_medicamentos.php" class="submenu-link">Ver o Editar</a>
            </li>
          </ul>
        </li>
        <li class="sidebar-item has-sub">
          <a href="#" class="sidebar-link">
            <i class="bi bi-heart-pulse"></i>
            <span>Procedimientos</span>
          </a>
          <ul class="submenu">
            <li class="submenu-item">
              <a href="new_procedure.php" class="submenu-link">Nuevo</a>
            </li>

            <li class="submenu-item">
              <a href="view_procedures.php" class="submenu-link">Ver o Editar</a>
            </li>
          </ul>
        </li>
        <li class="sidebar-item">
          <a href="inventory/index.php" class="sidebar-link">
            <i class="bi bi-prescription2"></i>
            <span>Inventario</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="logout.php" class="sidebar-link">
            <i class="bi bi-box-arrow-right"></i>
            <span>Cerrar Sesión</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>