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
                  <p>Lorem ipsum dolor sit amet consectetur.</p>
                  <form>
                    <div class="form-group">
                      <label>名称</label>
                      <input type="email" id="name" placeholder="名称" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>地址</label>
                      <input type="email" id="addr" placeholder="地址（1-255）" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>监测点</label>
                      <div class="col-sm-10 mb-3">
                        <select name="account" id="area" class="form-control">

                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>是否控制器</label>
                      <select name="account" id="type" class="form-control">
                        <option value="0">否</option>
                        <option value="1">是</option>
                      </select>
                    </div>
                    <div class="form-group">       
                      <input type="button" onclick="reg()" value="Signin" class="btn btn-primary">
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
    $(document).ready(function(){
      $.ajax({
          type: 'POST',
          url: '/index.php/area/getall',
          data: {},
          crossDomain: true,  
          success: function(res){
            var index = 1
            res.forEach(function(item){
              var html = '<option value="' + item.id + '">'
              html += item.name
              html += '</option>'
              $("#area").append(html)
              index++
            })
          },
          dataType: 'json'
      });
    });



    function reg(){
        var name = $("#name").val()
        var area = $("#area").val()
        var addr = $("#addr").val()
        var type = $("#type").val()
        $.ajax({
          type: 'POST',
          url: '/index.php/device/add',
          data: {deviceName: name, addr: addr, area: area, type: type},
          crossDomain: true,  
          success: function(res){
            alert(res.msg)
          },
          dataType: 'json'
        });
    }
  </script>
</html>