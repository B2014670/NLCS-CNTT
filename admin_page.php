<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <!-- bootstrap cdn link -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!-- JavaScript Bundle with Popper -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>

<body>

   <?php @include 'admin_header.php'; ?>

   <section class="dashboard">

      

      <div class="box-container">

         <div class="box">
            <?php
            $total_pendings = 0;
            $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'đang xử lý'") or die('query failed');
            while ($fetch_pendings = mysqli_fetch_assoc($select_pendings)) {
               $total_pendings += $fetch_pendings['total_price'];
            };
            ?>
            <h3><?php echo $total_pendings; ?> đ</h3>
            <p>khoản thu chờ xử lý</p>
         </div>

         <div class="box">
            <?php
            $total_completes = 0;
            $select_completes = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'hoàn thành'") or die('query failed');
            while ($fetch_completes = mysqli_fetch_assoc($select_completes)) {
               $total_completes += $fetch_completes['total_price'];
            };
            ?>
            <h3><?php echo $total_completes; ?> đ</h3>
            <p>doanh thu</p>
         </div>

         <div class="box">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
            ?>
            <h3><?php echo $number_of_orders; ?></h3>
            <p>Đơn hàng</p>
         </div>

         <div class="box">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
            ?>
            <h3><?php echo $number_of_products; ?></h3>
            <p>sản phẩm đã thêm</p>
         </div>
      </div>

   </section>
   <div class="container">
      <div class="row">
         <div class="col-md-6">
            <div class="card shadow mb-4">
               <div class="card-body">
                  <div class="chart-bar">
                     <canvas id="myBarChart" style="height:350px"></canvas>
                  </div>
                  <p class="text-center">Biểu đồ doanh thu theo tháng</p>

               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="card shadow mb-4">
               <div class="card-body">
                  <div class="chart-bar">
                     <canvas id="myChart" style="height:350px"></canvas>
                  </div>
                  <p class="text-center">Biểu đồ lượng sản phẩm bán được</p>

               </div>
            </div>
         </div>
      </div>

   </div>


   <script src="js/admin_script.js"></script>
   <!-- <script src="vendor/chart.js/Chart.min.js"></script> -->
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <script>
      function number_format(number, decimals, dec_point, thousands_sep) {
         // *     example: number_format(1234.56, 2, ',', ' ');

         // *     return: '1 234,56'
         number = (number + '').replace(',', '').replace(' ', '');
         var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
               var k = Math.pow(10, prec);
               return '' + Math.round(n * k) / k;
            };
         // Fix for IE parseFloat(0.55).toFixed(0) = 0;
         s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
         if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
         }
         if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
         }
         return s.join(dec);
      }
      <?php
      // Retrieve the data you want to display
      $query = "SELECT  EXTRACT(MONTH FROM placed_on) AS month ,   
                           SUM(total_price) Total
                  FROM    orders
                  GROUP BY EXTRACT(MONTH FROM placed_on);";
      $result = mysqli_query($conn, $query);

      // Extract the data into separate arrays
      $labels = array();
      $sales = array();
      while ($row = mysqli_fetch_assoc($result)) {
         $labels[] = 'Tháng ' . $row['month'];
         $sales[] = $row['Total'];
      }
      ?>
      var ctx = document.getElementById("myBarChart");
      var myBarChart = new Chart(ctx, {
         type: 'bar',
         data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{

               backgroundColor: "#4e73df",
               hoverBackgroundColor: "#2e59d9",
               borderColor: "#4e73df",
               data: <?php echo json_encode($sales); ?>,
            }],
         },
         options: {
            responsive: true,
            plugins: {
               legend: {
                  display: false
               }
            },
            maintainAspectRatio: false,
            layout: {
               padding: {
                  left: 10,
                  right: 25,
                  top: 25,
                  bottom: 0
               }
            },
            scales: {
               xAxes: [{
                  time: {
                     unit: 'month'
                  },
                  gridLines: {
                     display: false,
                     drawBorder: false
                  },
                  ticks: {
                     maxTicksLimit: 0
                  },
                  maxBarThickness: 25,
               }],
               yAxes: [{
                  ticks: {
                     min: 0,
                     maxTicksLimit: 5,
                     // Include a dollar sign in the ticks
                     callback: function(value, index, values) {
                        return number_format(value) + ' đ';
                     }
                  },
                  gridLines: {
                     color: "rgb(234, 236, 244)",
                     zeroLineColor: "rgb(234, 236, 244)",
                     drawBorder: false,
                     borderDash: [2],
                     zeroLineBorderDash: [2]
                  }
               }],
            },
            legend: {
               display: false
            },
            tooltips: {
               titleMarginBottom: 10,
               titleFontColor: '#6e707e',
               titleFontSize: 14,
               backgroundColor: "rgb(255,255,255)",
               bodyFontColor: "#858796",
               borderColor: '#dddfeb',
               borderWidth: 1,
               xPadding: 15,
               yPadding: 15,
               displayColors: false,
               caretPadding: 10,
               callbacks: {
                  label: function(tooltipItem, chart) {
                     var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                     return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + ' đ';
                  }
               }
            },
         }
      });
   </script>
   <script>
      var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
      var yValues = [55, 49, 44, 24, 15];
      var barColors = ["red", "green", "blue", "orange", "brown"];
      <?php
      // Retrieve the data you want to display
      $query = "SELECT  products.name AS name, SUM(detail_orders.quantity) quantity
                  FROM    detail_orders JOIN products ON detail_orders.pid = products.id
                  GROUP BY products.name;";
      $result = mysqli_query($conn, $query);

      // Extract the data into separate arrays
      $labels = array();
      $count = array();
      while ($row = mysqli_fetch_assoc($result)) {
         $labels[] =$row['name'];
         $count[] = $row['quantity'];
      }
      ?>
      new Chart("myChart", {
         type: "bar",
         data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
               backgroundColor: barColors,
               data: <?php echo json_encode($count); ?>
            }]
         },         
         options: {
            responsive: true,
            plugins: {
               legend: {
                  display: false
               }
            },
            maintainAspectRatio: false,
            layout: {
               padding: {
                  left: 10,
                  right: 25,
                  top: 25,
                  bottom: 0
               }
            },
            scales: {
               xAxes: [{
                  time: {
                     unit: 'month'
                  },
                  gridLines: {
                     display: false,
                     drawBorder: false
                  },
                  ticks: {
                     maxTicksLimit: 0
                  },
                  maxBarThickness: 25,
               }],
               yAxes: [{
                  ticks: {
                     min: 0,
                     maxTicksLimit: 5,                     
                  },
                  gridLines: {
                     color: "rgb(234, 236, 244)",
                     zeroLineColor: "rgb(234, 236, 244)",
                     drawBorder: false,
                     borderDash: [2],
                     zeroLineBorderDash: [2]
                  }
               }],
            },
            legend: {
               display: false
            },           
         }

      });
   </script>
</body>

</html>