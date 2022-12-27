<?php
if (isset($_GET['a'])) {
    switch ($_GET['a']) {
        case 'at':
            $pdo->exec("INSERT INTO `target` (`system`, `ip`) VALUES ('" . $_GET['ids'] . "', '" . $_GET['ip'] . "');");
            break;
        case 'dt':
            $pdo->exec("DELETE FROM `target` WHERE id_target=" . $_GET['idt']);
            break;
    }
}
?>
<h3 class="text-dark mb-4">Target</h3>
<div class="card shadow">
    <div class="card-header py-3">
        <p class="text-primary m-0 fw-bold">System</p>
    </div>
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sys = $pdo->query("SELECT * FROM system WHERE id_system=" . $_GET['ids'])->fetch(PDO::FETCH_ASSOC)
                    ?>
                    <tr>
                        <td><?php echo $sys['cpu'] ?></td>
                        <td><?php echo $sys['memory'] ?></td>
                        <td><?php echo $sys['disk'] ?></td>
                        <td><?php echo $sys['network'] ?></td>
                        <td><?php echo $sys['gpu'] ?></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div><br>
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
            <table class="table my-0" id="dataTable">
                <thead>
                    <tr>
                        <th>IP</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($pdo->query("SELECT * FROM target WHERE system=" . $_GET['ids'])->fetchAll(PDO::FETCH_ASSOC) as $targ) {
                    ?>
                        <tr>
                            <td><?php echo $targ['ip'] ?></td>
                            <td><?php if ($pdo->query("SELECT COUNT(id_job) AS c FROM job WHERE target=" . $targ['id_target'])->fetch(PDO::FETCH_ASSOC)['c'] == 0) { ?> <a href="/?p=t&a=dt&ids=<?php echo $_GET['ids'] . "&idt=" . $targ['id_target'] ?>"><button class="btn btn-danger">Delete</button></a> <?php } ?></td>
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
        <p class="text-primary m-0 fw-bold">Add a target</p>
    </div>
    <div class="card-body">
        <form method="get">
            <input type="hidden" value="t" name="p">
            <input type="hidden" value="at" name="a">
            <input type="hidden" value="<?php echo $_GET['ids'] ?>" name="ids">
            <div class="form-group">
                <label for="ip">IP</label>
                <input type="text" class="form-control" id="ip" name="ip" required>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</div>