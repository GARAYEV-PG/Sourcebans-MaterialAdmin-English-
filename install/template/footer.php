<?php if(!defined("IN_SB")){echo "You should not be here. Only follow links!";die();} ?>
		</div>
	</section>
</section>
		
		 <footer id="footer">
			<div id="sm">
				Created <a class="footer_link" href="http://www.sourcemod.net" target="_blank">SourceMod</a>
			</div>
            
            <ul class="f-menu">
                <li><?php echo SB_VERSION;?></li>
                <li><a href="http://www.sourcebans.net" target="_blank" class="footer_link">Team SourceBans</a></li>
            </ul>
        </footer>
<?php
if(isset($_GET['debug']) && $_GET['debug'] == 1)
{
	echo '
	<h3>Session details</h3><pre>
'; print_r($_SESSION); 
echo '
</pre>
<h3>Details of POST requests</h3><pre>
';
 print_r($_POST); 
 echo '
</pre>
<h3>Cookies details</h3><pre>
'; 
 print_r($_COOKIE); echo'
</pre> ';
}

?>
<script type="text/javascript">
window.addEvent('domready', function() {
	var Tips2 = new Tips($$('.tip'), {
		initialize:function(){
			this.fx = new Fx.Style(this.toolTip, 'opacity', {duration: 300, wait: false}).set(0);
		},
		onShow: function(toolTip) {
			this.fx.start(1);
		},
		onHide: function(toolTip) {
			this.fx.start(0);
		}
	});
	var Tips4 = new Tips($$('.perm'), {
		className: 'perm'
	});
}); 
$('content_title').setHTML('<?php echo $GLOBALS['TitleRewrite'] ?>');
</script>
<!--[if lt IE 7]>
<script defer type="text/javascript" src="./scripts/pngfix.js"></script>
<![endif]-->

		<!-- Javascript Libraries -->
        <script src="../theme/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../theme/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        
        <script src="../theme/vendors/bower_components/flot/jquery.flot.js"></script>
        <script src="../theme/vendors/bower_components/flot/jquery.flot.resize.js"></script>
        <script src="../theme/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>
        <script src="../theme/vendors/sparklines/jquery.sparkline.min.js"></script>
        <script src="../theme/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
        
        <script src="../theme/vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="../theme/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        <script src="../theme/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
        <script src="../theme/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="../theme/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="../theme/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
        <script src="../theme/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
		<script src="../theme/js/flot-charts/curved-line-chart.js"></script>
        <script src="../theme/js/flot-charts/line-chart.js"></script>
        <script src="../theme/js/charts.js"></script>
        
        <script src="../theme/js/charts.js"></script>
        <script src="../theme/js/functions.js"></script>
        <script src="../theme/js/demo.js"></script>
		
		<script src="../theme/vendors/summernote/dist/summernote-updated.min.js"></script>
		
        <script src="../theme/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>
        <script src="../theme/vendors/bower_components/chosen/chosen.jquery.min.js"></script>
		
		<script>
		  $.noConflict();
		</script>
</body>
</html>
