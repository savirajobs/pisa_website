<script>
    $(document).ready(function() {
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Private Sale Tokens at $0.05', 18.75],
                ['Presale Tokens at 0.34 XLM', 31.25],
                ['Presale 20% Bonus Reserve', 10],
                ['Released on Exchange(s) Launch', 10],
                ['Slow release for 48 Mo @ 116 666.67/mo', 17.5],
                ['Founders (Locked for 1Y)', 3.125],
                ['Marketing/ Community', 3.125],
                ['Legal/ Unforseen Fees (Reserve)', 3.125],
                ['Development Token Reserve', 3.125],
            ]);

            var options = {
                title: 'My Day Schedule',
                pieSliceText: 'value',
                is3D: true
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart3d'));

            chart.draw(data, options);
        }
    });
</script>
