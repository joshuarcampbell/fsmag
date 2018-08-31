<?php
/**
 * Adds fsmag_slider_posts_widget widget.
*/
add_action('widgets_init', 'fsmag_slider_posts_widget');

function fsmag_slider_posts_widget() {
    register_widget('fsmag_slider_posts_widget_area');
}

class fsmag_slider_posts_widget_area extends WP_Widget {

    /**
     * Register widget with WordPress.
    */
    public function __construct() {
        parent::__construct(
            'emag_magazine_slider_posts', esc_html_x('EMag Slider Posts', 'widget name', 'fsmag'),
            array(
                'classname' => 'emag_magazine_slider_posts',
                'description' => esc_html__('Widget display category posts in slider layout', 'fsmag'),
                'customize_selective_refresh' => true
            )
        );
    }

    private function widget_fields() {

        $args = array(
            'type'       => 'post',
            'child_of'   => 0,
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => 1,
            'taxonomy'   => 'category',
        );
        $categories = get_categories( $args );
        $cat_lists = array();
        foreach ($categories as $category) {
            $cat_lists[$category->term_id] = $category->name;
        }

        $fields = array(
            
            'fsmag_category_list' => array(
                'fsmag_widgets_name' => 'fsmag_category_list',
                'fsmag_mulicheckbox_title' => esc_html__('Select Posts Category', 'fsmag'),
                'fsmag_widgets_field_type' => 'multicheckboxes',
                'fsmag_widgets_field_options' => $cat_lists
            ),

            'fsmag_block_display_number_posts' => array(
                'fsmag_widgets_name' => 'fsmag_block_display_number_posts',
                'fsmag_widgets_title' => esc_html__('Enter Display Number of Posts', 'fsmag'),
                'fsmag_widgets_field_type' => 'number',
            ),

            'fsmag_block_info' => array(
                'fsmag_widgets_name' => 'fsmag_block_info',
                'fsmag_widgets_title' => esc_html__('Info', 'fsmag'),
                'fsmag_widgets_description' => esc_html__('This is the lite version of this widget with basic features. More features and options are available in the premium version of Editorial Magazine.', 'fsmag'),
                'fsmag_widgets_field_type' => 'info',
            )
            
        );

        return $fields;
    }

    public function widget($args, $instance) {
        extract($args);
        
        /**
         * wp query for first block
        */
        $number_posts  = empty( $instance['fsmag_block_display_number_posts'] ) ? 5 : $instance['fsmag_block_display_number_posts'];
        $category_list = empty( $instance['fsmag_category_list'] ) ? '' : $instance['fsmag_category_list'];

        $block_cat_id = array();
        if (!empty($category_list)) {
            $block_cat_id = array_keys($category_list);
        }

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $number_posts,
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $block_cat_id
                ),
            ),
        );

        $query = new WP_Query( $args );

        echo $before_widget; 
    ?>  
        <section class="bannersection one-post-slider">
            <div class="banner-wrap">
                <ul class="banner-list-group cS-hidden clearfix">
                    <?php  
                        while( $query->have_posts() ){ $query->the_post();
                        $image     = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'fsmag-slider', true);
                        $thumninal = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'fsmag-normal-image', true);
                    ?>
                        <li data-thumb="<?php echo esc_url( $thumninal[0] ); ?>">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php the_title(); ?>">
                            </a>
                            <div class="banner-caption">
                                <?php fsmag_colored_category(); ?>
                                <h2 class="caption-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <span><?php the_title(); ?></span>
                                    </a>
                                </h2>
                                <div class="caption-date">
                                    <a href="<?php the_permalink(); ?>"><?php esc_html_e('On :','fsmag'); ?> <?php the_time( get_option( 'date_format' ) ); ?></a>
                                </div>
                            </div>
                        </li>
                    <?php }  wp_reset_postdata(); ?>                       
                </ul>
            </div>
        </section> <!-- BANNER SECTION -->

    <?php
        echo $after_widget;
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $widget_fields = $this->widget_fields();
        foreach ($widget_fields as $widget_field) {
            extract($widget_field);
            $instance[$fsmag_widgets_name] = fsmag_widgets_updated_field_value( $widget_field, $new_instance[$fsmag_widgets_name] );
        }
        return $instance;
    }

    public function form($instance) {
        $widget_fields = $this->widget_fields();
        foreach ( $widget_fields as $widget_field ) {
            extract( $widget_field );
            $fsmag_widgets_field_value = !empty( $instance[ $fsmag_widgets_name ] ) ? $instance[ $fsmag_widgets_name ] : '';
            fsmag_widgets_show_widget_field( $this, $widget_field, $fsmag_widgets_field_value );
        }
    }

}
