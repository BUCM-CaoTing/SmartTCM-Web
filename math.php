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
            <li class="breadcrumb-item active">Forms       </li>
          </ul>
        </div>
      </div> -->
      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">Forms            </h1>
          </header>
          <div class="row">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Basic Form</h4>
                </div>
                <div class="card-body">
                  <p id="score" style="border: solid 1px red; padding: 3px; width: 120px;">计算结果：</p>
                  <form>
                    <div class="form-group">
                      <label>公式(L：环境光, H：环境湿度，T：环境温度)</label>
                      <input type="email" id="name" placeholder="公式" class="form-control">
                    </div>
                    <div class="form-group">       
                      <input type="button" onclick="reg()" value="提交" class="btn btn-primary">
                    </div>
                  </form>
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
    function reg(){
      str = $("#name").val()
      window.setInterval(function(){
        L = 0
        H = 0
        T = 0
        $.ajax({
          type: 'POST',
          url: '/index.php/api/getbyaid',
          data: {areaId: getQueryVariable("areaId")},
          crossDomain: true,  
          success: function(res){
            L = parseFloat(res.Light)
            H = parseInt(res.H)
            T = parseInt(res.T)
            $("#score").text("计算结果：" + eval(str))
          },
          dataType: 'json'
        });
        
      },1000);
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