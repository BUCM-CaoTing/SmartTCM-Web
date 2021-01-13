<!DOCTYPE html>
<html>
  <head>
  <?php require_once("head.php"); ?>
    <!-- JavaScript files-->
    <?php require_once("script.php"); ?>
  </head>
  <body>
    <!-- Side Navbar -->
    <?php require_once("nav.php"); ?>
    <div class="page">
      <!-- navbar-->
      <?php require_once("header.php"); ?>
      <!-- Breadcrumb-->
      <!-- <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Tables       </li>
          </ul>
        </div>
      </div> -->
      <section>
        <div class="container-fluid">
          <!-- Page Header-->
          <div class="row" id="chart">

          </div>
          <div class="row" id="chart2" style="display: none;">

          </div>
          <div class="row">
            <div class="card-body">
                  <form class="form-inline">
                    <div class="form-group">
                      <label for="inlineFormInput" class="sr-only">开始时间</label>
                      <input id="start" type="text" placeholder="2020-10-01 00:00:00"  class="mr-3 form-control">
                    </div>
                    <div class="form-group">
                      <label for="inlineFormInputGroup" class="sr-only">结束时间</label>
                      <input id="end" type="text" placeholder="2020-10-01 23:59:59" class="mr-3 form-control form-control">
                    </div>
                    <div class="form-group">
                      <input type="button" value="查询" onclick="get()" class="mr-3 btn btn-primary">
                    </div>
                  </form>
            </div>
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>Basic Table</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr id="th">
                        </tr>
                      </thead>
                      <tbody id="data">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php require_once("footer.php");?>
    </div>
  </body>
  <script>
    var brandPrimary = 'rgba(51, 179, 90, 1)';
    function get(){
      let deviceId = getQueryVariable("deviceId");
      let type = getQueryVariable("type");
      let start = $("#start").val()
      let end = $("#end").val()
      $.ajax({
          type: 'POST',
          url: '/index.php/api/history',
          data: {deviceId: deviceId, start: start, end: end},
          crossDomain: true,  
          success: function(res){
            if(type == 1){
              var html = '<th>#</th>'
              html += '<th>光照度</th>'
              html += '<th>时间</th>'
              $("#th").html(html)
              index = 1
              $("#data").html("")
              var times = []
              var data1 = []
              res.forEach(function(item){
                html = '<tr>'
                html += '<th scope="row">' + index + '</th>'
                html += '<td>' + item.value + '</td>'
                html += '<td>' + item.time + '</td>'
                html += '</tr>'
                times.push(item.time)
                data1.push(item.value)
                $("#data").append(html)
                index++
              })

              html = '<div class="col-lg-12">'
              html += '<div class="card line-chart-example">'
              html += '<div class="card-header d-flex align-items-center">'
              html += '<h4>Line Chart Example</h4>'
              html += '</div>'
              html += '<div class="card-body">'
              html += '<canvas id="lineChartExample"></canvas>'
              html += '</div>'
              html += '</div>'
              html += '</div>'
              $("#chart").html(html)
              var lineChartExample = new Chart($('#lineChartExample'), {
                type: 'line',
                data: {
                    labels: times,
                    datasets: [{
                            label: "Data Set One",
                            fill: true,
                            lineTension: 0.3,
                            backgroundColor: "rgba(51, 179, 90, 0.38)",
                            borderColor: brandPrimary,
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 1,
                            pointBorderColor: brandPrimary,
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: brandPrimary,
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: data1,
                            spanGaps: false
                    }]
                }
              });
            }
            if(type == 0){
              var html = '<th>#</th>'
              html += '<th>注水开关</th>'
              html += '<th>温控开关</th>'
              html += '<th>灯光开关</th>'
              html += '<th>时间</th>'
              $("#th").html(html)
              index = 1
              $("#data").html("")
              var times = []
              var data1 = []
              var data2 = []
              var data3 = []
              res.forEach(function(item){
                html = '<tr>'
                html += '<th scope="row">' + index + '</th>'
                var arr = res.value.split("|")
                html += '<td>' + arr[0] == 0? '关':'开' + '</td>'
                html += '<td>' + arr[1] == 0? '关':'开' + '</td>'
                html += '<td>' + arr[2] == 0? '关':'开' + '</td>'
                html += '<td>' + item.time + '</td>'
                html += '</tr>'
                times.push(item.time)
                data1.push(arr[0])
                data1.push(arr[1])
                data1.push(arr[2])
                $("#data").append(html)
                index++
              })

              html = '<div class="col-lg-12">'
              html += '<div class="card line-chart-example">'
              html += '<div class="card-header d-flex align-items-center">'
              html += '<h4>Line Chart Example</h4>'
              html += '</div>'
              html += '<div class="card-body">'
              html += '<canvas id="lineChartExample"></canvas>'
              html += '</div>'
              html += '</div>'
              html += '</div>'
              $("#chart").html(html)
              var lineChartExample = new Chart($('#lineChartExample'), {
                type: 'line',
                data: {
                    labels: times,
                    datasets: [{
                            label: "Data Set One",
                            fill: true,
                            lineTension: 0.3,
                            backgroundColor: "rgba(51, 179, 90, 0.38)",
                            borderColor: brandPrimary,
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 1,
                            pointBorderColor: brandPrimary,
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: brandPrimary,
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: data1,
                            spanGaps: false
                    },{
                            label: "Data Set One",
                            fill: true,
                            lineTension: 0.3,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 1,
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(75,192,192,1)",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: data1,
                            spanGaps: false
                    },{
                            label: "Data Set One",
                            fill: true,
                            lineTension: 0.3,
                            backgroundColor: "rgba(255,206,86, 0.38)",
                            borderColor: "rgba(255,206,86,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 1,
                            pointBorderColor: "rgba(255,206,86,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(255,206,86,1)",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: data1,
                            spanGaps: false
                    }]
                }
              });
            }
            if(type == 2){
              var html = '<th>#</th>'
              html += '<th>环境温度</th>'
              html += '<th>环境湿度</th>'
              html += '<th>时间</th>'
              $("#th").html(html)
              index = 1
              $("#data").html("")
              var times = []
              var data1 = []
              var data2 = []
              res.forEach(function(item){
                html = '<tr>'
                html += '<th scope="row">' + index + '</th>'
                var arr = item.value.split("|")
                html += '<td>' + arr[0] + '</td>'
                html += '<td>' + arr[1] + '</td>'
                html += '<td>' + item.time + '</td>'
                html += '</tr>'
                times.push(item.time)
                data1.push(arr[0])
                data2.push(arr[1])
                $("#data").append(html)
                index++
              })

              html = '<div class="col-lg-12">'
              html += '<div class="card line-chart-example">'
              html += '<div class="card-header d-flex align-items-center">'
              html += '<h4>Line Chart Example</h4>'
              html += '</div>'
              html += '<div class="card-body">'
              html += '<canvas id="lineChartExample"></canvas>'
              html += '</div>'
              html += '</div>'
              html += '</div>'
              $("#chart").html(html)
              var lineChartExample = new Chart($('#lineChartExample'), {
                type: 'line',
                data: {
                    labels: times,
                    datasets: [{
                            label: "环境温度",
                            fill: true,
                            lineTension: 0.3,
                            backgroundColor: "rgba(51, 179, 90, 0.38)",
                            borderColor: brandPrimary,
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 1,
                            pointBorderColor: brandPrimary,
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: brandPrimary,
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: data1,
                            spanGaps: false
                    }]
                }
              });
              html = '<div class="col-lg-12">'
              html += '<div class="card line-chart-example">'
              html += '<div class="card-header d-flex align-items-center">'
              html += '<h4>Line Chart Example</h4>'
              html += '</div>'
              html += '<div class="card-body">'
              html += '<canvas id="lineChartExample2"></canvas>'
              html += '</div>'
              html += '</div>'
              html += '</div>'
              $("#chart2").css("display", "block")
              $("#chart2").html(html)
              var lineChartExample = new Chart($('#lineChartExample2'), {
                type: 'line',
                data: {
                    labels: times,
                    datasets: [{
                            label: "环境湿度",
                            fill: true,
                            lineTension: 0.3,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            borderWidth: 1,
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(75,192,192,1)",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: data2,
                            spanGaps: false
                    }]
                }
              });
            }
            if(type == 3){
              var html = '<th>#</th>'
              html += '<th>土壤湿度</th>'
              html += '<th>时间</th>'
              $("#th").html(html)
              index = 1
              $("#data").html("")
              var low = 0
              var high = 0
              res.forEach(function(item){
                html = '<tr>'
                html += '<th scope="row">' + index + '</th>'
                html += '<td>' + item.value == 0 ? '潮湿' : '干燥' + '</td>'
                html += '<td>' + item.time + '</td>'
                html += '</tr>'
                $("#data").append(html)
                index++
                if(item.value == 0){
                  high++
                }else{
                  low++
                }
              })

              html = '<div class="col-lg-12">'
              html += '<div class="card line-chart-example">'
              html += '<div class="card-header d-flex align-items-center">'
              html += '<h4>Line Chart Example</h4>'
              html += '</div>'
              html += '<div class="card-body">'
              html += '<canvas id="lineChartExample"></canvas>'
              html += '</div>'
              html += '</div>'
              html += '</div>'
              $("#chart").html(html)
              var pieChartExample = new Chart(PIECHARTEXMPLE, {
                type: 'doughnut',
                data: {
                    labels: [
                        "干燥",
                        "潮湿",
                    ],
                    datasets: [
                        {
                            data: [low, high],
                            borderWidth: [1, 1],
                            backgroundColor: [
                                brandPrimary,
                                "rgba(75,192,192,1)"
                            ],
                            hoverBackgroundColor: [
                                brandPrimary,
                                "rgba(75,192,192,1)"
                            ]
                        }]
                    }
                });
              }
          },
          dataType: 'json'
      });
    }

    function del(id){
        $.ajax({
          type: 'POST',
          url: '/index.php/user/del',
          data: {id: id},
          crossDomain: true,  
          success: function(res){
            alert(res.msg)
            location.href = "/user.php"
          },
          dataType: 'json'
        });
    }

    function getQueryVariable(variable)
    {
          var query = window.location.search.substring(1);
          var vars = query.split("&");
          for (var i=0;i<vars.length;i++) {
                  var pair = vars[i].split("=");
                  if(pair[0] == variable){return pair[1];}
          }
          return(false);
    }
  </script>
</html>