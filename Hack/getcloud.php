<?php if(isset($_GET['words']) && isset($_GET['max'])){ ?>

    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>


    <div id="myChart"></div>

    <script type="text/javascript">
        ZC.LICENSE=["b55b025e438fa8a98e32482b5f768ff5"];

        var myConfig = { 
            type: "wordcloud", 
            options: { 
                text: "<?php echo str_replace(";", " ", $_GET['words']); ?>", 
                minLength: 1, 
                maxItems: <?php echo $_GET['max']; ?>, 
                rotate: true
            }
        }; 
        
        zingchart.render({ 
            id: "myChart", 
            data: myConfig, 
            height: 400, 
            width: "100%"
        });
    </script>

<?php } ?>