<?php 
//$connect = mysqli_connect("localhost", "root", "Maun2806;", "sets_surveillance_r2");
require_once("dbconn.php");
$query = "CALL js_MySQL_uSP_Card_Aggregations()";
$result = mysqli_query($connect, $query);
$chart_data_registered = '';
$chart_data_residents = '';
$chart_data_matched = '';
$chart_data_positive = '';
$chart_data_linked_to_care = '';
//pecentages
$chart_percentage_residency='';
$chart_percentage_matched='';
$chart_percentage_carelinked='';
$chart_percentage_matched_and_positive='';
while($row = mysqli_fetch_array($result))
{
   $chart_data_registered = $row["total_registered"];
   $chart_data_residents=$row["hdss_residents"];
   $chart_data_matched=$row["total_matched"];
   $chart_data_positive=$row["total_positive"];
   $chart_data_linked_to_care=$row["total_linked_to_care"];
   $chart_percentage_residency=$row["percentage_residency"];
   $chart_percentage_matched=$row["percentage_matched"];
   $chart_percentage_carelinked=$row["percentage_linked_to_care"];
   $chart_percentage_matched_and_positive=$row["percentage_matched_and_positive"];
}

$result->free();
mysqli_close($connect);
?>

<?php  
  //fetching facility aggregations here below
 // $connect = mysqli_connect("localhost", "root", "Maun2806;", "sets_surveillance_r2");
 require("dbconn.php");
  $query = "CALL js_MySQL_uSP_Facility_Aggregations()";
  $result = mysqli_query($connect, $query);
  $regchart_data = '';
  while($row = mysqli_fetch_array($result))
   {
    $regchart_data .= "{ facility:'".$row["facility"]."', registered:".$row["registered"].", residents:".$row["residents"].", matched:".$row["matched"].", positive:".$row["positive"].", linked_to_care:".$row["with_ccc_no"]."}, ";
   }
   
  $regchart_data = substr($regchart_data, 0, -2);

  //finally closing the database connection
  $result->free();
  mysqli_close($connect);
?>

<?php
//retrieve the registered positive cases
//$connect = mysqli_connect("localhost", "root", "Maun2806;", "sets_surveillance_r2");
  require("dbconn.php");
  $query = "CALL js_MySQL_uSP_Positive_RollingTotals()";
  $result = mysqli_query($connect, $query);
  $diagnosis_chart_data = '';
  while($row = mysqli_fetch_array($result))
   {
    $diagnosis_chart_data .= "{ year:'".$row["year"]."', total_diagnosed:".$row["total_diagnosed"].", cumulative_sum:".$row["cumulative_sum"]."}, ";
   }
   
  $diagnosis_chart_data = substr($diagnosis_chart_data, 0, -2);

  //finally closing the database connection
  $result->free();
  mysqli_close($connect);
?>

<?php
//retrieve monthly registrations and revisits
//$connect = mysqli_connect("localhost", "root", "Maun2806;", "sets_surveillance_r2");
  require("dbconn.php");
  $query = "CALL js_MySQL_uSP_MonthlyRegistration()";
  $result = mysqli_query($connect, $query);
  $visit_chart_data = '';
  while($row = mysqli_fetch_array($result))
   {
    $visit_chart_data .= "{ month:'".$row["reg_month_name"]."', registered:".$row["monthly_new_registration"].", revisits:".$row["revisits"]."}, ";
   }
   
  $visit_chart_data = substr($visit_chart_data, 0, -2);

  //finally closing the database connection
  $result->free();
  mysqli_close($connect);
?>

<?php
/*
  require("dbconn.php");
  $query = "CALL js_MySQL_uSP_VisitPerDepartment()";
  $result = mysqli_query($connect, $query);
  $department_chart_data = '';
  while($row = mysqli_fetch_array($result))
   {
    $department_chart_data .= "{ department:'".$row["department_visited"]."', visit_count:".$row["total_visit_records"]."}, ";
   }
   
  $department_chart_data = substr($department_chart_data, 0, -2);

  $result->free();
  mysqli_close($connect);
  */
?>

<?php
  require("dbconn.php");
  $query = "CALL js_MySQL_uSP_VisitPerDepartment()";
  $result = mysqli_query($connect, $query);
   $departmental_visit_data = array();
        while($row = mysqli_fetch_array($result))
            {
                  $departmental_visit_data[] = array(
                  'label'  => $row["department_visited"],
                  'value'  => $row["total_visit_records"]
                  );
            }
$departmental_visit_data = json_encode($departmental_visit_data);

$result->free();
mysqli_close($connect);

?>


<!doctype html>
<html class="no-js h-100" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SETS | Home Page</title>
    <meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="styles/extras.1.1.0.min.css">
    <script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- the sytlesheet references here are specific to the visualizations -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <link rel="stylesheet" href="../assets/custom-css.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <!-- this applies to the population pyramid -->
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  
  <!-- end of the visualization stylesheets -->

  <!-- The references below are specific to the legend -->
  <link rel="stylesheet" href="custom-assets/css/custom-css.css">
  <!--
  <script type="text/javascript" src="custom-assets/js/filter.js"></script>
  -->
  <!--adding a jquery reference library here -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- the code snippet below is relevant for the functional legends -->
<link rel="stylesheet" href="custom-assets/css/chart-legends.css">

  </head>
  <body class="h-100">
    <div class="color-switcher animated">
      <h5>Select Filter Criteria</h5>
      <ul class="accent-colors">
        <li class="accent-primary active" data-color="primary">
          <i class="material-icons">check</i><span title="Male">text</span>
        </li>
        <li class="accent-secondary" data-color="secondary">
          <i class="material-icons">check</i>
        </li>
        <li class="accent-success" data-color="success">
          <i class="material-icons">check</i>
        </li>
        <li class="accent-info" data-color="info">
          <i class="material-icons">check</i>
        </li>
        <li class="accent-warning" data-color="warning">
          <i class="material-icons">check</i>
        </li>
        <li class="accent-danger" data-color="danger">
          <i class="material-icons">check</i>
        </li>
      </ul>
      <div class="actions mb-4">
        <a class="mb-2 btn btn-sm btn-primary w-100 d-table mx-auto extra-action" href="https://designrevision.com/downloads/shards-dashboard-lite/">
          <i class="material-icons">cloud</i> Download</a>
        <a class="mb-2 btn btn-sm btn-white w-100 d-table mx-auto extra-action" href="https://designrevision.com/docs/shards-dashboard-lite">
          <i class="material-icons">book</i> Documentation</a>
      </div>
      <div class="social-wrapper">
        <div class="social-actions">
          <h5 class="my-2">Help us Grow</h5>
          <div class="inner-wrapper">
            <a class="github-button" href="https://github.com/DesignRevision/shards-dashboard" data-icon="octicon-star" data-show-count="true" aria-label="Star DesignRevision/shards-dashboard on GitHub">Star</a>
            <!-- <iframe style="width: 91px; height: 21px;"src="https://yvoschaap.com/producthunt/counter.html#href=https%3A%2F%2Fwww.producthunt.com%2Fr%2Fp%2F112998&layout=wide" width="56" height="65" scrolling="no" frameborder="0" allowtransparency="true"></iframe> -->
          </div>
        </div>
        <div id="social-share" data-url="https://designrevision.com/downloads/shards-dashboard-lite/" data-text="🔥 Check out Shards Dashboard Lite, a free and beautiful Bootstrap 4 admin dashboard template!" data-title="share"></div>
        <div class="loading-overlay">
          <div class="spinner"></div>
        </div>
      </div>
      <div class="close">
        <i class="material-icons">close</i>
      </div>
    </div>
    <div class="color-switcher-toggle animated pulse infinite">
      <i class="material-icons">settings</i>
    </div>
    <div class="container-fluid">
      <div class="row">
        <!-- Main Sidebar -->
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
                <div class="d-table m-auto">
                  <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 43px;" src="images/KEMRI.jpg" alt="SETS Dashboard">
                  <span class="d-none d-md-inline ml-1">SETS Dashboard</span>
                </div>
              </a>
              <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
              </a>
            </nav>
          </div>
          <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
            <div class="input-group input-group-seamless ml-3">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fas fa-search"></i>
                </div>
              </div>
              <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search"> </div>
          </form>
          <div class="nav-wrapper">
            <ul class="nav flex-column">

            <!--
              <li class="nav-item">
                <a class="nav-link active" href="index.html">
                  <i class="material-icons">edit</i>
                  <span>Blog Dashboard</span>
                </a>
              </li>

            -->
            <!--
              <li class="nav-item">
                <a class="nav-link " href="components-blog-posts.html">
                  <i class="material-icons">vertical_split</i>
                  <span>Blog Posts</span>
                </a>
              </li>
              -->
              <!--
              <li class="nav-item">
                <a class="nav-link " href="add-new-post.html">
                  <i class="material-icons">note_add</i>
                  <span>Add New Post</span>
                </a>
              </li>

              -->
              <li class="nav-item">
                <a class="nav-link " href="">
                  <i class="material-icons">view_module</i>
                  <span>Dashboard Pages</span>
                  <!--
                  <ul style="list-style-type:disc;">
                  <a><li>Home Page</li></a>
                  <a><li>Registration</li></a>
                  <a><li>Clinical Events</li></a>
                  </ul> 
                  -->

                  <!--
                  <div class="dropdown-container">
                  <a href="#">Home Page</a>
                  <a href="#">Registration</a>
                  <a href="#">Sentinel Events</a>
                  </div>

                  -->
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="">
                  <i class="material-icons">table_chart</i>
                  <span>Summary Tables</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " id="map-opener" href="">
                  <i class="material-icons">person</i>
                  <span>Study Area</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link " id="facility-filter-pane" href="">
                  <i class="material-icons">person</i>
                  <span>Apply filters</span>
                </a>

<form>
 <fieldset id="filter-legend">
  <!--<legend>Select a filter criteria:</legend> -->
  <p>
    Residency status &nbsp; <br />
<input type="checkbox" name="all-clients" value="residents-plus"> All Clients &nbsp; <br />
<input type="checkbox" name="residents" value="residents"> Residents &nbsp; <br />
<input type="checkbox" name="non-residents" value="non-residents"> Non-Residents
    </p>
      <p>Select facility:  
  <select id="facility_code">
  <option value="0">All</option>
  <option value="16792">Wagai</option>
  <option value="14160">Uriri</option>
  <option value="14093">Sirembe</option>
  <option value="18426">Siala</option>
  <option value="14042">Rera</option>
  <option value="13966">Ogero</option>
  <option value="13947">Nyawara</option>
  <option value="17518">Masogo</option>
  <option value="17516">Gongo</option>
  <option value="13533">Dienya</option>
  <option value="16785">Bar-Sauri</option>
  <option value="16783">Asayi</option>
  <option value="13473">Aluor</option>
  <option value="13471">Akala</option>
</select>
</p>
      <p>Gender: 
      <input type="checkbox" name="all-gender" value="all-gender"> All &nbsp;
<input type="checkbox" name="females" value="females"> Females &nbsp;
<input type="checkbox" name="males" value="males"> Males
<br>
      </p>
      <p>
      Select age group &nbsp;
  <select id="age_group" name="age_group">
  <option value="all">All age groups</option>
  <option value="0-10">0-9 years</option>
  <option value="10-15">10-14 years</option>
  <option value="15-20">15-19 years</option>
  <option value="20-25">20-24 years</option>
  <option value="25-50">25-49 years</option>
  <option value="50+">50+ years</option>
  </select>
      </p>
 </fieldset>
</form>



              </li>
                            
            </ul>
          </div>
        </aside>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
          <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
              <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                <div class="input-group input-group-seamless ml-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-search"></i>
                    </div>
                  </div>
                  <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search"> </div>
              </form>
              <ul class="navbar-nav border-left flex-row ">
                <li class="nav-item border-right dropdown notifications">
                  <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="nav-link-icon__wrapper">
                      <i class="material-icons">&#xE7F4;</i>
                      <span class="badge badge-pill badge-danger">2</span>
                    </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">
                      <div class="notification__icon-wrapper">
                        <div class="notification__icon">
                          <i class="material-icons">&#xE6E1;</i>
                        </div>
                      </div>
<?php 

require("dbconn.php");
$query = "CALL usp_js_MySQL_PositiveThis_Month()";
$result = mysqli_query($connect, $query);
$positive_this_month = '';

while($row = mysqli_fetch_array($result))
{
   $positive_this_month = $row["positive_this_month"];
   
}

$result->free();
mysqli_close($connect);

?>

                      
                      <div class="notification__content">
                        <span class="notification__category">HIV Diagnosis</span>
                        <p>There are 
                          <span class="text-success text-semibold"><?php echo $positive_this_month; ?></span> new HIV positive cases recorded in the current month!</p>
                      </div>
                    </a>
                    <a class="dropdown-item" href="#">
                      <div class="notification__icon-wrapper">
                        <div class="notification__icon">
                          <i class="material-icons">&#xE8D1;</i>
                        </div>
                      </div>
                      <div class="notification__content">
                        <span class="notification__category">Lost to Follow Up</span>
                        <p>Lost to follow up cases for last month was at
                          <span class="text-danger text-semibold">5.52%</span> !</p>
                      </div>
                    </a>
                    <a class="dropdown-item notification__all text-center" href="#"> View all Notifications </a>
                  </div>
                </li>

                <li class="nav-item dropdown">
                
                  <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <!--<img class="user-avatar rounded-circle mr-2" src="images/avatars/0.jpg" alt="User Avatar"> -->
                    <span class="d-none d-md-inline-block">Notification area</span>
                  </a>
                  
                  <div class="dropdown-menu dropdown-menu-small">
                    <a class="dropdown-item" href="user-profile-lite.html">
                      <i class="material-icons">&#xE7FD;</i> Profile</a>
                    <a class="dropdown-item" href="components-blog-posts.html">
                      <i class="material-icons">vertical_split</i> Blog Posts</a>
                    <a class="dropdown-item" href="add-new-post.html">
                      <i class="material-icons">note_add</i> Add New Post</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#">
                      <i class="material-icons text-danger">&#xE879;</i> Logout </a>
                  </div>
                </li>
              </ul>
              <nav class="nav">
                <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                  <i class="material-icons">&#xE5D2;</i>
                </a>
              </nav>
            </nav>
          </div>
          <!-- / .main-navbar -->
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <!--<span class="text-uppercase page-subtitle">Dashboard</span>-->
                <!--<h3 class="page-title"><i>Overview</i></h3>-->
              </div>
            </div>
            <!-- End Page Header -->
            <!-- Small Stats Blocks -->
            <div class="row">
              <div class="col-lg col-md-6 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Total Registered</span>
                        <h6 class="stats-small__value count my-3" id="registered_count"><?php echo $chart_data_registered; ?></h6>
                      </div>
                      <div class="stats-small__data">
                       <!-- <span class="stats-small__percentage stats-small__percentage--increase">4.7%</span> -->
                      </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-1"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg col-md-6 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">HDSS Residents</span>
                        <a href=""><h6 class="stats-small__value count my-3" id="residents_count"><?php echo $chart_data_residents; ?></h6></a>
                      </div>
                      <div class="stats-small__data">
                        <span class="stats-small__percentage stats-small__percentage--increase" id="residency_percentage"><?php echo $chart_percentage_residency; ?>%</span>
                      </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-2"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg col-md-4 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Residents Matched to HDSS</span>
                        <h6 class="stats-small__value count my-3" id="matched_count"><?php echo $chart_data_matched; ?></h6>
                      </div>
                      <div class="stats-small__data">
                        <span class="stats-small__percentage stats-small__percentage--increase" id="match_percentage"><?php echo $chart_percentage_matched;?>%</span>
                      </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-3"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg col-md-4 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Matched to HDSS and Positive</span>
                        <h6 class="stats-small__value count my-3" id="matched_positive_count"><?php echo $chart_data_positive; ?></h6>
                      </div>
                      <div class="stats-small__data">
                        <span class="stats-small__percentage stats-small__percentage--increase" id="positive_percentage"><?php echo $chart_percentage_matched_and_positive; ?>%</span>
                      </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-4"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg col-md-4 col-sm-12 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Linked to Care</span>
                        <h6 class="stats-small__value count my-3" id="carelink_count"><?php echo $chart_data_linked_to_care; ?></h6>
                      </div>
                      <div class="stats-small__data">
                        <span class="stats-small__percentage stats-small__percentage--increase" id="carelink_percentage"><?php echo $chart_percentage_carelinked; ?>%</span>
                      </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-5"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Small Stats Blocks -->
            
        <div class="row">

          <div class="chart-container" style="width:100%; height:100%">

          <div id="chart-section">

          <div id="identification-pane" style="border: 3px solid #AAA; width: 45%; height: 23%; display: inline-block;">
<span><p style="text-align:center;"><i>Clients Registred, matched and Linked to HIV Care</i></p></span>
 
   <div id="reg-bar"></div>


   <!--
     <div id="visitor_legend" class="bar-chart-legend"></div>

   <div id="reg_legend" class="bars-legend"></div>
   -->
</div>
   <div id="positive-trend-area" style="border: 3px solid #AAA; width: 51%; height: 23%; display: inline-block;">
   <span><p style="text-align:center;"><i>HIV Infection Trends 
     
   since &nbsp; </i>
   <select name= "baseline_positive_year">
   <option value="0">All:</option>
  <?php 
  require("dbconn.php");
  $query = "CALL js_MySQL_uSP_Diagnosis_Years()";
  $result = mysqli_query($connect, $query);

    while ($row = $result->fetch_assoc())
        {
        echo '<option value="'.$row['year_value'].'">'.$row['year_display']. '</option>';

        }
?>
</select>
  </p></span>
      <div id="positive-trend-chart"></div> 
</div>
<br />
   <!--<div id="chart_div" style="width: 45%; height:23%; display: inline-block;"></div> -->
   <div id="departmental_visit" style="border: 3px solid #AAA; width: 45%; height: 23%; display: inline-block;">
   <span><p style="text-align:center;"><i>Visit log count per department</i></p></span>
   <div id="department-chart"></div>
   <!--
   <div id="visit_legend" class="donut-legend"></div>
   -->
</div>
   <div id="visit_trends" style="border: 3px solid #AAA; width: 51%; height: 23%; display: inline-block;">
     <span><p style="text-align:center;"><i>Monthly Registrations and Revisits for <?php echo date("Y"); ?></i></p></span>
   <div id="visit-line"></div>
    </div>

          </div>

     </div>

</div>

          <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Blog</a>
              </li>
            </ul>
            <span class="copyright ml-auto my-auto mr-2">Copyright &copy; <?php echo date("Y"); ?>
              <a href="https://designrevision.com" rel="nofollow">Surveillance and Evaluation of Test and Start</a>
            </span>
          </footer>
        </main>
      </div>
    </div>
    <div class="promo-popup animated">
      <a href="http://bit.ly/shards-dashboard-pro" class="pp-cta extra-action">
        <img src="https://dgc2qnsehk7ta.cloudfront.net/uploads/sd-blog-promo-2.jpg"> </a>
      <div class="pp-intro-bar"> Need More Templates?
        <span class="close">
          <i class="material-icons">close</i>
        </span>
        <span class="up">
          <i class="material-icons">keyboard_arrow_up</i>
        </span>
      </div>
      <div class="pp-inner-content">
        <h2>Shards Dashboard Pro</h2>
        <p>A premium & modern Bootstrap 4 admin dashboard template pack.</p>
        <a class="pp-cta extra-action" href="http://bit.ly/shards-dashboard-pro">Download</a>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="scripts/extras.1.1.0.min.js"></script>
    <script src="scripts/shards-dashboards.1.1.0.min.js"></script>
    <script src="scripts/app/app-blog-overview.1.1.0.js"></script>
  </body>
  <script src="data_filter.js"></script>
</html>

<script type="text/javascript" src="custom-assets/js/filter.js"></script>
<script>
/*
Morris.Bar({
 element : 'bar',
 data:[<?php echo $chart_data; ?>],
 xkey:'year',
 ykeys:['profit', 'purchase', 'sale'],
 labels:['Profit', 'Purchase', 'Sale'],
 hideHover:'auto',
 stacked:false
});

*/

/*

Morris.Area({
 element : 'pie',
 data:[<?php echo $chart_data; ?>],
 xkey:'year',
 ykeys:['profit', 'purchase', 'sale'],
 labels:['Profit', 'Purchase', 'Sale'],
 hideHover:'auto',
 stacked:true
});

*/

var reg_Chart = Morris.Bar({
 element : 'reg-bar',
 data:[<?php echo $regchart_data; ?>],
 xkey:'facility',
 ykeys:['registered', 'residents', 'matched', 'positive', 'linked_to_care'],
 labels:['Registered', 'Residents', 'Matched', 'Positive', 'Linked to HIV Care'],
 hideHover:'auto',
 xLabelAngle: 71,
 xLabelMargin: 10,
 stacked:false,
 fillOpacity: '0.7',
   options: {
        legend: {
            labels: {
                // This more specific font property overrides the global property
                fontStyle: 'bold',
                fontColor: 'black'

            }
        }
    }
 
 
});


reg_Chart.options.labels.forEach(function(label, i) {
    var legendItem = $('<span></span>').text( label).prepend('<br><span>&nbsp;</span>');
    legendItem.find('span')
      .css('backgroundColor', reg_Chart.options.barColors[i])
      .css('width', '20px')
      .css('display', 'inline-block')
      .css('margin', '5px');
    $('#reg_legend').append(legendItem)
  });

/*

reg_Chart.options.labels.forEach(function(label, i) {
  var legendItem = $('<span class="legend-item"></span>').text( label).prepend('<span class="legend-color">&nbsp;</span>');
  legendItem.find('span').css('backgroundColor', reg_Chart.options.barColors[i]);
  $('#visitor_legend').append(legendItem) // ID pf the legend div declared above
});

*/


Morris.Area({
 element : 'positive-trend-chart',
 data:[<?php echo $diagnosis_chart_data; ?>],
 xkey:'year',
 ykeys:['total_diagnosed', 'cumulative_sum'],
 labels:['Registered HIV Positive cases', 'Rolling Total'],
 hideHover:'auto',
 xLabelAngle: 90,
 xLabelMargin: 5,
 parseTime: false,
  stacked:true
 
});

  var visits_chart = Morris.Donut({
     element: 'department-chart',
     data: <?php echo $departmental_visit_data; ?>
    });

  visits_chart.options.data.forEach(function(label, i){
    var legendItem = $('<span></span>').text(label['label']).prepend('<i>&nbsp;</i>');
    legendItem.find('i').css('backgroundColor', visits_chart.options.colors[i]);
    $('#visit_legend').append(legendItem)
  })

//this is the code for the population pyramid

/*
google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(chart);
 
        function chart()
        {
            //var data = new google.visualization.DataTable();
 


            var dataArray = 
            [
                ['Age', 'Male', 'Female'],
                ['0-9 years',   5501, -5751],
                ['10-14 years',   2553,  -2904 ],
                ['15-19 years', 2260,  -3368 ],
                ['20-24 years', 851,  -3125 ],
                ['25-49 years', 2896,  -8255 ],
                ['50 + years', 1625,  -3200 ]
            ];

                    
 
            var data = google.visualization.arrayToDataTable(dataArray);
 
            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
 
            var options = {
                isStacked: true,
                hAxis: {
                    format: ';'
                },
                vAxis: {
                    direction: -1
                    
                }
            };
 
 
            var formatter = new google.visualization.NumberFormat({
                pattern: ';'
            });
 
            formatter.format(data, 2)
 
            chart.draw(data, options);
        }

        */

Morris.Line({
 element : 'visit-line',
 data:[<?php echo $visit_chart_data; ?>],
 xkey:'month',
 ykeys:['registered', 'revisits'],
 labels:['Newly registered', 'Revisits'],
 hideHover:'auto',
 xLabelAngle: 90,
 xLabelMargin: 5,
 parseTime: false,
  stacked:true
 
});

</script>