
</div>
<!-- /#wrapper -->
<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!--Tinymce text editor-->
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Views',     <?php echo $session->count;?>],
            ['Comments', <? echo Comment::count_all();?>],
            ['Users',  <? echo User::count_all();?>],
            ['Photos',      <? echo Photo::count_all();?>],
        ]);

        var options = {
            legend: 'none',
            pieSliceText: 'label',
            backgroundColor: 'transparent',
            //title: 'Admin',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
</script>

</body>

</html>