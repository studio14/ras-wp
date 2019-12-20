<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

/**
 * 
 * Call the sub menu of the items
 */
function get_current_submenu($depth, $type = '')
{
    global $wp_query;
    $uniqueID = $wp_query->post->ID;
    $uniquePostID = $wp_query->post->post_parent;
    if ($uniqueID == 32) {
        $parent = $wp_query->post->ID;
    }
    else if ($uniquePostID == 32) {
        $parent = $wp_query->post->post_parent;
    }
    else if( $wp_query->post->post_parent === 0) {
        $parent = $wp_query->post->ID;
    }
    else {
        $parent = $wp_query->post->ancestors;
        $parentcount = count($parent);
        for ($count = 0; $count <= $parentcount; $count++) {
            if ($count == $parentcount) {
                $parent = $parent[$count - 1];
            }
        }
    }
    if(wp_list_pages("title_li=&child_of=$parent&echo=0" )) {
        echo wp_list_pages("title_li=&child_of=$parent&sort_column=menu_order&depth=".$depth );
    }
    
    return;
}

/**
 * 
 * Call the sub menu of the items
 */
function get_custom_current_submenu($depth, $type = '')
{
    global $wp_query;
    $uniqueID = $wp_query->post->ID;
    $uniquePostID = $wp_query->post->post_parent;
    if ($uniqueID == 32) {
        $parent = $wp_query->post->ID;
    }
    else if ($uniquePostID == 32) {
        $parent = $wp_query->post->post_parent;
    }
    else if( $wp_query->post->post_parent === 0) {
        $parent = $wp_query->post->ID;
    }
    else {
        $parent = $wp_query->post->ancestors;
        $parentcount = count($parent);
        for ($count = 0; $count <= $parentcount; $count++) {
            if ($count == $parentcount) {
                $parent = $parent[$count - 1];
            }
        }
    }
    if(wp_list_pages("title_li=&child_of=$parent&echo=0" )) {
        echo wp_list_pages("title_li=&child_of=$parent&sort_column=post_name&depth=".$depth );
    }
    
    return;
}

function get_current_sub_submenu($depth)
{
    global $wp_query;
    if($wp_query->post->post_parent === 0) {
        $parent = $wp_query->post->ID;
    } else {
        // $parent = $wp_query->post->ID;
        $parent = $wp_query->post->ancestors;
        $parentcount = count($parent);
        for ($count = 0; $count <= $parentcount; $count++) {
            if ($parentcount == 1) {
                $parent = $wp_query->post->ID;
            }
            else if ($count == $parentcount) {
                $parent = $parent[$count - $depth];
            }
        }
    }
    if(wp_list_pages("title_li=&child_of=$parent&echo=0" )) {
        echo wp_list_pages("title_li=&child_of=$parent&sort_column=menu_order&depth=".$depth );
        //  var_dump(count($parent));
    }
    return;
}

function get_post_featured_image() 
{
    if (has_post_thumbnail( $post->ID ) ) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
    }

    return $image[0];
}

function the_content() {
        
    global $post;   
    
    $my_content = get_post_meta($post->ID); 

    return apply_filters('the_content', $my_content);
}



/**
 * Simple function to pretty up our field partial includes.
 *
 * @param  mixed $partial
 * @return mixed
 */
function get_field_partial($partial)
{
    $partial = str_replace('.', '/', $partial);
    return include(config('theme.dir')."/app/fields/{$partial}.php");
}

function filesize_formatted($size)
{
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

function filetype_formatted($file) 
{
    return strtoupper(pathinfo($file, PATHINFO_EXTENSION));
}


function limit_character($text, $length)
{
    if(strlen($text) < $length)
    {
        return $text;
    }
    else
    {
        $text=substr($text,0,$length) . '...';
        return $text;
    }
}


//calender view
function draw_calendar($month,$year, $events){
    // var_dump($events);
    /* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
    $headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
	$calendar.= '<tr class="calendar-row calender-day"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">', $headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
    $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
    $previous_month_days = $month != 1 ? date('t', mktime(0,0,0,$month-1,1,$year)) : date('t', mktime(0,0,0,12,1,$year-1));
    $next_month_days = $month < 12 ? date('t', mktime(0,0,0,$month+1,1,$year)) : date('t', mktime(0,0,0,1,1,$year+1));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
    for($x = $running_day; $x > 0; $x--):
        $day_diff = $previous_month_days - $x;
        $calendar.= '<td class="calendar-day-np days"><div class="day-number">'.$day_diff.'</div>';
        if (count($events) >= 0) {
            for ($count = 1; $count <= count($events); $count++) {
                $eventtitle = strlen($events[$count]['title']) > 25 ? substr($events[$count]['title'], 0, 25).'...' : $events[$count]['title'];
                if ($events[$count]['day'] == $day_diff && $events[$count]['month'] == $month - 1 && $events[$count]['year'] == $year) {
                    $calendar.= '<p class="picked-date hidden md:block"><a href="'.$events[$count]['link'].'">'.$eventtitle.'</a></p>';
                    $calendar.= '<p class="picked-date block md:hidden"><a href="'.$events[$count]['link'].'">'.substr($eventtitle, 0, 3).'...</a></p>';
                } 
            }
            $calendar.='</td>';
        }
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
    for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day  days">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';
            for ($count = 1; $count <= count($events); $count++) {
                $eventtitle = strlen($events[$count]['title']) > 25 ? substr($events[$count]['title'], 0, 25).'...' : $events[$count]['title'];
                if ($events[$count]['day'] == $list_day && $events[$count]['month'] == $month && $events[$count]['year'] == $year) {
                    $calendar.= '<p class="picked-date hidden md:block"><a href="'.$events[$count]['link'].'">'.$eventtitle.'</a></p>';
                    $calendar.= '<p class="picked-date block md:hidden"><a href="'.$events[$count]['link'].'">'.substr($eventtitle, 0, 3).'...</a></p>';
                } 
            }
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row calender-bottom">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
    if($days_in_this_week < 8):
        $month = $month != 12 ? $month + 1 : 1;
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
            $calendar.= '<td class="calendar-day-np days"><div class="day-number">'. $x. '</div>';
            if (count($events) >= 0) {
                for ($count = 1; $count <= count($events); $count++) {
                    $newyear = $events[$count]['year'] == $year ? $year : $year + 1;
                    $eventtitle = strlen($events[$count]['title']) > 25 ? substr($events[$count]['title'], 0, 25).'...' : $events[$count]['title'];
                    if ($events[$count]['day'] == $x && $events[$count]['month'] == $month && $events[$count]['year'] == $newyear) {
                        $calendar.= '<p class="picked-date hidden md:block"><a href="'.$events[$count]['link'].'">'.$eventtitle.'</a></p>';
                        $calendar.= '<p class="picked-date block md:hidden"><a href="'.$events[$count]['link'].'">'.substr($eventtitle, 0, 3).'...</a></p>';
                    } 
                }
                $calendar.='</td>';
            }
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
    $calendar.= '</table>';
	
	return $calendar;
}

function pagination($pages = '', $title, $range = 4)
{
    $showitems = ($range * 2)+1;
 
    global $paged;
    if(empty($paged)) $paged = 1;
 
    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }
    $returnstring = '';
    $addClass = '';
    if(1 != $pages)
    {
        if ($paged > 1 && $paged < $pages) {
            $addClass = 'lg:justify-between';
         }
        $returnstring .= "<div class=\"event-pagination\">
                            <div class=\"events-pagination-link flex justify-center text-center ".$addClass." flex flex-wrap item-center\">";
        if($paged > 1) $returnstring .= "<a href='".get_pagenum_link(1)."'>
        <svg width='6' height='11' style='margin-right: 12px' viewBox='0 0 6 11' fill='none' xmlns='http://www.w3.org/2000/svg'>
        <path d='M4.8583 0L6 1.2925L2.2915 5.5L6 9.7075L4.8583 11L0 5.5L4.8583 0Z' fill='#EF6D1D'/>
        </svg>
        View previous ".$title." </a>";
 
        if ($paged < $pages) $returnstring .= "<a href=\"".get_pagenum_link($paged + 1)."\">View more ".$title." 
        <svg width='9' height='11' viewBox='0 0 9 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
            <path d='M8.56164 8.70711C8.95216 8.31658 8.95216 7.68342 8.56164 7.29289L2.19768 0.928932C1.80715 0.538408 1.17399 0.538408 0.783463 0.928932C0.392939 1.31946 0.392939 1.95262 0.783463 2.34315L6.44032 8L0.783463 13.6569C0.392939 14.0474 0.392939 14.6805 0.783463 15.0711C1.17399 15.4616 1.80715 15.4616 2.19768 15.0711L8.56164 8.70711ZM7 9H7.85453V7H7V9Z' fill='#EF6D1D'/>
        </svg></a>";
        $returnstring .= "</div></div>\n";
    }

    return $returnstring;
}