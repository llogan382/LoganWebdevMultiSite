<?php
class TFuse_Walker_Category_Checklist extends Walker {
    var $tree_type = 'category';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent<ul class='children'>\n";
    }

    function end_lvl(&$output, $depth=0, $args=array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $category, $depth = 0, $args = array(), $current_object_id = 0) {
        extract($args);
        if(!is_array($categories)) $categories = array();

        $output .= "\n<li id='{$field_id}-{$category->term_id}' >" . '<input value="'.$category->term_id.'" type="checkbox" name="'.$field_name.'['.$category->term_id.']" id="'.$field_id.'-' . $category->term_id . '"' . checked( in_array( $category->term_id, $categories ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters('the_category', $category->name )) . '';
    }

    function end_el(&$output, $object, $depth = 0, $args = array()) {
        $output .= "</li>\n";
    }
}


class TFuse_Widget_Selected_Categories extends WP_Widget {

    function __construct() {
        $widget_ops = array('description' => __( 'Show Selected Categories', 'tfuse') );
        parent::__construct(false, __('TFuse Selected Categories', 'tfuse'),$widget_ops);
    }

    function widget($args, $instance) {
        extract( $args );
        $title = esc_attr($instance['title']);
        $categories = isset($instance['categories']) ? $instance['categories'] : '' ;
        $c = isset($instance['count']) ? '1' : '0';

        if (isset($instance['disable_box']) && $instance['disable_box'])
        {
            $before_box = '';
            $after_box ='';
        }
        else {
            $before_box = '<div class="box">';
            $after_box ='</div>';
        }
        $before_widget = '<div class="widget-container widget_categories">';
        $after_widget = '</div>';
        $before_title = '<h3 class="widget-title">';
        $after_title = '</h3>';

        echo $before_box.$before_widget;
        $title = tfuse_qtranslate($title);
        if ( $title ) echo $before_title . $title . $after_title; ?>

        <?php if ( is_array($categories) ) { ?>

            <ul>
                <?php
                $k=0;
                foreach ($categories as $key) {
                    $post_data_curent= get_category(get_query_var('cat'),false);

                    $curent_id = isset($post_data_curent->cat_ID) ? $post_data_curent->cat_ID : '';
                    $cat = get_category($key);
                    if(!$cat) continue;
                    $cat_id=$cat->term_id;
                    $k++;
                    if ($k==1)                  $first = 'first '; else $first = '';
                    if ($k==count($categories)) $last  = 'last ';  else $last  = '';
                    if ($curent_id == $cat_id) {$active = 'current-menu-item ';} else $active='';
                    if($c) $count = ' <em>('.$cat->count.')</em>'; else $count = '';
                    echo '<li class="'.$first.$last.$active.'"><a href="' . get_category_link($key) . '"><span>' . get_cat_name( $key ) . $count .'</span></a></li>';
                } ?>
            </ul>

        <?php  }

        echo $after_widget.$after_box;
    }

    function update( $new_instance, $old_instance) {
        $instance['disable_box'] = isset($new_instance['disable_box']);
        return $new_instance;
    }

    function form($instance) {
        $instance = wp_parse_args( (array) $instance, array(  'categories' => '','title' => '') );
        $title = esc_attr( $instance['title'] );
        $count = isset($instance['count']) ? (bool) $instance['count'] :false;
        $args['field_name'] = $this->get_field_name('categories');
        $args['field_id'] = $this->get_field_id('categories');
        $args['categories'] = $instance['categories'];
        if(isset($instance['disable_box']) && $instance['disable_box']=='on' ) $instance['disable_box'] = 1; ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','tfuse'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
            <br /><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts','tfuse' ); ?></label><br />

            <input id="<?php echo $this->get_field_id('disable_box'); ?>" name="<?php echo $this->get_field_name('disable_box'); ?>" type="checkbox" <?php checked(isset($instance['disable_box']) ? $instance['disable_box'] : 0); ?> />
            <label for="<?php echo $this->get_field_id('disable_box'); ?>"><?php _e('Disable box','tfuse'); ?></label><br /><br />

            <label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Select Categories List:','tfuse'); ?></label>
        </p>
        <div class="tfuse_categorydiv">
            <ul class="categorychecklist form-no-clear">
                <?php
                    $walker = new TFuse_Walker_Category_Checklist;
                    $categorieslist = (array) get_terms('category', array('get' => 'all'));
                    echo call_user_func_array(array(&$walker, 'walk'), array($categorieslist, 0, $args));
                ?>
            </ul>
        </div>
    <?php
    }
}

register_widget('TFuse_Widget_Selected_Categories');