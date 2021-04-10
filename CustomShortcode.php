<?php

$table =  `{$wpdb->prefix}GoogleForms`;
$FormID = 1; //INCREMENT IN FUTURE WITH FOR LOOP IF $FORMID NOT FOUND THEN $FORMID + 1;

$sql = `SELECT * FROM $table`;

$result = $wpdb->get_results($sql, ARRAY_A);

printf($result);
echo $result;

function sample_shortcode()
{
    return "HELLO TEST ME";
}

//CHANGE GoogleForm to unique name supplied by user SELECTED FROM DATABASE
add_shortcode('GoogleForm', 'sample_shortcode');
