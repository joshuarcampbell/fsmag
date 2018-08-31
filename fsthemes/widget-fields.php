<?php
/**
 * Main Custom admin functions area
 *
 * @since fsthemeswpThemes
 *
 * @param Editorial_Mag
 */

function fsmag_widgets_show_widget_field($instance = '', $widget_field = '', $fsmag_field_value = '') {
   
    //list category list in array
    $fsmag_category_list[0] = array(
        'value' => 0,
        'label' => esc_html__('Select Categories','fsmag')
    );
    $fsmag_posts = get_categories();
    foreach ($fsmag_posts as $fsmag_post) :
        $fsmag_category_list[$fsmag_post->term_id] = array(
            'value' => $fsmag_post->term_id,
            'label' => $fsmag_post->name
        );
    endforeach;

    extract($widget_field);

    switch ($fsmag_widgets_field_type) {

        /**
         * Standard Text Field
         */
        case 'text' : ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>"><?php echo esc_attr( $fsmag_widgets_title ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $instance->get_field_id($fsmag_widgets_name) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $fsmag_widgets_name ) ); ?>" type="text" value="<?php echo esc_attr( $fsmag_field_value ) ; ?>" />
                <?php if ( isset( $fsmag_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $fsmag_widgets_description ); ?></small>
                <?php } ?>
            </p>
            <?php
            break;

        /**
         * Section Title Field
         */
        case 'title' : ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>"><?php echo esc_attr( $fsmag_widgets_title ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $fsmag_widgets_name ) ); ?>" type="text" value="<?php echo esc_attr( $fsmag_field_value ); ?>" />
                <?php if (isset( $fsmag_widgets_description )) { ?>
                    <br />
                    <small><?php echo esc_html( $fsmag_widgets_description ); ?></small>
                <?php } ?>
            </p>
            <?php
            break;

        /**
         * Section Title Field
         */
        case 'info' : ?>
            <p>
                <strong for="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>"><?php echo esc_attr( $fsmag_widgets_title ); ?>: </strong>
                <?php if (isset( $fsmag_widgets_description )) { ?>
                    <?php echo esc_html( $fsmag_widgets_description ); ?>
                <?php } ?>
            </p>
            
            <?php
            break;

        /**
         * Standard URL Field
         */
        case 'url' : ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>"><?php echo esc_attr( $fsmag_widgets_title ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $fsmag_widgets_name ) ); ?>" type="text" value="<?php echo esc_attr( $fsmag_field_value ); ?>" />
                <?php if (isset( $fsmag_widgets_description )) { ?>
                    <br />
                    <small><?php echo esc_html( $fsmag_widgets_description ); ?></small>
                <?php } ?>
            </p>
            <?php
            break;

        /**
         * Textarea field
         */
        case 'textarea' : ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>"><?php echo esc_attr( $fsmag_widgets_title ); ?></label>
                <textarea class="widefat" rows="<?php echo absint( $fsmag_widgets_row ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $fsmag_widgets_name ) ); ?>">
                    <?php echo esc_attr( $fsmag_field_value ); ?>
                </textarea>
            </p>
            <?php
            break;

        /**
         * Checkbox field
         */
        case 'checkbox' : ?>
            <p>
                <input id="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $fsmag_widgets_name ) ); ?>" type="checkbox" value="1" <?php checked('1', $fsmag_field_value ); ?> />
                <label for="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>"><?php echo esc_attr( $fsmag_widgets_title ); ?></label>
                <?php if (isset($fsmag_widgets_description)) { ?>
                    <br />
                    <small><?php echo esc_html($fsmag_widgets_description); ?></small>
                <?php } ?>
            </p>
            <?php
            break;

        /**
         * Radio field
         */
        case 'radio' : ?>
            <p>
                <?php
                echo esc_attr( $fsmag_widgets_title );
                echo '<br />';
                foreach ($fsmag_widgets_field_options as $fsmag_option_name => $fsmag_option_title) { ?>
                    <input id="<?php echo esc_attr( $instance->get_field_id( $fsmag_option_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $fsmag_widgets_name ) ); ?>" type="radio" value="<?php echo esc_attr( $fsmag_option_name ); ?>" <?php checked( $fsmag_option_name, $fsmag_field_value ); ?> />
                    <label for="<?php echo esc_attr( $instance->get_field_id( $fsmag_option_name ) ); ?>"><?php echo esc_attr( $fsmag_option_title ); ?></label>
                    <br />
                <?php } ?>

                <?php if (isset($fsmag_widgets_description)) { ?>
                    <small><?php echo esc_html($fsmag_widgets_description); ?></small>
                <?php } ?>
            </p>
            <?php
            break;

        /**
         * Select field
         */
        case 'select' : ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>"><?php echo esc_attr( $fsmag_widgets_title ); ?></label>
                <select name="<?php echo esc_attr( $instance->get_field_name( $fsmag_widgets_name ) ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>" class="widefat">
                    <?php foreach ( $fsmag_widgets_field_options as $fsmag_option_name => $fsmag_option_title ) { ?>
                        <option value="<?php echo esc_attr( $fsmag_option_name ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $fsmag_option_name ) ); ?>" <?php selected( $fsmag_option_name, $fsmag_field_value ); ?>><?php echo esc_attr( $fsmag_option_title ); ?></option>
                    <?php } ?>
                </select>

                <?php if (isset($fsmag_widgets_description)) { ?>
                    <br />
                    <small><?php echo esc_html( $fsmag_widgets_description ); ?></small>
                <?php } ?>
            </p>
            <?php
            break;

        case 'number' : ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>"><?php echo esc_attr( $fsmag_widgets_title ); ?></label><br />
                <input name="<?php echo esc_attr( $instance->get_field_name( $fsmag_widgets_name ) ); ?>" type="number" step="1" id="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>" value="<?php echo esc_attr( $fsmag_field_value ); ?>" class="widefat" />

                <?php if ( isset( $fsmag_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $fsmag_widgets_description ); ?></small>
                <?php } ?>
            </p>
            <?php
            break;        

        // Select category field
        case 'select_category' : ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>"><?php echo esc_attr( $fsmag_widgets_title ); ?> :</label>
                <select name="<?php echo esc_attr( $instance->get_field_name( $fsmag_widgets_name ) ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>" class="widefat">
                    <?php foreach ($fsmag_category_list as $fsmag_single_post) { ?>
                        <option value="<?php echo esc_attr( $fsmag_single_post['value'] ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $fsmag_single_post['label'] ) ); ?>" <?php selected( $fsmag_single_post['value'], $fsmag_field_value ); ?> ><?php echo esc_attr( $fsmag_single_post['label'] ); ?></option>
                    <?php } ?>
                </select>

                <?php if (isset($fsmag_widgets_description)) { ?>
                    <br />
                    <small><?php echo esc_html( $fsmag_widgets_description ); ?></small>
                <?php } ?>
            </p>
            <?php
            break;

        //Multi checkboxes
        case 'multicheckboxes' :
            
            if( isset( $fsmag_mulicheckbox_title ) ) { ?>
                <label><?php echo esc_attr( $fsmag_mulicheckbox_title ); ?></label>
            <?php }
            echo '<div class="fsmag-multiplecat">';
                foreach ( $fsmag_widgets_field_options as $fsmag_option_name => $fsmag_option_title) {
                    if( isset( $fsmag_field_value[$fsmag_option_name] ) ) {
                        $fsmag_field_value[$fsmag_option_name] = 1;
                    }else{
                        $fsmag_field_value[$fsmag_option_name] = 0;
                    }                
                ?>
                    <p>
                        <input id="<?php echo esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $fsmag_widgets_name ) ).'['.esc_attr( $fsmag_option_name ).']'; ?>" type="checkbox" value="1" <?php checked('1', $fsmag_field_value[$fsmag_option_name]); ?>/>
                        <label for="<?php echo esc_attr( $instance->get_field_id( $fsmag_option_name ) ); ?>"><?php echo esc_attr( $fsmag_option_title ); ?></label>
                    </p>
                <?php
                    }
            echo '</div>';
                if (isset($fsmag_widgets_description)) {
            ?>
                    <small><em><?php echo esc_html( $fsmag_widgets_description ); ?></em></small>
            <?php
                }
            
        break;

        case 'upload' :

            $output = '';
            $id = $instance->get_field_id($fsmag_widgets_name);
            $class = '';
            $int = '';
            $value = $fsmag_field_value;
            $name = $instance->get_field_name($fsmag_widgets_name);

            if ($value) {
                $class = ' has-file';
            }
            $output .= '<div class="sub-option section widget-upload">';
            $output .= '<label for="'.esc_attr( $instance->get_field_id( $fsmag_widgets_name ) ).'">'.esc_attr( $fsmag_widgets_title ).'</label><br/>';
            $output .= '<input id="' . $id . '" class="upload' . $class . '" type="text" name="' . $name . '" value="' . $value . '" placeholder="' . esc_html__('No file chosen', 'fsmag') . '" />' . "\n";
            
            if ( function_exists('wp_enqueue_media') ) {
                if (( $value == '')) {
                    $output .= '<input id="upload-' . $id . '" class="upload-button-wdgt button" type="button" value="' . esc_html__('Upload', 'fsmag') . '" />' . "\n";
                } else {
                    $output .= '<input id="remove-' . $id . '" class="remove-file button" type="button" value="' . esc_html__('Remove', 'fsmag') . '" />' . "\n";
                }
            } else {
                $output .= '<p><i>' . esc_html__('Upgrade your version of WordPress for full media support.', 'fsmag') . '</i></p>';
            }

            $output .= '<div class="screenshot team-thumb" id="' . $id . '-image">' . "\n";
            if ($value != '') {
                $remove = '<a class="remove-image">'.esc_html__('Remove','fsmag').'</a>';
                $image = preg_match('/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value);
                if ($image) {
                    $output .= '<img src="' . $value . '" />' . $remove;
                } else {
                    $parts = explode("/", $value);
                    for ( $i = 0; $i < sizeof($parts ); ++$i ) {
                        $title = $parts[$i];
                    }
                    $output .= '';
                    $title = esc_html__('View File', 'fsmag');
                    $output .= '<div class="no-image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">' . $title . '</a></span></div>';
                }
            }
            $output .= '</div></div>' . "\n";
            echo $output;
            break;
    }
}

function fsmag_widgets_updated_field_value($widget_field, $new_field_value) {

    extract( $widget_field );

    if ($fsmag_widgets_field_type == 'number') {

        return absint($new_field_value);

    } elseif ($fsmag_widgets_field_type == 'textarea') {
        
        if (!isset($fsmag_widgets_allowed_tags)) {
            $fsmag_widgets_allowed_tags = '<span><br><p><strong><em><a>';
        }

        return wp_kses_data($new_field_value, $fsmag_widgets_allowed_tags);
    } 
    elseif ($fsmag_widgets_field_type == 'url') {
        return esc_url_raw($new_field_value);
    }
    elseif ($fsmag_widgets_field_type == 'title') {
        return wp_kses_post($new_field_value);
    }
    elseif ($fsmag_widgets_field_type == 'multicheckboxes') {
        return wp_kses_post($new_field_value);
    }
    else {
        return wp_kses_data($new_field_value);
    }
}


/**
 * Load widget fields file.
*/
require fsmag_file_directory('fsthemes/widget/widget-large-with-grid.php');

require fsmag_file_directory('fsthemes/widget/widget-large-with-small.php');

require fsmag_file_directory('fsthemes/widget/widget-grid-posts.php');

require fsmag_file_directory('fsthemes/widget/widget-large-single-with-small.php');

require fsmag_file_directory('fsthemes/widget/widget-alternative-posts.php');

require fsmag_file_directory('fsthemes/widget/widget-recent-random.php');

require fsmag_file_directory('fsthemes/widget/widget-slider-posts.php');

require fsmag_file_directory('fsthemes/widget/widget-timeline-posts.php');

require fsmag_file_directory('fsthemes/widget/widget-tabbed.php');