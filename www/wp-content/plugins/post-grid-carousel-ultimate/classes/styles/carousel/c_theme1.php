<style type="text/css">
/* post grid style1 */
#pgcu_style1 .pgcu_post.pgcu_post--style1 {
    border: 1px solid #ebedf2;
    margin-bottom: 0;
    padding: 0;
}

#pgcu_style1 .pgcu_post.pgcu_post--style1 .pgcu_post__contents {
    padding: 25px 30px 25px;
    line-height: normal;
}

#pgcu_style1 .pgcu_post.pgcu_post--style1 .pgcu_post__contents .post_info {
    margin-top: 13px;
    margin-bottom: 13px;
}

#pgcu_style1 .pgcu_post.pgcu_post--style1 .pgcu_post__contents .post_info .category::before {
    content: '-';
    margin-right: 3px;
}

#pgcu_style1 .pgcu_post.pgcu_post--style1-grid {
    margin-bottom: 30px;
}

#pgcu_style1 .pgcu_post .post_title h4 {
    margin: 0;
    color: <?php echo !empty($post_title_color) ? $post_title_color : "#363940";?>;
    font-size: <?php echo !empty($post_title_font_size) ? $post_title_font_size : "20px";?>;
    font-weight: 500;
    text-align: left;
}

#pgcu_style1 .pgcu_post .post_title h4:hover {
    color: <?php echo !empty($post_title_hover_color) ? $post_title_hover_color : "#F42156";?>;
}
#pgcu_style1 .pgcu_post .post_info ul li {
    margin-left: 0;
}
#pgcu_style1 .pgcu_post .post_info ul li,#pgcu_style1 .pgcu_post .post_info ul li a { 
    color: #9192a3;
    font-size: 16px;
}
#pgcu_style1 .pgcu_post .post_info ul {
    margin: 0;
}
#pgcu_style1 .pgcu_post__contents p {
    margin-bottom: 15px;
    color: <?php echo !empty($post_content_color) ? $post_content_color : "#6e7387";?>;
    font-size: 16px;
    line-height: 30px;
    font-weight: 100;
    text-align: left;
}
#pgcu_style1 .read_more {
    color: <?php echo !empty($read_more_color) ? $read_more_color : "#363940";?>;
}
#pgcu_style1 .read_more:hover {
    color : <?php echo !empty($read_more_hover_color) ? $read_more_hover_color : "#9B9FAC";?>;
}

#pgcu_style1 .aaz_pgcu_wrapper .nav_icon {
    color: #9B9FAC;
}

#pgcu_style1 .aaz_pgcu_wrapper .nav_icon:hover {
    color: #fff;
    background: #f42156;
    border: none;
}
</style>