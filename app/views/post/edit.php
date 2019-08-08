<body id="vb-page-body" class="game-forum">
  <form method="post">
	<div id="game-header-subnav">
		<div>
			<ul id="breadcrumbs">
                <li class="crumb"><a href="<?php echo htmlspecialchars('/home/index');?>">
                        <?php echo $ini_array[$language]['Home'] ?> / &nbsp;</a><?php echo $ini_array[$language]['Post'] ?>
                </li>
			</ul>
		</div>
        <?php include "app/views/template/common.php" ?>
	</div>
      <input hidden name="ret" id="ret">
	<div id="game-content" class="forum-container">
        <input hidden name="post_id" value="<?php echo $post['post_id']?>"
		<div class="widget-tabs">
			<ul class="widget-tabs-nav">
				<li class="ui-tabs-active "><a class="ui-tabs-anchor"
					id="ui-id-1"> <?php echo $ini_array[$language]['MAKE A POST'] ?> </a></li>
			</ul>
			<div class="b-content-entry" style="position: relative;">
				<div class="post-title">
					<div class="title">
                        <?php echo $ini_array[$language]['Post Title'] ?>
					</div>
				</div>
				<div class="b-editor">
					<input type="text" placeholder="<?php echo $ini_array[$language]['Write something...'] ?>"
						name="post_title" value="<?php echo $post['post_title']?>" maxlength="45"></input>
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
						name="post_content" maxlength="250"><?php echo $post['post_content']?></textarea>
				</div>
				<div class="b-button-group">
					<button type="submit" class="b-button b-button--primary" formaction="<?php echo htmlspecialchars('/post/doEdit?'.$post['post_id']);?>">
                        <?php echo $ini_array[$language]['Submit'] ?>
                    </button>
				</div>
			</div>
		</div>
	</div>
  </form>
  <?php include "app/views/template/language.php" ?>
</body>