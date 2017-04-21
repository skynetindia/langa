<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <title>Client LANGA</title>
	
    <!-- Bootstrap -->
    <link href="{{asset('/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{asset('/build/css/custom.min.css')}}" rel="stylesheet">
    
    <!-- Font -->
	  <link rel="stylesheet" href="{{asset('public/css/stylesheet.css')}}">
      
     <style>
		 #menu1 {
			 height:300px;
			 overflow:hidden; overflow-y:scroll;
		 }
		 * { font-family:"nexa_lightregular";}
	</style>
  </head>
  <?php $logged = false; ?>
@if (!Auth::guest())
<?php $logged = true; ?>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{url('/')}}" class="site_title"><img src="{{asset('images/logo.png')}}" alt="..." class="img" style="max-height:50px; max-width:50px"> <span>  Client <strong>LANGA</strong></span></a>
            </div>

            <br>

			
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
		<br><br><br><h3>Primario</h3>
                <ul class="nav side-menu">
                  <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Bacheca</a>
                  </li>
				  
                  <li><a href="{{url('/calendario')}}"><i class="fa fa-calendar"></i> Calendario</a>
                  </li>
				          
				          <li><a href="{{url('/preventivi')}}"><i class="fa fa-file-text"></i> Preventivi</a>

                  </li>
				          
				          
                  <li><a href="{{url('/progetti')}}"><i class="fa fa-tasks"></i> Progetti</a>
                  </li>
				  
                  <li><a><i class="fa fa-usd"></i> Contabilità <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                          <li><a href="{{url('/fatture')}}">Fatture</a>
                        </li>
                        
                        <li><a>Metodi<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li><a href="{{url('/coordinate')}}">Coordinate bancarie</a>
                            </li>
                            <li><a href="{{url('/onworking')}}">PayPal <span class="label label-warning pull-right">In corso...</span></a>
                            </li>
                          </ul>
                        </li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>Secondario</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-info"></i> Info <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{url('/contatti')}}">Contatti</a>
                        <li><a href="{{url('/faq')}}">FAQ's</a>
                        <li><a href="{{url('/changelog')}}">Versioni Easy</a>
                        <li><a href="{{url('/onworking')}}">Acquisti <span class="label label-warning pull-right">In corso...</span></a>
                        </li>
                    </ul>
                  </li>

<!-- change href of Segnalazioni button  -->

                  <li><a href="{{url('/valutaci')}}"><i class="fa fa-star-o"></i> Segnalazioni</a>
                  </li>
				  
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->
            <script type="text/javascript">
        
            function toggleFullScreen() {
              if ((document.fullScreenElement && document.fullScreenElement !== null) ||    
               (!document.mozFullScreen && !document.webkitIsFullScreen)) {
                if (document.documentElement.requestFullScreen) {  
                  document.documentElement.requestFullScreen();  
                } else if (document.documentElement.mozRequestFullScreen) {  
                  document.documentElement.mozRequestFullScreen();  
                } else if (document.documentElement.webkitRequestFullScreen) {  
                  document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
                }  
              } else {  
                if (document.cancelFullScreen) {  
                  document.cancelFullScreen();  
                } else if (document.mozCancelFullScreen) {  
                  document.mozCancelFullScreen();  
                } else if (document.webkitCancelFullScreen) {  
                  document.webkitCancelFullScreen();  
                }  
              }  
            }

            </script> 
            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a href="{{url('/preventivi')}}" data-toggle="tooltip" data-placement="top" title="Preventivi">
                <span class="fa fa-file-text" aria-hidden="true"></span>
              </a>
              <a href="{{url('/progetti')}}" data-toggle="tooltip" data-placement="top" title="Progetti">
                <span class="fa fa-tasks" aria-hidden="true"></span>
              </a>
              <a href="{{url('/fatture')}}" data-toggle="tooltip" data-placement="top" title="Fatture">
                <span class="fa fa-usd" aria-hidden="true"></span>
              </a>
              <a href="http://www.betaclienteasy.langa.tv/" target="_blank" data-toggle="tooltip" data-placement="top" title="Client Beta">
                β</span>
              </a>
                            <hr>
              <a href="{{url('/profilo')}}" data-toggle="tooltip" data-placement="top" title="Profilo">
                <span class="fa fa-user" aria-hidden="true"></span>
              </a>
              <a onclick="toggleFullScreen();" data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="fa fa-arrows-alt" aria-hidden="true"></span>
              </a>
              <a href="{{url('/cestino')}}" data-toggle="tooltip" data-placement="top" title="Cestino">
                <span class="fa fa-trash" aria-hidden="true"></span>
              </a>
              <a href="{{url('/logout')}}" data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="fa fa-sign-out" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav class="" role="navigation">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  </img><a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  @if (!Auth::guest()) {{Auth::user()->name}} @endif
                 <span class=" fa fa-angle-down">  <i class="fa fa-info-circle pull-right"></i> </span>     
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="{{url('/')}}"><i class="fa fa-home pull-right"></i> Home</a></li>
                    <li><a href="{{url('/faq')}}"><i class="fa fa-question pull-right"></i> Aiuto</a></li>
                    <li><a href="{{url('/logout')}}"><i class="fa fa-sign-out pull-right"></i> Esci</a></li>
                  </ul>
                </li>
                
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
		@endif
		<!-- Content -->
		<div class="right_col" role="main">
			<div class="row tile_count">
				<div class="container-fluid">
					@yield('content')
				</div>
			</div>
		</div>
		<!-- /content -->
        <!-- footer content -->
        <footer>
          <div class="pull-right">
           <p style="text-align:left"><small>2016 © Easy <strong>LANGA</strong> da e per <a href="http://www.langa.tv/"><strong>LANGA Group</strong></small><small><a href="http://easy.langa.tv/changelog">  versione 1.02</small></small></p></a>
          </div>
          <div class="clearfix"></div>
          </div>
        </footer>
        <!-- /footer content -->
      </div>

    <!-- jQuery -->
    <script src="{{asset('/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- jQuery validation js -->
    <script src="{{ url('public/scripts/jquery.validate.min.js')}}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{asset('/build/js/custom.js')}}"></script>
    
    
  </body>
</html>
