<div class="d-sm-flex justify-content-between align-items-center mb-4">
  <h3 class="text-dark mb-0">Dashboard</h3>
</div>
<div class="row">
  <div class="col-md-6 col-xl-3 mb-4">
    <div class="card shadow border-start-primary py-2">
      <div class="card-body">
        <div class="row align-items-center no-gutters">
          <div class="col me-2">
            <div class="text-uppercase text-primary fw-bold text-xs mb-1">
              <span>Number of tasks running</span>
            </div>
            <div class="text-dark fw-bold h5 mb-0">
              <span>
                <?php
                echo $pdo->query("SELECT COUNT(*) as c FROM job WHERE status=1")->fetch(PDO::FETCH_ASSOC)['c'];
                ?>
              </span>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-play fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-3 mb-4">
    <div class="card shadow border-start-primary py-2">
      <div class="card-body">
        <div class="row align-items-center no-gutters">
          <div class="col me-2">
            <div class="text-uppercase text-primary fw-bold text-xs mb-1">
              <span>Number of tasks waiting</span>
            </div>
            <div class="text-dark fw-bold h5 mb-0">
              <span>
                <?php
                echo $pdo->query("SELECT COUNT(*) as c FROM job WHERE status=0")->fetch(PDO::FETCH_ASSOC)['c'];
                ?>
              </span>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-pause fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-3 mb-4">
    <div class="card shadow border-start-primary py-2">
      <div class="card-body">
        <div class="row align-items-center no-gutters">
          <div class="col me-2">
            <div class="text-uppercase text-primary fw-bold text-xs mb-1">
              <span>Number of target</span>
            </div>
            <div class="text-dark fw-bold h5 mb-0">
              <span>
                <?php
                echo $pdo->query("SELECT COUNT(*) as c FROM target")->fetch(PDO::FETCH_ASSOC)['c'];
                ?>
              </span>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-server fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>