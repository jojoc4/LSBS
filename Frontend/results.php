<h3 class="text-dark mb-4">Results</h3>
<div class="card shadow">
  <div class="card-header py-3">
    <p class="text-primary m-0 fw-bold">Verify results</p>
  </div>
  <div class="card-body">
    <div class="row">
      <form method="get">
        <input type="hidden" value="r" name="p">
        <input type="hidden" value="0" name="t">
        <div class="form-group">
          <label for="system">System</label>
          <select class="form-control" id="system" name="system" required>
            <?php
            foreach ($pdo->query("SELECT * FROM target")->fetchAll(PDO::FETCH_ASSOC) as $t) {
              if (isset($_GET['system']) && $_GET['system'] == $t['system']) {
                echo '<option value="' . $t['system'] . '" selected>' . $t['ip'] . '</option>';
              } else {
                echo '<option value="' . $t['system'] . '">' . $t['ip'] . '</option>';
              }
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="type">Type</label>
          <select class="form-control" id="type" name="type" required>
            <?php
            foreach ($pdo->query("SELECT * FROM type")->fetchAll(PDO::FETCH_ASSOC) as $t) {
              if (isset($_GET['type']) && $_GET['type'] == $t['id_type']) {
                echo '<option value="' . $t['id_type'] . '" selected>' . $t['name'] . '</option>';
              } else {
                echo '<option value="' . $t['id_type'] . '">' . $t['name'] . '</option>';
              }
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="bench">Benchmark</label>
          <select class="form-control" id="bench" name="bench" required>
            <?php
            foreach ($pdo->query("SELECT * FROM benchmark")->fetchAll(PDO::FETCH_ASSOC) as $b) {
              if (isset($_GET['bench']) && $_GET['bench'] == $b['id_bench']) {
                echo '<option value="' . $b['id_bench'] . '" selected>' . $b['name'] . '</option>';
              } else {
                echo '<option value="' . $b['id_bench'] . '">' . $b['name'] . '</option>';
              }
            }
            ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
      </form>
    </div>
  </div>
</div>
<div class="card shadow">
  <div class="card-header py-3">
    <p class="text-primary m-0 fw-bold">Compare</p>
  </div>
  <div class="card-body">
    <div class="row">
      <form method="get">
        <input type="hidden" value="r" name="p">
        <input type="hidden" value="1" name="t">
        <?php
        foreach ($pdo->query("SELECT * FROM type")->fetchAll(PDO::FETCH_ASSOC) as $t) {
          echo '<div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="t' . $t['id_type'] . '" name="t' . $t['id_type'] . '"';
          if (isset($_GET['t' . $t['id_type']])) {
            echo 'checked';
          }
          echo ' ><label class="form-check-label" for="t' . $t['id_type'] . '">' . $t['name'] . '</label></div>';
        }
        ?>
        <div class="form-group">
          <label for="bench">Benchmark</label>
          <select class="form-control" id="bench" name="bench" required>
            <?php
            foreach ($pdo->query("SELECT * FROM benchmark")->fetchAll(PDO::FETCH_ASSOC) as $b) {
              if (isset($_GET['bench']) && $_GET['bench'] == $b['id_bench']) {
                echo '<option value="' . $b['id_bench'] . '" selected>' . $b['name'] . '</option>';
              } else {
                echo '<option value="' . $b['id_bench'] . '">' . $b['name'] . '</option>';
              }
            }
            ?>
          </select>
          <div class="form-group">
            <label for="system">System</label>
            <select class="form-control" id="system" name="system" required>
              <?php
              foreach ($pdo->query("SELECT * FROM target")->fetchAll(PDO::FETCH_ASSOC) as $t) {
                if (isset($_GET['system']) && $_GET['system'] == $t['system']) {
                  echo '<option value="' . $t['system'] . '" selected>' . $t['ip'] . '</option>';
                } else {
                  echo '<option value="' . $t['system'] . '">' . $t['ip'] . '</option>';
                }
              }
              ?>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
      </form>
    </div>
  </div>
</div>
<div class="card shadow">
  <div class="card-body">
    <?php
    if (isset($_GET['t']) && $_GET['t'] == 0) {
    ?>
      <?php
      $results = $pdo->query("SELECT * FROM results WHERE system=" . $_GET['system'] . " AND type=" . $_GET['type'] . " AND benchmark=" . $_GET['bench'])->fetchAll(PDO::FETCH_ASSOC);
      switch ($_GET['bench']) {
        case 1:
      ?>
          <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart0"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
              const ctx0 = document.getElementById('chart0');

              new Chart(ctx0, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'HPL',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->hpl != "") {
                          $i++;
                          echo json_decode($result['result'])->hpl . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)',

                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart1"></canvas>
            </div>

            <script>
              const ctx1 = document.getElementById('chart1');

              new Chart(ctx1, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'DGEMM',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->dgemm != "") {
                          $i++;
                          echo json_decode($result['result'])->dgemm . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(132, 99, 255)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
                options: {
                  y: {
                    beginAtZero: true
                  }
                }
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart2"></canvas>
            </div>

            <script>
              const ctx2 = document.getElementById('chart2');

              new Chart(ctx2, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'RA',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->ra != "") {
                          $i++;
                          echo json_decode($result['result'])->ra . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(132, 255, 99)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
                options: {
                  y: {
                    beginAtZero: true
                  }
                }
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart3"></canvas>
            </div>

            <script>
              const ctx3 = document.getElementById('chart3');

              new Chart(ctx3, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Stream',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->stream != "") {
                          $i++;
                          echo json_decode($result['result'])->stream . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 132, 99)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
                options: {
                  y: {
                    beginAtZero: true
                  }
                }
              });
            </script>
          </div>
        <?php
          break;
        case 2:
        ?>
          <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart0"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
              const ctx0 = document.getElementById('chart0');

              new Chart(ctx0, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Random IOPS read',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->randiopsr != "") {
                          $i++;
                          echo json_decode($result['result'])->randiopsr . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart1"></canvas>
            </div>

            <script>
              const ctx1 = document.getElementById('chart1');

              new Chart(ctx1, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Random IOPS write',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->randiopsw != "") {
                          $i++;
                          echo json_decode($result['result'])->randiopsw . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart2"></canvas>
            </div>

            <script>
              const ctx2 = document.getElementById('chart2');

              new Chart(ctx2, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Sequential IOPS read',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->seqiopsr != "") {
                          $i++;
                          echo json_decode($result['result'])->seqiopsr . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart3"></canvas>
            </div>

            <script>
              const ctx3 = document.getElementById('chart3');

              new Chart(ctx3, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Sequential IOPS write',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->seqiopsw != "") {
                          $i++;
                          echo json_decode($result['result'])->seqiopsw . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
              });
            </script>
          </div>
          <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart4"></canvas>
            </div>

            <script>
              const ctx4 = document.getElementById('chart4');

              new Chart(ctx4, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Random read',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->randsr != "") {
                          $i++;
                          echo json_decode($result['result'])->randsr . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart5"></canvas>
            </div>

            <script>
              const ctx5 = document.getElementById('chart5');

              new Chart(ctx5, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Random write',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->randsw != "") {
                          $i++;
                          echo json_decode($result['result'])->randsw . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart6"></canvas>
            </div>

            <script>
              const ctx6 = document.getElementById('chart6');

              new Chart(ctx6, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Sequential read',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->seqsr != "") {
                          $i++;
                          echo json_decode($result['result'])->seqsr . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart7"></canvas>
            </div>

            <script>
              const ctx7 = document.getElementById('chart7');

              new Chart(ctx7, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Sequential write',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->seqsw != "") {
                          $i++;
                          echo json_decode($result['result'])->seqsw . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                },
              });
            </script>
          </div>
        <?php
          break;
        case 3:
        ?>
          <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart0"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
              const ctx0 = document.getElementById('chart0');

              new Chart(ctx0, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Ping',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->ping != "") {
                          $i++;
                          echo json_decode($result['result'])->ping . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                }
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart1"></canvas>
            </div>

            <script>
              const ctx1 = document.getElementById('chart1');

              new Chart(ctx1, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Iperf send',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->iperfs != "") {
                          $i++;
                          echo json_decode($result['result'])->iperfs . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                }
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart2"></canvas>
            </div>

            <script>
              const ctx2 = document.getElementById('chart2');

              new Chart(ctx2, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Iperf receive',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->iperfr != "") {
                          $i++;
                          echo json_decode($result['result'])->iperfr . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                }
              });
            </script>

            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart3"></canvas>
            </div>

            <script>
              const ctx3 = document.getElementById('chart3');

              new Chart(ctx3, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Iperf UDP',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->iperfu != "") {
                          $i++;
                          echo json_decode($result['result'])->iperfu . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                }
              });
            </script>
          </div>
        <?php
          break;
        case 4:
        ?>
          <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart0"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
              const ctx0 = document.getElementById('chart0');

              new Chart(ctx0, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Blender',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->r != "") {
                          $i++;
                          echo json_decode($result['result'])->r . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                }
              });
            </script>
          </div>
        <?php
          break;
        case 5:
        ?>
          <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart0"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
              const ctx0 = document.getElementById('chart0');

              new Chart(ctx0, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Databse',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->r != "") {
                          $i++;
                          echo json_decode($result['result'])->r . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                }
              });
            </script>
          </div>
        <?php
          break;
        case 6:
        ?>
          <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart0"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
              const ctx0 = document.getElementById('chart0');

              new Chart(ctx0, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'Deep learning',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->r != "") {
                          $i++;
                          echo json_decode($result['result'])->r . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                }
              });
            </script>
          </div>
        <?php
          break;
        case 7:
        ?>
          <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
              <canvas id="chart0"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
              const ctx0 = document.getElementById('chart0');

              new Chart(ctx0, {
                type: 'line',
                data: {
                  datasets: [{
                    label: 'REST',
                    data: [
                      <?php
                      $i = 0;
                      foreach ($results as $result) {
                        if (json_decode($result['result'])->r != "") {
                          $i++;
                          echo json_decode($result['result'])->r . ', ';
                        }
                      }
                      ?>
                    ],
                    backgroundColor: 'rgb(255, 99, 132)'
                  }],
                  labels: [<?php for ($j = 1; $j <= $i; $j++) {
                              echo $j . ", ";
                            } ?>]
                }
              });
            </script>
          </div>
        <?php
          break;
      }
    } elseif (isset($_GET['t']) && $_GET['t'] == 1) {
      $results = $pdo->query("SELECT * FROM results WHERE system=" . $_GET['system'] . " AND benchmark=" . $_GET['bench'])->fetchAll(PDO::FETCH_ASSOC);
      $sums = array();
      switch ($_GET['bench']) {
        case 1:
        ?>
          <div id="chart0"></div>

          <script src="https://cdn.plot.ly/plotly-2.16.1.min.js"></script>
          <script>
            TESTER = document.getElementById("chart0");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->hpl . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'HPL',
              showlegend: true
            };

            Plotly.newPlot(TESTER, data, layout);
          </script>
          <div id="chart1"></div>
          <script>
            chart1 = document.getElementById("chart1");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->dgemm . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'DGEMM',
              showlegend: true
            };

            Plotly.newPlot(chart1, data, layout);
          </script>

          <div id="chart2"></div>
          <script>
            chart2 = document.getElementById("chart2");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->ra . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Random memory access',
              showlegend: true
            };

            Plotly.newPlot(chart2, data, layout);
          </script>

          <div id="chart3"></div>
          <script>
            chart3 = document.getElementById("chart3");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->stream . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Sequential memory access',
              showlegend: true
            };

            Plotly.newPlot(chart3, data, layout);
          </script>
        <?php
          break;
        case 2:
        ?>
          <div id="chart0"></div>

          <script src="https://cdn.plot.ly/plotly-2.16.1.min.js"></script>
          <script>
            TESTER = document.getElementById("chart0");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->randiopsr . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Random read IOPS',
              showlegend: true
            };

            Plotly.newPlot(TESTER, data, layout);
          </script>
          <div id="chart1"></div>
          <script>
            chart1 = document.getElementById("chart1");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->randiopsw . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Random write IOPS',
              showlegend: true
            };

            Plotly.newPlot(chart1, data, layout);
          </script>

          <div id="chart2"></div>
          <script>
            chart2 = document.getElementById("chart2");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->seqiopsr . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Sequential read IOPS',
              showlegend: true
            };

            Plotly.newPlot(chart2, data, layout);
          </script>

          <div id="chart3"></div>
          <script>
            chart3 = document.getElementById("chart3");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->seqiopsw . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Sequential write IOPS',
              showlegend: true
            };

            Plotly.newPlot(chart3, data, layout);
          </script>
          <div id="chart4"></div>
          <script>
            chart4 = document.getElementById("chart4");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->randsr . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Random read speed',
              showlegend: true
            };

            Plotly.newPlot(chart4, data, layout);
          </script>
          <div id="chart5"></div>
          <script>
            chart5 = document.getElementById("chart5");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->randsw . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Random write speed',
              showlegend: true
            };

            Plotly.newPlot(chart5, data, layout);
          </script>

          <div id="chart6"></div>
          <script>
            chart6 = document.getElementById("chart6");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->seqsr . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Sequential read speed',
              showlegend: true
            };

            Plotly.newPlot(chart6, data, layout);
          </script>

          <div id="chart7"></div>
          <script>
            chart7 = document.getElementById("chart7");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->seqiopsw . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Sequential write speed',
              showlegend: true
            };

            Plotly.newPlot(chart7, data, layout);
          </script>

        <?php
          break;
        case 3:
        ?>
          <div id="chart0"></div>

          <script src="https://cdn.plot.ly/plotly-2.16.1.min.js"></script>
          <script>
            TESTER = document.getElementById("chart0");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->ping . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Ping',
              showlegend: true
            };

            Plotly.newPlot(TESTER, data, layout);
          </script>
          <div id="chart1"></div>
          <script>
            chart1 = document.getElementById("chart1");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->iperfs . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Iperf send',
              showlegend: true
            };

            Plotly.newPlot(chart1, data, layout);
          </script>

          <div id="chart2"></div>
          <script>
            chart2 = document.getElementById("chart2");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->iperfr . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'IPerf receive',
              showlegend: true
            };

            Plotly.newPlot(chart2, data, layout);
          </script>

          <div id="chart3"></div>
          <script>
            chart3 = document.getElementById("chart3");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->iperfu . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'IPerf UDP',
              showlegend: true
            };

            Plotly.newPlot(chart3, data, layout);
          </script>
        <?php
          break;
        case 4:
        ?>

          <div id="chart0"></div>

          <script src="https://cdn.plot.ly/plotly-2.16.1.min.js"></script>
          <script>
            TESTER = document.getElementById("chart0");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->r . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Blender classroom render',
              showlegend: true
            };

            Plotly.newPlot(TESTER, data, layout);
          </script>
        <?php
          break;
        case 5:
        ?>

          <div id="chart0"></div>

          <script src="https://cdn.plot.ly/plotly-2.16.1.min.js"></script>
          <script>
            TESTER = document.getElementById("chart0");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->r . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Database operations',
              showlegend: true
            };

            Plotly.newPlot(TESTER, data, layout);
          </script>
        <?php
          break;
        case 6:
        ?>

          <div id="chart0"></div>

          <script src="https://cdn.plot.ly/plotly-2.16.1.min.js"></script>
          <script>
            TESTER = document.getElementById("chart0");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->r . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'Deep learning GAN model training',
              showlegend: true
            };

            Plotly.newPlot(TESTER, data, layout);
          </script>
        <?php
          break;
        case 7:
        ?>

          <div id="chart0"></div>

          <script src="https://cdn.plot.ly/plotly-2.16.1.min.js"></script>
          <script>
            TESTER = document.getElementById("chart0");
            var data = [
              <?php
              for ($i = 1; $i <= 16; $i++) {
                if (isset($_GET['t' . $i])) {
                  echo '{ y: [';
                  foreach ($results as $result) {
                    if ($result['type'] == $i) {
                      $r = json_decode($result['result']);
                      echo $r->r . ',';
                    }
                  }
                  echo '], name: \'' . $pdo->query("SELECT * FROM type WHERE id_type=" . $i)->fetch(PDO::FETCH_ASSOC)['name'] . '\',type: \'box\'},';
                }
              }
              ?>
            ];

            var layout = {
              title: 'REST server operation',
              showlegend: true
            };

            Plotly.newPlot(TESTER, data, layout);
          </script>
    <?php
          break;
      }
    }
    ?>
  </div>
</div>