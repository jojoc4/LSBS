<?php
if (isset($_GET['a'])) {
  switch ($_GET['a']) {
    case 'as':
      $pdo->exec("INSERT INTO `system` (`cpu`, `memory`, `disk`, `network`, `gpu`, `uuid`) VALUES ('" . addslashes($_GET['cpu']) . "', '" . addslashes($_GET['memory']) . "', '" . addslashes($_GET['disk']) . "', '" . addslashes($_GET['network']) . "', '" . addslashes($_GET['gpu']) . "', '" . addslashes(uniqid()) . "');");
      break;
    case 'ds':
      $pdo->exec("DELETE FROM `system` WHERE id_system=" . $_GET['ids']);
      break;
  }
}
?>
<h3 class="text-dark mb-4">Systems</h3>
<div class="card shadow">
  <div class="card-body">
    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
      <table class="table my-0" id="dataTable">
        <thead>
          <tr>
            <th>CPU</th>
            <th>Memory</th>
            <th>Disk</th>
            <th>Network</th>
            <th>GPU</th>
            <th>Nb of target</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($pdo->query("SELECT * FROM system")->fetchAll(PDO::FETCH_ASSOC) as $sys) {
          ?>
            <tr>
              <td><?php echo $sys['cpu'] ?></td>
              <td><?php echo $sys['memory'] ?></td>
              <td><?php echo $sys['disk'] ?></td>
              <td><?php echo $sys['network'] ?></td>
              <td><?php echo $sys['gpu'] ?></td>
              <td><?php echo $pdo->query("SELECT COUNT(id_target) AS c FROM target WHERE system=" . $sys['id_system'])->fetch(PDO::FETCH_ASSOC)['c'] ?></td>
              <td><a href="/?p=t&ids=<?php echo $sys['id_system'] ?>"><button class="btn btn-primary">Target</button></a><?php if ($pdo->query("SELECT COUNT(id_target) AS c FROM target WHERE system=" . $sys['id_system'])->fetch(PDO::FETCH_ASSOC)['c'] == 0) { ?> <a href="/?p=s&a=ds&ids=<?php echo $sys['id_system'] ?>"><button class="btn btn-danger">Delete</button></a> <?php } ?></td>
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
    <p class="text-primary m-0 fw-bold">Add a system</p>
  </div>
  <div class="card-body">
    <form method="get">
      <input type="hidden" value="s" name="p">
      <input type="hidden" value="as" name="a">
      <div class="form-group">
        <label for="cpu">CPU</label>
        <input type="text" class="form-control" id="cpu" name="cpu" required>
      </div>
      <div class="form-group">
        <label for="memory">Memory</label>
        <input type="text" class="form-control" id="memory" name="memory" required>
      </div>
      <div class="form-group">
        <label for="disk">Disk</label>
        <input type="text" class="form-control" id="disk" name="disk" required>
      </div>
      <div class="form-group">
        <label for="network">Network</label>
        <input type="text" class="form-control" id="network" name="network" required>
      </div>
      <div class="form-group">
        <label for="gpu">GPU</label>
        <input type="text" class="form-control" id="gpu" name="gpu" placeholder="Empty if none">
      </div>
      <button type="submit" class="btn btn-primary">Add</button>
    </form>
  </div>
</div>