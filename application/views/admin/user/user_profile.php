<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Resume - <?= $bio['firstname'] ?></title>
</head>
<body>
<table border="1" width="100%" style="border-collapse: collapse;">
    <div id="paper">
      <div id="paper-mid">
        <div class="entry">
          <img class="portrait" src="<?= $bio['picture'] ?>" width="85" height="85" />
          <div class="self">
            <h1 class="name"><?= ucwords($bio['firstname']) ?> <?= ucwords($bio['lastname']) ?> <br />
        	</h1>
        	<?php if ($jobTitle) { ?>
      			<span><?= ucwords($jobTitle['title']) ?></span>
        	<?php } ?>
            <ul>
            	<?php if ($bio['email']) { ?>
            		<li><?= $bio['email'] ?></li>
            	<?php } ?>
            	<?php if ($bio['phone']) { ?>
            		<li><?= $bio['phone'] ?></li>
            	<?php } ?>
            	<?php if ($bio['date_of_birth']) { ?>
            		<li><?= date("d/M/Y", strtotime($bio['date_of_birth'])) ?></li>
            	<?php } ?>
            	<?php if ($bio['expected_salary']) { ?>
            		<li>Rp <?=  number_format($bio['expected_salary'],0,',','.') ?></li>
            	<?php } ?>
            </ul>
          </div>
        </div>
        <!-- <div class="entry">
          <h2>OBJECTIVE</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin dignissim viverra nibh sed varius. Proin bibendum nunc in sem ultrices posuere. Aliquam ut aliquam lacus.</p>
        </div> -->
        <?php if ($education) { ?>
        	<div class="entry">
	          	<h2>EDUCATION</h2>
	          	<?php foreach ($education as $value) { ?>
		      		<div class="content">
		      			<?php $graduation = $value->year_graduation.'-'.$value->month_graduation?>
			            <h3><?= date("M Y", strtotime($graduation)) ?></h3>
			            <p><?= $value->institute?><br />
			            <em><?= $value->level_name ?> - <?= $value->jurusan ?></em></p>
					</div>
	          	<?php } ?>
	        </div>
        <?php } ?>
        <?php if ($experience) { ?>
        	<div class="entry">
				<h2>EXPERIENCE</h2>
				<?php foreach ($experience as $value) { ?>
					<div class="content">
						<h3><?= $value->duration?></h3>
						<p><?= $value->title?><br />
						<em><?= $value->position_name?></em></p>
						<!-- <ul class="info">
							<li>Vestibulum eu ante massa, sed rhoncus velit.</li>
							<li>Pellentesque at lectus in <a href="#">libero dapibus</a> cursus. Sed arcu ipsum, varius at ultricies acuro, tincidunt iaculis diam.</li>
						</ul> -->
					</div>
				<?php } ?>
			</div>
        <?php } ?>
        <!-- <div class="entry">
          <h2>EXPERIENCE</h2>
          <div class="content">
            <h3>May 2009 - Feb 2010</h3>
            <p>Agency Creative, London <br />
              <em>Senior Web Designer</em></p>
            <ul class="info">
              <li>Vestibulum eu ante massa, sed rhoncus velit.</li>
              <li>Pellentesque at lectus in <a href="#">libero dapibus</a> cursus. Sed arcu ipsum, varius at ultricies acuro, tincidunt iaculis diam.</li>
            </ul>
          </div>
          <div class="content">
            <h3>Jun 2007 - May 2009</h3>
            <p>Junior Web Designer <br />
              <em>Bachelor of Science in Graphic Design</em></p>
            <ul class="info">
              <li>Sed fermentum sollicitudin interdum. Etiam imperdiet sapien in dolor rhoncus a semper tortor posuere. </li>
              <li>Pellentesque at lectus in libero dapibus cursus. Sed arcu ipsum, varius at ultricies acuro, tincidunt iaculis diam.</li>
            </ul>
          </div>
        </div> -->
        <!-- <div class="entry">
          <h2>SKILLS</h2>
          <div class="content">
            <h3>Software Knowledge</h3>
            <ul class="skills">
              <li>Photoshop</li>
              <li>Illustrator</li>
              <li>InDesign</li>
              <li>Flash</li>
              <li>Fireworks</li>
              <li>Dreamweaver</li>
              <li>After Effects</li>
              <li>Cinema 4D</li>
              <li>Maya</li>
            </ul>
          </div>
          <div class="content">
            <h3>Languages</h3>
            <ul class="skills">
              <li>CSS/XHTML</li>
              <li>PHP</li>
              <li>JavaScript</li>
              <li>Ruby on Rails</li>
              <li>ActionScript</li>
              <li>C++</li>
            </ul>
          </div>
        </div> -->
      </div>
      <div class="clear"></div>
    </div>
</table>
</body>
</html>