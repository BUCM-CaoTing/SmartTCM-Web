<nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><img src="img/avatar-7.jpg" alt="person" class="img-fluid rounded-circle">
            <h2 class="h5">Nathan Andrews</h2><span>Web Developer</span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>B</strong><strong class="text-primary">D</strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Main</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <!-- <li class="root"><a href="user.php"> <i class="icon-home"></i>用户管理                             </a></li>
            <li class="root"><a href="area.php"> <i class="icon-form"></i>监测点管理                             </a></li>
            <li class="root"><a href="device.php"> <i class="icon-form"></i>设备管理                             </a></li> -->
            <!-- <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>监测点1 </a>
              <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                <li><a href="#">TEST001</a></li>
              </ul>
            </li>
            <li><a href="#exampledropdownDropdown2" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>监测点2 </a>
              <ul id="exampledropdownDropdown2" class="collapse list-unstyled ">
                <li><a href="#">TEST002</a></li>
              </ul>
            </li> -->
          </ul>
        </div>
        <script>
          $(document).ready(function(){
            var uid = $.cookie('uid');
            var isRoot = $.cookie('p')
            console.log("isRoot: " + isRoot)
            if(isRoot == 1){
              var html = '<li class="root"><a href="user.php"> <i class="icon-home"></i>用户管理                             </a></li>'
              html += '<li class="root"><a href="area.php"> <i class="icon-form"></i>监测点管理                             </a></li>'
              html += '<li class="root"><a href="device.php"> <i class="icon-form"></i>设备管理                             </a></li>'
              $("#side-main-menu").append(html)
            }
            if(uid){
                if(uid == 1){
                    $(".root").css("display", "list-item")
                }else{
                    $(".root").css("display", "none")
                }
            }else{
                location.href = "/login.php";
            }

            $.ajax({
              type: 'POST',
              url: '/index.php/area/getallwithdevice',
              data: {uid: uid},
              crossDomain: true,  
              success: function(res){
                res.forEach(function(item){
                  if(item.device.length > 0){
                    var html = '<li>'
                    html += '<a href="#area'+item.id+'" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>'
                    html += item.name + '</a>'
                    item.device.forEach(function(it){
                      html += '<ul id="area'+item.id+'" class="collapse list-unstyled ">'
                      html += '<li><a href="/data.php?deviceId='+it.id+'">'+it.deviceName+'</a></li>'
                      html += '</ul>'
                    })
                    html += '<ul id="area'+item.id+'" class="collapse list-unstyled ">'
                    html += '<li><a href="/math.php?areaId='+item.id+'">公式</a></li>'
                    html += '</ul>'
                    html += '<ul id="area'+item.id+'" class="collapse list-unstyled ">'
                    html += '<li><a href="/set.php?areaId='+item.id+'">阈值</a></li>'
                    html += '</ul>'
                    html += '</li>'
                    $("#side-main-menu").append(html)
                  }
                })
              },
              dataType: 'json'
          });
          })
        </script>
      </div>
    </nav>