<?php

// Relative dates function, for use with posts and comments    
function time_ago($timestamp, $granularity=1, $format='d-m-Y'){

        $difference = time() - $timestamp;
       
        if($difference < 0) return '0 seconds ago'; // if difference is lower than zero check server offset
        elseif($difference < 126144000){            // if difference is over 4 years ago show normal time form
       
                $periods = array('year' => 31536000,'month' => 2628000,'week' => 604800,'day' => 86400,'hour' => 3600,'minute' => 60,'second' => 1);
                $output = '';
                foreach($periods as $key => $value){
               
                        if($difference >= $value){
                       
                                $time = round($difference / $value);
                                $difference %= $value;
                               
                                $output .= ($output ? ' ' : '').$time.' ';

                                if      ($key == 'second' && $time > 1) { $key = 'seconds'; }
                                elseif  ($key == 'minute' && $time > 1) { $key = 'minutes'; }
                                elseif  ($key == 'hour' && $time > 1)   { $key = 'hours'; }
                                elseif  ($key == 'day' && $time > 1)    { $key = 'days'; }
                                elseif  ($key == 'week' && $time > 1)   { $key = 'weeks'; }
                                elseif  ($key == 'month' && $time > 1)  { $key = 'months'; }
                                else    { $key; }
                                                               
                                $output .= $key;
                                
                                $granularity--;
                        }
                        if($granularity == 0) break;
                }
                return ($output ? $output : '0 seconds').' ago';
        }
        else return date($format, $timestamp);
}