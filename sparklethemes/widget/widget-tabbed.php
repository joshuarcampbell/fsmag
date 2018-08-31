<?php
/**
 * Adds fsmag_tabbed_widget widget.
*/
add_action('widgets_init', 'fsmag_tabbed_widget');

function fsmag_tabbed_widget() {
    register_widget('fsmag_tabbed_widget_area');
}

class fsmag_tabbed_widget_area extends WP_Widget {

    /**
     * Register widget with WordPress.
    */
    public function __construct() {
        parent::__construct(
            'emag_magazine_tabbed', esc_html_x('EMag Popular / Tags / Comments', 'widget name', 'fsmag'),
            array(
                'classname' => 'emag_magazine_tabbed',
                'description' => esc_html__('Widget display popular, recent, comment', 'fsmag'),
                'customize_selective_refresh' => true
            )
        );
    }

    private function widget_fields() {


        $fields = array(
            
            'fsmag_block_popular_disable' => array(
                'fsmag_widgets_name' => 'fsmag_block_popular_disable',
                'fsmag_widgets_title' => esc_html__('Checked To Disable Polular Posts', 'fsmag'),
                'fsmag_widgets_field_type' => 'checkbox',
            ),

            'fsmag_block_popular_title' => array(
                'fsmag_widgets_name' => 'fsmag_block_popular_title',
                'fsmag_widgets_title' => esc_html__('Popular Posts Title', 'fsmag'),
                'fsmag_widgets_field_type' => 'title',
            ),       

            'fsmag_block_comments_disable' => array(
                'fsmag_widgets_name' => 'fsmag_block_comments_disable',
                'fsmag_widgets_title' => esc_html__('Checked To Disable Comments', 'fsmag'),
                'fsmag_widgets_field_type' => 'checkbox',
            ),

            'fsmag_block_comments_title' => array(
                'fsmag_widgets_name' => 'fsmag_block_comments_title',
                'fsmag_widgets_title' => esc_html__('Comments Title', 'fsmag'),
                'fsmag_widgets_field_type' => 'title',
            ),

            'fsmag_block_tag_disable' => array(
                'fsmag_widgets_name' => 'fsmag_block_tag_disable',
                'fsmag_widgets_title' => esc_html__('Checked To Disable Tags', 'fsmag'),
                'fsmag_widgets_field_type' => 'checkbox',
            ),

            'fsmag_block_tag_title' => array(
                'fsmag_widgets_name' => 'fsmag_block_tag_title',
                'fsmag_widgets_title' => esc_html__('Tags Title', 'fsmag'),
                'fsmag_widgets_field_type' => 'title',
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
        $popular      = empty( $instance['fsmag_block_popular_disable'] ) ? '' : $instance['fsmag_block_popular_disable'];
	    $populartitle = apply_filters( 'widget_title', empty($instance['fsmag_block_popular_title']) ? '' : $instance['fsmag_block_popular_title'], $instance, $this->id_base);

	    $comment      = empty( $instance['fsmag_block_comments_disable'] ) ? '' : $instance['fsmag_block_comments_disable'];
	    $commenttitle = apply_filters( 'widget_title', empty($instance['fsmag_block_comments_title']) ? '' : $instance['fsmag_block_comments_title'], $instance, $this->id_base);

	    $tag          = empty( $instance['fsmag_block_tag_disable'] ) ? '' : $instance['fsmag_block_tag_disable'];
	    $tagtitle = apply_filters( 'widget_title', empty($instance['fsmag_block_tag_title']) ? '' : $instance['fsmag_block_tag_title'], $instance, $this->id_base);

	    $nposts  = empty( $instance['fsmag_block_display_number_posts'] ) ? 5 : $instance['fsmag_block_display_number_posts'];


        echo $before_widget; 
    ?>  
        <div class="emag-tabs-wdt">

            <ul class="emag-tab-nav">
                <?php if($popular != 1){ ?>
                    <li class="emag-tab">
                        <a class="emag-tab-anchor" href="#emag-popular">
                            <?php echo esc_attr( $populartitle ); ?>
                        </a>
                    </li>
                <?php } if($comment != 1){ ?>
                    <li class="emag-tab">
                        <a class="emag-tab-anchor" href="#emag-comments">
                            <?php echo esc_attr( $commenttitle ); ?>
                        </a>
                    </li>
                <?php } if($tag != 1){ ?>
                    <li class="emag-tab">
                        <a class="emag-tab-anchor" href="#emag-tags">
                            <?php echo esc_attr( $tagtitle ); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>

            <div class="tab-content">
                <?php if($popular != 1){ ?>
                    <div id="emag-popular" class="recent-news-wrap">
                        <?php 
                            $args = array( 'ignore_sticky_posts' => 1, 'posts_per_page' => $nposts, 'post_status' => 'publish', 'orderby' => 'comment_count', 'order' => 'desc' );
                            $popular = new WP_Query( $args );

                            if ( $popular->have_posts() ) : while( $popular-> have_posts() ) : $popular->the_post(); ?>
                                
                                <div class="recent-news-block">
                                    <?php if( has_post_thumbnail() ){ ?>
                                        <figure>
                                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
                                        </figure>
                                    <?php } ?>
                                    <div class="recent-news-content">
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

                            <?php endwhile; endif; wp_reset_postdata(); ?>
                    </div><!-- .tab-pane #emag-popular -->
                <?php } if($comment != 1){ ?>
                    <div id="emag-comments">
                        <?php

                            $avatar_size = 50;
                            $args = array(
                                'number'       => $nposts,
                            );
                            $comments_query = new WP_Comment_Query;
                            $comments = $comments_query->query( $args );    
                        
                            if ( $comments ) {
                                foreach ( $comments as $comment ) { ?>
                                    <div class="emag-comment">
                                        <figure class="emag_avatar">
                                            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                                                <?php echo get_avatar( $comment->comment_author_email, $avatar_size ); ?>     
                                            </a>                               
                                        </figure> 
                                        <div class="emag-comm-content">
                                            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                                                <span class="emag-comment-author"><?php echo esc_html( get_comment_author( $comment->comment_ID ) ); ?> </span> - <span class="emag_comment_post">
                                                    <?php echo esc_html( get_the_title($comment->comment_post_ID) ); ?>                                                
                                                </span>
                                            </a>
                                            <?php echo '<p class="emag-comment">' . wp_trim_words( wp_kses_post( $comment->comment_content ), 15, '...' ). '</p>'; ?>
                                        </div>
                                    </div>
                                <?php }
                            } else {
                                esc_html_e( 'No comments found.', 'fsmag' );
                            }
                        ?>
                    </div><!-- .tab-pane #emag-comments -->
                <?php } if($tag != 1){ ?>
                    <div id="emag-tags">
                        <?php        
                            $tags = get_tags();             
                            if($tags) {               
                                foreach ( $tags as $tag ): ?>    
                                    <span><a href="<?php echo esc_url( get_term_link( $tag ) ); ?>"><?php echo esc_attr( $tag->name ); ?></a></span>           
                                    <?php     
                                endforeach;       
                            } else {          
                                esc_html_e( 'No tags created.', 'fsmag');           
                            }            
                        ?>
                    </div><!-- .tab-pane #emag-tags-->
                <?php } ?>
            </div><!-- .tab-content -->     

        </div><!-- #tabs -->

    <?php
        echo $after_widget;  wp_enqueue_script( 'jquery-ui-tabs' );
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
