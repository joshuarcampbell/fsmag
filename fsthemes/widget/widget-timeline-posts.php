<?php
/**
 * Adds fsmag_timeline_posts_widget widget.
*/
add_action('widgets_init', 'fsmag_timeline_posts_widget');

function fsmag_timeline_posts_widget() {
    register_widget('fsmag_timeline_posts_widget_area');
}

class fsmag_timeline_posts_widget_area extends WP_Widget {

    /**
     * Register widget with WordPress.
    */
    public function __construct() {
        parent::__construct(
            'emag_magazine_timeline_posts', esc_html_x('EMag Timeline Posts', 'widget name', 'fsmag'),
            array(
                'classname' => 'emag_magazine_timeline_posts',
                'description' => esc_html__('Widget display posts in timeline layout', 'fsmag'),
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
            
            'fsmag_block_title' => array(
                'fsmag_widgets_name' => 'fsmag_block_title',
                'fsmag_widgets_title' => esc_html__('Block Title', 'fsmag'),
                'fsmag_widgets_field_type' => 'title',
                'fsmag_widgets_description' => esc_html__('Enter your block title (Options - leave blank to hide title)', 'fsmag'),
            ),
            
            'fsmag_category_list' => array(
                'fsmag_widgets_name' => 'fsmag_category_list',
                'fsmag_mulicheckbox_title' => esc_html__('Select Posts Category', 'fsmag'),
                'fsmag_widgets_field_type' => 'multicheckboxes',
                'fsmag_widgets_field_options' => $cat_lists
            ),

            'fsmag_block_display_order' => array(
                'fsmag_widgets_name' => 'fsmag_block_display_order',
                'fsmag_widgets_title' => esc_html__('Choose Posts Display Order', 'fsmag'),
                'fsmag_widgets_field_type' => 'select',
                'fsmag_widgets_field_options' => array('DESC' => 'DESC', 'ASC' => 'ASC')
            ),

            'fsmag_block_display_number_posts' => array(
                'fsmag_widgets_name' => 'fsmag_block_display_number_posts',
                'fsmag_widgets_title' => esc_html__('Enter Display Number of Posts', 'fsmag'),
                'fsmag_widgets_field_type' => 'number',
            ),
            
        );

        return $fields;
    }

    public function widget($args, $instance) {
        extract($args);
        
        /**
         * wp query for first block
        */
	    $title = apply_filters( 'widget_title', empty($instance['fsmag_block_title']) ? '' : $instance['fsmag_block_title'], $instance, $this->id_base);
        $nposts        = empty( $instance['fsmag_block_display_number_posts'] ) ? 5 : $instance['fsmag_block_display_number_posts'];
        $dorder        = empty( $instance['fsmag_block_display_order'] ) ? 'DESC' : $instance['fsmag_block_display_order'];
        $category_list = empty( $instance['fsmag_category_list'] ) ? '' : $instance['fsmag_category_list'];

        $block_cat_id = array();
        if (!empty($category_list)) {
            $block_cat_id = array_keys($category_list);
        }

        
        echo $before_widget; 
    ?>  
        <?php if(!empty( $title )){ ?>
            <h2 class="widget-title">
                <span><?php echo esc_attr( $title ); ?></span>
            </h2>
        <?php } ?>
        <div class="emag-timeline">
            <?php   
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $nposts,
                    'order'  => $dorder,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'term_id',
                            'terms'    => $block_cat_id
                        ),
                    ),
                );
                $timeline = new WP_Query( $args );
                if ( $timeline->have_posts() ) : while( $timeline-> have_posts() ) : $timeline->the_post(); ?>
                    
                    <div class="emag-post-item">                        
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="news-block-footer">
                            <div class="news-date">
                                <i class="icofont fa fa-clock-o"></i> <a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
                            </div>
                            <div class="news-comment">
                                <i class="icofont fa fa-commenting"></i> <?php comments_popup_link( esc_html__( 'No comment', 'fsmag' ), esc_html__( '1 Comment', 'fsmag' ), esc_html__( '% Comments', 'fsmag' ) ); ?>
                            </div>
                        </div>
                    </div>
            <?php endwhile; endif; wp_reset_postdata(); ?>
        </div>

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
