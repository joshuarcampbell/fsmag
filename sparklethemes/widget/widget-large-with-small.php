<?php
/**
 * Adds fsmag_large_with_small_widget widget.
*/
add_action('widgets_init', 'fsmag_large_with_small_widget');

function fsmag_large_with_small_widget() {
    register_widget('fsmag_large_with_small_widget_area');
}

class fsmag_large_with_small_widget_area extends WP_Widget {

    /**
     * Register widget with WordPress.
    */
    public function __construct() {
        parent::__construct(
            'emag_magazine_small_posts', esc_html_x('EMag Large With Small Posts', 'widget name', 'fsmag'),
            array(
                'classname' => 'emag_magazine_small_posts',
                'description' => esc_html__('Widget display 1 large thumbinal image post with multiple small thumbinal posts', 'fsmag'),
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
            ),

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
	    $title = apply_filters( 'widget_title', empty($instance['fsmag_block_title']) ? '' : $instance['fsmag_block_title'], $instance, $this->id_base);
        $number_posts        = empty( $instance['fsmag_block_display_number_posts'] ) ? 5 : $instance['fsmag_block_display_number_posts'];
        $category_list       = empty( $instance['fsmag_category_list'] ) ? '' : $instance['fsmag_category_list'];

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
        <div class="two-col-with-first-large">
            <?php if(!empty( $title )){ ?>
                <h2 class="section-title">
                    <span><?php echo esc_attr( $title ); ?></span>
                </h2>
            <?php } ?>
            <div class="news-wrap">
                <?php 
                    $i = 1; 
                    while( $query->have_posts() ){ $query->the_post();
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'fsmag-normal-image', true);
                    if( $i == 1 ){
                ?>
                    <div class="news-block first-large">
                        <?php if( has_post_thumbnail() ){ ?>
                            <figure>
                                <img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php the_title(); ?>">
                                <?php fsmag_colored_category(); ?>
                            </figure>
                        <?php } ?>
                        <div class="news-content">

                            <?php fsmag_posted_on(); ?>

                            <h3 class="news-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="news-block-content"><?php the_excerpt(); ?></div>

                            <div class="news-block-footer">
                                <div class="news-comment">
                                    <i class="icofont fa fa-commenting"></i> <?php comments_popup_link( esc_html__( 'No comment', 'fsmag' ), esc_html__( '1 Comment', 'fsmag' ), esc_html__( '% Comments', 'fsmag' ) ); ?>
                                </div>
                                <div class="news-comment readmore">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php esc_html_e('Continue Reading','fsmag'); ?> <i class="icofont fa fa-arrow-circle-o-right"></i>
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                <?php }else{ ?>
                    <div class="large-with-small-list">
                        <div class="news-block">
                            <?php if( has_post_thumbnail() ){ ?>
                                <figure class="hot-news-img">
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
                                </figure>
                            <?php } ?>
                            <div class="news-content">
                                <h3 class="news-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>                                
                                <div class="news-block-footer">
                                    <div class="news-date">
                                        <i class="icofont fa fa-clock-o"></i> <a href="<?php the_permalink(); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a>
                                    </div>
                                    <div class="news-comment">
                                        <i class="icofont fa fa-commenting"></i> <?php comments_popup_link( esc_html__( 'No comment', 'fsmag' ), esc_html__( '1 Comment', 'fsmag' ), esc_html__( '% Comments', 'fsmag' ) ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }  $i++; } wp_reset_postdata(); ?> 
            </div>
        </div> <!-- NEWS WITH FIRST POST LAGRE -->
           
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
