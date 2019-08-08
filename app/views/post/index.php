<body id="vb-page-body" class="game-forum">
  <form method="post">
	<div id="game-header-subnav">
		<div>
			<ul id="breadcrumbs">
                <li class="crumb"><a href="<?php echo htmlspecialchars('/home/index');?>"><?php echo $ini_array[$language]['Home'] ?> </a> / &nbsp;<?php echo $ini_array[$language]['Home'] ?>Post</li>
			</ul>
		</div>
        <?php include "app/views/template/common.php" ?>
	</div>
	<div id="game-content" class="forum-container">
		<div class="widget-tabs">
			<ul class="widget-tabs-nav">
				<li class="ui-tabs-active "><a class="ui-tabs-anchor"
					id="ui-id-1"><?php echo $ini_array[$language]['MAKE A POST'] ?>  </a></li>
			</ul>
			<div class="b-content-entry" style="position: relative;">
				<div class="post-title">
					<div class="title">
                        <?php echo $ini_array[$language]['Post Title'] ?>
					</div>
				</div>
				<div class="b-editor">
					<input type="text" placeholder="<?php echo $ini_array[$language]['Write something...'] ?>"
						name="post_title" maxlength="45"></input>
				</div>
			</div>
			<div class="b-content-entry" style="position: relative;">
                <div class="post-title">
                    <div class="title">
                        <?php echo $ini_array[$language]['Post Content'] ?>
                    </div>
                </div>
				<div class="b-editor">
					<textarea id="inputor" class="make-post-text" placeholder="<?php echo $ini_array[$language]['Write something...'] ?>" class="" rows="2"
						name="post_content" maxlength="250"></textarea>
				</div>
				<div class="b-button-group">
					<button type="submit" class="b-button b-button--primary" formaction="<?php echo htmlspecialchars('/post/add');?>"><?php echo $ini_array[$language]['Submit'] ?></button>
				</div>
			</div>
		</div>
	</div>

  </form>
  <?php include "app/views/template/language.php" ?>
</body>