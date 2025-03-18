<footer class="footer">
    <div class="container-fluid d-flex justify-content-between">
      <nav class="pull-left">
        <ul class="nav">
           
        </ul>
      </nav>
      <div class="copyright">
        <span style="font-weight: bold;">Dashboard Admin umalo.id &copy; Umalo Div IT,</span> 2024, dibuat dengan <i class="fa fa-heart heart text-danger"></i>
      </div>
      <div>
        Version 2.0
       </div>
    </div>
  </footer>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script src="{{asset('assets/js/admin/core/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('assets/js/admin/core/popper.min.js')}}"></script>
<script src="{{asset('assets/js/admin/core/bootstrap.min.js')}}"></script>

<!-- jQuery Scrollbar -->
<script src="{{asset('assets/js/admin/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

<!-- Chart JS -->
<script src="{{asset('assets/js/admin/plugin/chart.js/chart.min.js')}}"></script>

<!-- jQuery Sparkline -->
<script src="{{asset('assets/js/admin/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

<!-- Chart Circle -->
<script src="{{asset('assets/js/admin/plugin/chart-circle/circles.min.js')}}"></script>

<!-- Datatables -->
<script src="{{asset('assets/js/admin/plugin/datatables/datatables.min.js')}}"></script>

<!-- Bootstrap Notify -->
<script src="{{asset('assets/js/admin/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

<!-- jQuery Vector Maps -->
<script src="{{asset('assets/js/admin/plugin/jsvectormap/jsvectormap.min.js')}}"></script>
<script src="{{asset('assets/js/admin/plugin/jsvectormap/world.js')}}"></script>

<!-- Sweet Alert -->
<script src="{{asset('assets/js/admin/plugin/sweetalert/sweetalert.min.js')}}"></script>

<!-- Kaiadmin JS -->
<script src="{{asset('assets/js/admin/kaiadmin.min.js')}}"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="{{asset('assets/js/admin/setting-demo.js')}}"></script>
{{-- <script src="{{asset('assets/js/admin/demo.js')}}"></script>
 --}}



<script>
  $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#177dff",
    fillColor: "rgba(23, 125, 255, 0.14)",
  });

  $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#f3545d",
    fillColor: "rgba(243, 84, 93, .14)",
  });

  $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#ffa534",
    fillColor: "rgba(255, 165, 52, .14)",
  });
</script>
</body>
</html>
