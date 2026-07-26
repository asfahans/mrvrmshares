<?php
// Include the database configuration
include('config.php');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Define pagination variables
$records_per_page = 10; // Number of feedback entries per page
// Get the current page number from the URL, or set it to 1 if not provided
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
// Calculate the OFFSET for the SQL query
$offset = ($current_page - 1) * $records_per_page;

// Fetch feedback data with pagination
// You can use SQL queries with LIMIT and OFFSET here
$sql = "SELECT * FROM feedback LIMIT $records_per_page OFFSET $offset";
// Execute the query and fetch data
$result = $conn->query($sql);

// Query to count the total number of records
$count_query = "SELECT COUNT(*) AS total_records FROM feedback";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_records = $count_data['total_records'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>VRM - Share broking Pvt. Ltd. | Feedback List</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <!-- Stylesheets -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- Responsive File -->
    <link href="css/responsive.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">

    <!-- Responsive Settings -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
    <!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
</head>
<body>
    <body>

<div class="page-wrapper">
    <!-- Preloader -->
    <div class="preloader"><div class="icon"></div></div>

   <!-- Main Header -->
    <header class="main-header header-style-one">
        <!-- Header Top -->
        <div class="header-top header-top-one">
            <div class="auto-container">
                <div class="inner clearfix">
                    <div class="top-left clearfix">
                        <div class="top-text"><a class="btn btn-primary" href="https://mrvrmshare.com/mrsharebroking/index.html" target="blank" role="button">MR SHARE BROKING PVT. LTD</a></div>
                    </div>
    
                    <div class="top-right clearfix">
                        <!--Info-->
                        <div class="info">
                            <ul class="clearfix">
                                <li class="phone"><a href="tel:500.369.2580"><span class="icon sl-icon-call-in"></span>Phone <strong>022-66228050/52/57/60</strong></a></li>
                                <li class="email"><a href="mailto:info@vrmshares.com"><span class="icon sl-icon-envelope-open"></span>info@vrmshares.com</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Header Upper -->
        <div class="header-upper">
            <div class="auto-container">
                <div class="inner-container clearfix">
                    <!--Logo-->
                    <div class="logo-box">
                 <div class="logo"><a href="index.html" title="U3 Technologies"><img src="images/logo.png" alt="" title=""></a></div> 
                    </div>
                    <div class="right-nav clearfix">
                        <div class="nav-outer clearfix">
                            <!--Mobile Navigation Toggler-->
                            <div class="mobile-nav-toggler"><span class="icon flaticon-menu-1"></span></div>

                            <!-- Main Menu -->
                            <nav class="main-menu navbar-expand-md navbar-light">
                                <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                    <ul class="navigation clearfix">
                                        <li><a href="index.html">Home</a></li>
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="services.html">Our Services</a></li>
                                        <li><a href="faq.html">FAQ</a></li>
                                        <li class="dropdown"><a href="#" target="blank">Investor</a>
                                            <ul>
                                            <li><a href="VRM-DO-AND-DONT-DO.pdf" target="blank">GUIDANCE NOTE - DO;S AND DON'TS</a></li>
                                            <li><a href="StockBroker-InvestorCharter.pdf" target="blank">INVESTOR CHARTER - STOCK BROKERS - SEBI</a></li>
                                            <li><a href="investercharter.pdf" target="blank">INVESTOR CHARTER - STOCK BROKERS</a></li>
                                            <li><a href="RIGHTS-AND-OBLIGATIONS-OF-STOCK-BROKERS-SUB-BROKERS-AND-CLIENTS.pdf" target="blank">RIGHTS AND OBLIGATION STOCK BROKERS</a></li>
                                            <li><a href="Risk Management Ploicy-VRM.pdf" target="blank">RISK MANAGEMENT POLICY</a></li>
                                            <li><a href="Invester Grievances-VRM.pdf" target="blank">INVESTOR COMPLAINT STATISTICS</a></li>
                                            <li><a href="PMLA-VRM.pdf" target="blank">PMLA</a></li>
                                            <li><a href="Surveillance-Policy-VRM.pdf" target="blank">SURVEILLANCE POLICY</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="feedback.php">Support</a></li>
                                        <li><a href="contact.html">Contact Us</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        <!--End Header Upper-->

        <!-- Sticky Header  -->
        <div class="sticky-header">
            <div class="auto-container clearfix">
                <!--Logo-->
              
                <div class="logo pull-left">
                    <a href="index.html" title=""><img src="images/sticky-logo.png" alt="" title=""></a>
                </div>
                
                <!--Right Col-->
                <div class="pull-right">
                    <!-- Main Menu -->
                    <nav class="main-menu clearfix">
                        <!--Keep This Empty / Menu will come through Javascript-->
                    </nav><!-- Main Menu End-->
                </div>
            </div>
        </div><!-- End Sticky Menu -->

        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><span class="icon flaticon-targeting-cross"></span></div>
            
            <nav class="menu-box">
        <!--  <div class="nav-logo"><a href="index.html"><img src="images/nav-logo.png" alt="" title=""></a></div>-->
                <div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
                <!--Social Links-->

            </nav>
        </div><!-- End Mobile Menu -->
    </header>
    <!-- End Main Header -->




    <!-- Inner Banner Section -->
    <section class="inner-banner">
        <div class="banner-curve"></div>
        <div class="auto-container">
            <div class="inner">
                <div class="theme-icon"></div>
                <div class="title-box">
                    <h1>Feedback List</h1>
                    <div class="d-text">VRM Share Broking  Private Limited</div>
                </div>
            </div>
        </div>
    </section>
    <!--End Banner Section -->

    <!--About Section-->
    <!--About Section-->
    <section class="about-section">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="text-column col-lg-6 col-md-12 col-sm-12">
                    <div class="inner">
                        <div class="sec-title">
                            <div class="upper-text">List of Feedback</div>
                        </div>
                        <div class="text-content">
                            <table border="1" class="table table-bordered table-striped">
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Ticket No</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <?php 
                                while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['message'] ?></td>
                                    <td><?= $row['ticket_no'] ?></td>
                                    <?php if($row['ticket_status'] == 0){ ?>
                                    <td>Received</td>
                                    <td><a href="change_status.php?id=<?= $row['ticket_no']?>&status=1">Change to In Process</a></td>
                                    <?php }elseif ($row['ticket_status'] == 1) { ?>
                                    <td>In Process</td>
                                    <td><a href="change_status.php?id=<?= $row['ticket_no']?>&status=2">Change to Closed</a></td>
                                    <?php }else{ ?>
                                    <td>Closed</td>
                                    <td>-</td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </table>
                            <!-- Display pagination links -->
        <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php
        $total_pages = ceil($total_records / $records_per_page);

        // Create the "Previous" link
        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '">Previous</a></li>';
        }

        // Create numbered pagination links
        for ($i = 1; $i <= $total_pages; $i++) {
            $active = ($i == $current_page) ? 'active' : '';
            echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }

        // Create the "Next" link
        if ($current_page < $total_pages) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '">Next</a></li>';
        }
        ?>
    </ul>
</nav>

                            <?php $conn->close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Separator-->
    <div class="theme-separator"></div>
    

    <!--Separator-->
    <div class="theme-separator"></div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="top-pattern-layer-dark"></div>
        
        <!--Widgets Section-->
        <div class="widgets-section">
            <div class="auto-container">
                <div class="row clearfix">
                    
                    <!--Column-->
                    <div class="column col-xl-3 col-lg-12 col-md-12 col-sm-12">
                        <div class="footer-widget about-widget">
                            <!--
                            <div class="logo">
                                <a href="#"><img src="images/footer-logo.png" alt=""></a>
                            </div>
                            -->
                             <div class="widget-title">
                                <h4>VRM Share Broking Private Limited</h4>
                             </div>
                            <div class="info">
                                <ul>
                                    <li>Member of NSE<br/>
                                        SEBI registration No- INZ000256739<br/>
                                        CIN NO: U67120MH2000PTC125421<br/>
                                        Date of incorporation: 29/03/2000<br/>
                                        GST NO- 27AABCV1534C1ZR<br/>
                                    </li>

                                     <li><strong>Address:</strong><br/>
                                        3A 1ST FLOOR PLOT NO-285, CHATURBHUJ JIVANDAS BUILDING SHAMALDAS GANDHI MARG, MARINE LINES EAST  MUMBAI 400002</li>

                                            <li>Contact No: <br/><strong>022-66228050</strong></li>
                                            <li>Dealing Room: <br/><strong>022-66228045/66228038/66228039</strong></li>
                                            <li>Back Office: <br/><strong>022-66228025/66228052/<br/>66228057/66225060</strong></li>
                                            <li>Designate Directors: <br/><strong>1 Ramautar Sohanlal Jhawar <br/>
                                            2 Vinit Ramautar Jhawar</strong></li>
                                          
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!--Column-->
                    <div class="column col-xl-9 col-lg-12 col-md-12 col-sm-12">
                        <div class="footer-widget links-widget">
                            <div class="widget-content">
                                <div class="row clearfix">
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <div class="row clearfix">
                                            <div class="column col-lg-4 col-md-4 col-sm-12">
                                                <div class="widget-title">
                                                    <h4>Principal Officer</h4>
                                                </div>

                                                <ul class="info">
                                            <li><strong>Raj Kumar Pandey</strong></li>
                                            <li> Contact No:<br/> <strong> 022-66228057/9322272483</strong></li>
                                             <li> <strong> rkpandey@vrmshares.com</strong></li>
                                            
                                                </ul>

                                            </div>
                                            <div class="column col-lg-4 col-md-4 col-sm-12">
                                                <div class="widget-title">
                                                    <h4>Complaince Officer</h4>
                                                </div>
                                                <ul class="info">
                                            <li><strong>Rajkumar Pandey</strong></li>
                                            <li> Contact No:<br/> <strong> 022-66228057/9322272483</strong></li>
                                              <li> <strong> rkpandey@vrmshares.com</strong></li>
                                               <li> Investor grievance:<br/> <strong> info@vrmshares.com </strong></li>
                                                </ul>
                                            </div>
                                            <div class="column col-lg-4 col-md-4 col-sm-12">
                                                <div class="widget-title">
                                                   
                                                </div>
                                                <ul class="links">
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column col-lg-4 col-md-12 col-sm-12">


                                        <div class="social-links">

                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="auto-container">
                <div class="inner">
                    <div class="copyright">&copy; 2023 <strong>VRM Share broking Pvt. Ltd.</strong>. All rights reserved. <a href="#">Privacy Policy</a></div>
                </div>
            </div>
        </div>
        
    </footer>

</div>
<!--End pagewrapper-->

<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/owl.js"></script>
<script src="js/scrollbar.js"></script>
<script src="js/validate.js"></script>
<script src="js/appear.js"></script>
<script src="js/wow.js"></script>
<script src="js/custom-script.js"></script>

</body>

</html>
