<style>
  .nav-link.active {
    color: rgb(13, 110, 253) !important
  }
</style>

<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-white shadow-sm py-3">
  <div class="container">
    <a class="navbar-brand text-primary text-capitalize" href="/"> Gestion du personnel <i class="bi-person"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= isset($title) && $title == 'Employes' ? ' active ' : ''  ?>" href="../employes/index.php">Acceuil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= isset($title) && $title == 'Affectation' ? ' active ' : ''  ?>" href="../affectations/index.php">Affectations</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= isset($title) && $title == 'Metiers' ? ' active ' : ''  ?>" href="../metiers/index.php">Metiers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= isset($title) && $title == 'Services' ? ' active ' : ''  ?>" href="../services/index.php">Services</a>
        </li>
      </ul>
    </div>
  </div>
</nav>