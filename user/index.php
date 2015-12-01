<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      <?php include("include/header.php"); ?>
      <?php include("include/sidebar.php"); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Dashboard
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <img src="../dist/img/pekalongan-banner.jpg" style="width:100%">
            </section>
          </div>
        </section>
      </div>
      <?php include("include/footer.php"); ?>
    </div>
    <?php include("include/loadjs.php"); ?>
    <script src="../dist/js/raphael-min.js"></script>
    <script src="../plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="../plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $("li#index").addClass("active");
        $.ajax({
          type: "post",
          url: '../core/dashboard/prosesdashboard',
          data: {manage:'countdata'},
          dataType: "json",
          success: function (output) {     
            $('#totaluapb').html(output.uapb);
            $('#totaluappbe').html(output.uappbe);
            $('#totaluappbw').html(output.uappbw);
            $('#totaluakpb').html(output.uakpb);
          }
        });
        $(".knob").knob();
        var donut = new Morris.Donut({
          element: 'sales-chart',
          resize: true,
          colors: ["#3c8dbc", "#f56954", "#00a65a"],
          data: [
            {label: "Aspal", value: 12},
            {label: "Semen", value: 30},
            {label: "Kaca", value: 20}
          ],
          hideHover: 'auto'
        });
        var line = new Morris.Line({
          element: 'line-chart',
          resize: true,
          data: [
            {y: '2011 Q1', item1: 2666},
            {y: '2011 Q2', item1: 2778},
            {y: '2011 Q3', item1: 4912},
            {y: '2011 Q4', item1: 3767},
            {y: '2012 Q1', item1: 6810},
            {y: '2012 Q2', item1: 5670},
            {y: '2012 Q3', item1: 4820},
            {y: '2012 Q4', item1: 15073},
            {y: '2013 Q1', item1: 10687},
            {y: '2013 Q2', item1: 8432}
          ],
          xkey: 'y',
          ykeys: ['item1'],
          labels: ['Item 1'],
          lineColors: ['#efefef'],
          lineWidth: 2,
          hideHover: 'auto',
          gridTextColor: "#fff",
          gridStrokeWidth: 0.4,
          pointSize: 4,
          pointStrokeColors: ["#efefef"],
          gridLineColor: "#efefef",
          gridTextFamily: "Open Sans",
          gridTextSize: 10
        });
      });
    </script>
  </body>
</html>
