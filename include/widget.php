<?php 
class HK_Post_By_Category_Widget extends WP_Widget {
    function __construct() {
        parent::__construct( false, __( '[HK] - Hiển thị bài viết theo chuyên mục' ) );
    }
    function widget($args, $instance) {
        extract( $args );
        $title      = $instance['title'];
        $num        = $instance['num'];
        $isavatar   = $instance[ 'isavatar' ] ? false : true;
        $datetime   = $instance[ 'datetime' ] ? false : true;
        $cat_id     = $instance['cat_id'];
        if ( !defined('ABSPATH') )
        die('-1');
        echo $before_widget; 
        echo $before_title.$title.$after_title; ?>
        <div class="hk-post-by-category-widget">
            <ul>
                <?php $getposts = new WP_query(); $getposts->query('post_status=publish&showposts='.$num.'&post_type=post&cat='.$cat_id); ?>
                <?php global $wp_query; $wp_query->in_the_loop = true; ?>
                <?php while ($getposts->have_posts()) : $getposts->the_post(); ?>
                    <li>
                        <?php if($isavatar){ ?>
                            <?php $urlImage = get_post_thumbnail_id(get_the_ID()) ? wp_get_attachment_thumb_url( get_post_thumbnail_id(get_the_ID()) ) : HK_POSTCAT_PLUGIN_URL.'/images/no-thumbnail.png'; ?>
                            <a href="<?php the_permalink(); ?>"><img src="<?php echo $urlImage; ?>"  alt="<?php the_title(); ?>"></a>
                        <?php } ?>
                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <?php if($datetime){ ?>
                        <span class="widget-post-meta-hk">Ngày đăng: <?php echo get_the_date('d - m - Y'); ?></span>
                        <?php } ?>
                        <div class="clear"></div>
                    </li>
                <?php endwhile; wp_reset_postdata(); ?>
            </ul>
        </div>
    <?php echo $after_widget;
    } 
    function update($new_instance, $old_instance) {
        $instance['title']      = strip_tags($new_instance['title']);
        $instance['num']        = $new_instance['num'];
        $instance['cat_id']     = $new_instance['cat_id'];
        $instance['isavatar']   = $new_instance['isavatar'];
        $instance['datetime']   = $new_instance['datetime'];
        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'title' => 'Tiêu đề',
            'num' => 5,
            'cat_id' => 0,
        );
        $instance = wp_parse_args((array) $instance, $defaults ); ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Nhập tiêu đề: '); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>"  />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Nhập số lượng bài viết : '); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="number" value="<?php echo $instance['num']; ?>" />
        </p>
        <p class="cate-kira">
            <label for="<?php echo $this->get_field_id('cat_id'); ?>"><?php _e('Chọn chuyên mục: '); ?></label>
            <?php
                wp_dropdown_categories( array(
                    'show_option_none'  => 'Tất cả chuyên mục',
                    'option_none_value' => 0,
                    'orderby'           => 'count',
                    'hide_empty'        => false,
                    'hierarchical'      => 1,
                    'name'              => $this->get_field_name( 'cat_id' ),
                    'id'                => 'recent_posts_category',
                    'class'             => 'widefat',
                    'selected'          => $instance['cat_id']
                ));
            ?>
        </p>
        <div class="checkbox-data">
            <label><strong>Ẩn hiện các chức năng:</strong></label><br>
            <div class="group-data">
                <input type="checkbox" name="<?php echo $this->get_field_name('isavatar'); ?>" <?php checked( $instance[ 'isavatar' ], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'isavatar' ) ); ?>">
                <label for="<?php echo esc_attr( $this->get_field_id( 'isavatar' ) ); ?>">Ẩn ảnh đại diện</label>
            </div>
            <div class="group-data">
                <input type="checkbox" name="<?php echo $this->get_field_name('datetime'); ?>" <?php checked( $instance[ 'datetime' ], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'datetime' ) ); ?>">
                <label for="<?php echo esc_attr( $this->get_field_id( 'datetime' ) ); ?>">Ẩn ngày đăng</label>
            </div>
        </div>
    <?php }
}
 
function hk_postcat_register_widgets() {
    register_widget( 'HK_Post_By_Category_Widget' );
}
add_action( 'widgets_init', 'hk_postcat_register_widgets' );