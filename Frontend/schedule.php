<?php
if (isset($_GET['a'])) {
  switch ($_GET['a']) {
    case 'dj':
      $pdo->exec("DELETE FROM job WHERE status=0 AND id_job=" . $_GET['idj']);
      break;
    case 'aj':
      $pdo->exec("INSERT INTO `job` (`target`, `type`, `nb_run`, `status`, `benchmark`) VALUES ('" . $_GET['target'] . "', '" . $_GET['type'] . "', '" . $_GET['run'] . "', '0', " . $_GET['bench'] . ");");
      break;
  }
}
?><h3 class="text-dark mb-4">Scheduling</h3>
<div class="card shadow">
  <div class="card-header py-3">
    <p class="text-primary m-0 fw-bold">Scheduled</p>
  </div>
  <div class="card-body">
    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
      <table class="table my-0" id="dataTable">
        <thead>
          <tr>
            <th>Status</th>
            <th>Target</th>
            <th>Type</th>
            <th>Nb of run</th>
            <th>Benchmark</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($pdo->query("SELECT * FROM job JOIN type ON job.type=type.id_type JOIN target ON job.target=target.id_target")->fetchAll(PDO::FETCH_ASSOC) as $job) {
          ?>
            <tr>
              <td><?php switch ($job['status']) {
                    case 0:
                      echo '<span class="badge rounded-pill text-bg-secondary">Waiting</span>';
                      break;
                    case 1:
                      echo '<span class="badge rounded-pill text-bg-primary">Running</span>';
                      break;
                    case 2:
                      echo '<span class="badge rounded-pill text-bg-success">Finished</span>';
                      break;
                    case 3:
                      echo '<span class="badge rounded-pill text-bg-danger">Failed</span>';
                      break;
                  } ?></td>
              <td><?php echo "<a href=\"/?p=t&ids=" . $job['system'] . "\">" . $job['ip'] . "</a>" ?></td>
              <td><?php echo $job['name'] ?></td>
              <td><?php echo $job['nb_run'] ?></td>
              <td><?php if ($job['benchmark'] == null) {
                    echo "All";
                  } else {
                    echo $pdo->query("SELECT * FROM benchmark WHERE id_bench=" . $job['benchmark'])->fetch(PDO::FETCH_ASSOC)['name'];
                  } ?></td>
              <td>
                <?php if ($job['status'] == 0) { ?> <a href="/?p=p&a=dj&idj=<?php echo $job['id_job'] ?>"><button class="btn btn-danger">Delete</button></a> <?php } ?>
              </td>
            </tr>
          <?php
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>
</div><br>
<div class="card shadow">
  <div class="card-header py-3">
    <p class="text-primary m-0 fw-bold">Add a job</p>
  </div>
  <div class="card-body">
    <form method="get">
      <input type="hidden" value="p" name="p">
      <input type="hidden" value="aj" name="a">
      <div class="form-group">
        <label for="target">Target</label>
        <select class="form-control" id="target" name="target" required>
          <?php
          foreach ($pdo->query("SELECT * FROM target")->fetchAll(PDO::FETCH_ASSOC) as $t) {
            echo '<option value="' . $t['id_target'] . '">' . $t['ip'] . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="type">Type</label>
        <select class="form-control" id="type" name="type" required>
          <?php
          foreach ($pdo->query("SELECT * FROM type")->fetchAll(PDO::FETCH_ASSOC) as $t) {
            echo '<option value="' . $t['id_type'] . '">' . $t['name'] . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="run">Nb of run</label>
        <input type="number" min="1" value="20" class="form-control" id="run" name="run" required>
      </div>
      <div class="form-group">
        <label for="bench">Benchmark</label>
        <select class="form-control" id="bench" name="bench" required>
          <option value="NULL" selected>All</option>
          <?php
          foreach ($pdo->query("SELECT * FROM benchmark")->fetchAll(PDO::FETCH_ASSOC) as $b) {
            echo '<option value="' . $b['id_bench'] . '">' . $b['name'] . '</option>';
          }
          ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </div>
</div>