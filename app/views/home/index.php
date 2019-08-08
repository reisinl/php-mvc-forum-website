<body id="vb-page-body" class="game-forum">
  <form method="post" id="post-form">
      <div id="game-header-subnav">
        <div>
          <ul id="breadcrumbs">
            <li class="crumb">
              <a href="#">
                  <?php echo $ini_array[$language]['Home'] ?>
              </a>
            </li>
          </ul>
        </div>
        <?php include "app/views/template/common.php" ?>
      </div>
      <div class="post-btn">
        <button type="submit" class="b-button b-button--primary" formaction="<?php echo htmlspecialchars('/post/index');?>">
            <?php echo $ini_array[$language]['Write a post'] ?>
        </button>
      </div>
      <div id="game-content" class="forum-container">
        <div id="game-thread-view">
          <section class="topic-list-header flex-container">
            <div class="header-topic">
              <a onclick="sortPost(this, 'post_title')" href="#">
                <span>
                  <?php echo $ini_array[$language]['POSTS'] ?>
                </span>
                <span class="arrow <?php if(strcmp($item, 'post_title') == 0) {echo $order;}?>">
                </span>
              </a>
            </div>
            <div class="header-icons">
            </div>
            <div class="header-comments">
              <a onclick="sortPost(this, 'reply_cnt')" href="#">
                <span>
                  <?php echo $ini_array[$language]['COMMENTS'] ?>
                </span>
                <span class="arrow <?php if(strcmp($item, 'reply_cnt') == 0) {echo $order;}?>">
                </span>
              </a>
            </div>
            <div class="header-views">
              <a onclick="sortPost(this, 'post_view')" href="#">
                <span>
                  <?php echo $ini_array[$language]['VIEWS'] ?>
                </span>
                <span class="arrow <?php if(strcmp($item, 'post_view') == 0) {echo $order;}?>">
                </span>
              </a>
            </div>
            <div class="header-lastpost">
              <a onclick="sortPost(this, 'max_date')" href="#">
                <span>
                  <?php echo $ini_array[$language]['LAST POST'] ?>
                </span>
                <span class="arrow <?php if(strcmp($item, 'max_date') == 0) {echo $order;}?>">
                </span>
              </a>
            </div>
          </section>
            <?php foreach ($posts as $post): ?>
                <section class="thread-list flex-container ">
                    <div class="cell-topic">
                        <div class="topic-wrapper">
                            <a href="/post/detail?<?php echo $post['post_id']?>" class="">
                                <?php echo $post["post_title"]?>
                            </a>
                        </div>
                        <div class="topic-info ">
                            <?php echo $ini_array[$language]['Started by'] ?>
                            <a href="/profile/index?<?php echo $post['post_user_id']?>">
                                <?php echo $post["login_id"]?>
                            </a>
                            ,
                            <span>
                                <?php echo $post["post_time"]?>
                            </span>
                        </div>
                    </div>
                    <div class="cell-icons">
                    </div>
                    <div class="cell-comments">
                        <?php echo $post["reply_cnt"]?>
                    </div>
                    <div class="cell-views">
                        <?php echo $post["post_view"]?>
                    </div>
                    <div class="cell-lastpost">
                        <div class="lastpost-by">
                            <a href="/profile/index?<?php echo $post['reply_user_id']?>">
                                <?php echo $post["reply_user_id"]?>
                            </a>
                            <br>
                            <?php echo $post["max_date"]?>
                        </div>
                    </div>
                </section>
            <?php endforeach ?>

        </div>
      </div>

  </form>
  <?php include "app/views/template/language.php" ?>
</body>