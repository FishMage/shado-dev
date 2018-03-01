<div id="howTab" style="display: none;">
	<h3 style="text-align: center;"> <u><em>How</em> might we improve operator workload as well as overall system efficiency and safety?  </u></h3>
	<br>
	<ul>
	<?php if($penalty_high>0.5){ ?>
	<li>Providing additional support to your <?php echo $assistant;?> for some part of their shift may help him/her maintain moderate levels of workload</li>
	<?php } ?>

	<?php if($count_low>$count_norm){ ?>
	<li>Providing situational awareness to your <?php echo $assistant;?> for some part of their shift may help him/her maintain moderate levels of workload</li>
	<?php } ?>
	</ul>
</div>
