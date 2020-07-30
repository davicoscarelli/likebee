<?php
  // include('session.php'); 
  // if(!isset($_SESSION['login_user'])){ 
  // header("location: index.php"); // Redirecting To Home Page 
  // }
?>
<!DOCTYPE html>
<html class="gr__colorlib_com">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Dashboard</title>
    <style>#loader{transition:all .3s ease-in-out;opacity:1;visibility:visible;position:fixed;height:100vh;width:100%;background:#fff;z-index:90000}#loader.fadeOut{opacity:0;visibility:hidden}.spinner{width:40px;height:40px;position:absolute;top:calc(50% - 20px);left:calc(50% - 20px);background-color:#333;border-radius:100%;-webkit-animation:sk-scaleout 1s infinite ease-in-out;animation:sk-scaleout 1s infinite ease-in-out}@-webkit-keyframes sk-scaleout{0%{-webkit-transform:scale(0)}100%{-webkit-transform:scale(1);opacity:0}}@keyframes sk-scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}100%{-webkit-transform:scale(1);transform:scale(1);opacity:0}}</style>
    <link href="./Dashboard_files/style.css" rel="stylesheet">
    <style type="text/css">
    </style>
    <style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;box-sizing: content-box;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>
  </head>
  <body class="app" data-gr-c-s-loaded="true">
    <div id="loader" class="fadeOut">
      <div class="spinner"></div>
    </div>
    <script type="text/javascript" async="" src="./Dashboard_files/analytics.js.download"></script><script type="text/javascript">window.addEventListener('load', () => {
      const loader = document.getElementById('loader');
      setTimeout(() => {
        loader.classList.add('fadeOut');
      }, 300);
      });
    </script>
    <div>
    <div class="sidebar">
      <div class="sidebar-inner">
        <div class="sidebar-logo">
          <div class="peers ai-c fxw-nw">
            <div class="peer peer-greed">
              <a class="sidebar-link td-n" href="">
                <div class="peers ai-c fxw-nw">
                  <div class="peer">
                    <div class="logo"><img src="https://i.imgur.com/ylYDRqG.png" alt="" style="height: 60px;"></div>
                  </div>
                  <div class="peer peer-greed">
                    <h5 class="lh-1 mB-0 logo-text">Like Bee</h5>
                  </div>
                </div>
              </a>
            </div>
            <div class="peer">
              <div class="mobile-toggle sidebar-toggle"></div>
            </div>
          </div>
        </div>
        <ul class="sidebar-menu scrollable pos-r ps">
          <li class="nav-item mT-30 active"><a class="sidebar-link" href="index.php" default=""><span class="icon-holder"><i class="c-blue-500 ti-home"></i> </span><span class="title">Dashboard</span></a></li>
          <li class="nav-item"><a class="sidebar-link" href="logout.php"><span class="icon-holder"><i class="c-blue-500 ti-share"></i> </span><span class="title">Logout</span></a></li>
        </ul>
      </div>
    </div>
    <div class="page-container">
    <div class="header navbar">
      <div class="header-container">
        <ul class="nav-left">
          <li></li>
        </ul>
        <ul class="nav-right">
          <li class="notifications dropdown"> </li>
          <li class="dropdown">
            <a href="https://colorlib.com/polygon/adminator/index.html" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown" aria-expanded="false">
              <div class="peer mR-10"></div>
              <div class="peer"><span class="fsz-sm c-grey-900"><i><?php echo $login_session; ?></i></span></div>
            </a>
            <ul class="dropdown-menu fsz-sm">
              <li></li>
              <li></li>
              <li></li>
              <li role="separator" class="divider"></li>
              <li><a href="logout.php" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700"><i class="ti-power-off mR-10"></i> <span>Logout</span></a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
    <main class="main-content bgc-grey-100">
      <div id="mainContent">
        <div class="row gap-20 masonry pos-r" style="position: relative; height: 708px;">
          <div class="masonry-sizer col-md-6"></div>
          <div class="masonry-item col-12" style="position: absolute; left: 0%; top: 124px;">
            <div class="bd bgc-white">
              <div class="peers fxw-nw@lg+ ai-s">
                <div class="peer peer-greed w-70p@lg+ w-100@lg- p-20">
                  <div class="layers">
                    <div class="layer w-100 mB-10">
                      <h6 class="lh-1">All Devices</h6>
                    </div>
                    <div class="layer w-100">
                        <div id="map" style="
                              height: 490px;
                              position: relative;
                              overflow: hidden;
                              background-color: transparent;
                              ">
                        </div>
                            <script>                      
                      
                              var customLabel = {
                                simple: {
                                  label: 'S'
                                },
                                double: {
                                  label: 'D'
                                }
                              };

                                function initMap() {
                                
                                var map = new google.maps.Map(document.getElementById('map'), { 
                                          
                                  center: new google.maps.LatLng($lat, $lon),
                                  zoom: 5
                                });
                                var infoWindow = new google.maps.InfoWindow;
                                  downloadUrl('markers.php', function(data) {
                                    var xml = data.responseXML;
                                    var markers = xml.documentElement.getElementsByTagName('marker');
                                    Array.prototype.forEach.call(markers, function(markerElem) {
                                      var id = markerElem.getAttribute('id');
                                      var name = markerElem.getAttribute('name');
                                      var address = markerElem.getAttribute('address');
                                      var type = markerElem.getAttribute('type');
                                      var point = new google.maps.LatLng(
                                          parseFloat(markerElem.getAttribute('lat')),
                                          parseFloat(markerElem.getAttribute('lng')));

                                      var infowincontent = document.createElement('div');
                                      var strong = document.createElement('strong');
                                      strong.textContent = name
                                      infowincontent.appendChild(strong);
                                      infowincontent.appendChild(document.createElement('br'));

                                      var text = document.createElement('text');
                                      text.textContent = address
                                      infowincontent.appendChild(text);
                                      var icon = customLabel[type] || {};
                                      var marker = new google.maps.Marker({
                                        map: map,
                                        position: point,
                                        label: icon.label
                                      });
                                      marker.addListener('click', function() {
                                        infoWindow.setContent(infowincontent);
                                        infoWindow.open(map, marker);
                                      });
                                    });
                                  });
                                }

                              function downloadUrl(url, callback) {
                                var request = window.ActiveXObject ?
                                    new ActiveXObject('Microsoft.XMLHTTP') :
                                    new XMLHttpRequest;

                                request.onreadystatechange = function() {
                                  if (request.readyState == 4) {
                                    request.onreadystatechange = doNothing;
                                    callback(request, request.status);
                                  }
                                };

                                request.open('GET', url, true);
                                request.send(null);
                              }

                              function doNothing() {}
                        </script>
					
                       
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </main>
    <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600"><span>Copyright © 2019 LikeBee. All rights reserved.</span>
    <script async="" src="./Dashboard_files/js" type="text/javascript"></script>
    <script type="text/javascript">
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      
      gtag('config', 'UA-23581568-13');
    </script>
    </footer></div></div><script type="text/javascript" src="./Dashboard_files/vendor.js.download"></script><script type="text/javascript" src="./Dashboard_files/bundle.js.download"></script>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip" style="display: none; left: 294.953px; top: 439px;">Canada</div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip" style="display: none; left: 763.156px; top: 250px;">Russia</div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip" style="display: none; left: 821.078px; top: 692px;">South Africa</div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip" style="display: none; left: 1283.83px; top: 660px;">Australia</div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip" style="display: none; left: 764.156px; top: 238px;">Russia</div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip" style="display: none; left: 293.734px; top: 238px;">Greenland</div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip" style="display: none; left: 1255.53px; top: 507px;">Nepal</div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip" style="display: none; left: 291.953px; top: 459px;">Canada</div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
    <div class="jvectormap-tip"></div>
  </body>
  <span class="gr__tooltip"><span class="gr__tooltip-content"></span><i class="gr__tooltip-logo"></i><span class="gr__triangle"></span></span>
</html>