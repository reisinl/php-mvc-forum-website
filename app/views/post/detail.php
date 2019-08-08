<body id="vb-page-body" class="game-forum">
    <form method="post">
        <div id="game-header-subnav">
            <div>
                <ul id="breadcrumbs">
                    <li class="crumb"><a href="<?php echo htmlspecialchars('/home/index');?>"><?php echo $ini_array[$language]['Home'] ?>/ &nbsp;</a>
                        <?php echo $ini_array[$language]['Post'] ?>
                    </li>
                </ul>
            </div>
            <?php include "app/views/template/common.php" ?>
        </div>
        <div id="game-content" class="forum-container">
            <div class="widget-tabs">
                <div>
                    <ul class="widget-tabs-nav">
                        <li class="ui-tabs-active "><a href="#" class="ui-tabs-anchor"
                            id="ui-id-1"> <?php echo $ini_array[$language]['Home'] ?>Posts </a></li>
                    </ul>
                </div>
                <div class="del-btn">
                    <button class="edit-btn" formaction="/post/edit?<?php echo $post['post_id']?>"><?php echo $ini_array[$language]['Edit'] ?></button>
                    <button class="delete-btn" type="button" onclick="deleteConfirm(<?php echo $post['post_id']?>)"><?php echo $ini_array[$language]['Delete'] ?></button>
                </div>
                <div class="conversation-content">
                    <ul class="conversation-list">
                        <li class="b-post">
                            <div class="userinfo b-userinfo">
                                <div class="author h-text-size--14">
                                    <strong><a href="profile.html"><?php echo $post['login_id'] ?></a></strong>
                                </div>
                            </div>

                            <div class="b-post__body h-padding-horiz-xxl ">
                                <div class="b-post__content">
                                    <hr class="b-divider--section">
                                    <div class="b-media__body">
                                        <h2 class="b-post__title js-post-title OLD__post-title">
                                            <?php echo strip_tags($post['post_title']) ?></h2>
                                        <div class="b-post__timestamp">
                                            <time><?php echo $post['post_time'] ?></time>
                                        </div>
                                    </div>
                                    <div>
                                        <?php echo htmlentities($post['post_content']) ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php foreach ($comments as $key=>$comment): ?>
                    <div class="conversation-content">
                        <ul class="conversation-list">
                            <li class="b-post">
                                <div class="userinfo b-userinfo">
                                    <div class="author h-text-size--14">
                                        <a class="b-post__count" href="#">#<?php echo $key+1?></a>
                                        <strong><a href="profile.html"><?php echo $comment['login_id'] ?></a></strong>
                                    </div>
                                </div>
                                <div class="b-post__body h-padding-horiz-xxl ">
                                    <div class="b-post__content">
                                        <hr class="b-divider--section">
                                        <div class="b-media__body">
                                            <div class="b-post__timestamp">
                                                <time><?php echo $comment['reply_date'] ?></time>
                                            </div>
                                        </div>
                                        <div>
                                            <?php echo htmlentities($comment['reply_content']) ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php endforeach ?>
                <input hidden name="post_id" id="postID" value="<?php echo $post['post_id']?>"
                <div class="b-content-entry" style="position: relative;">
                    <div class="b-editor">
                        <textarea id="inputor" placeholder="<?php echo $ini_array[$language]['Write something...'] ?>" class="" rows="2"
                            name="comment"></textarea>
                    </div>
                    <div class="b-button-group">
                        <button type="submit" class="b-button b-button--primary" formaction="/post/Reply"><?php echo $ini_array[$language]['Submit'] ?></button>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <?php include "app/views/template/language.php" ?>
</body>
